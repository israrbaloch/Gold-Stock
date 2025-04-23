<?php

namespace App\Models;

use App\Http\Controllers\MailTemplateController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;
use Mail;

class SchedulerUser extends Model {
    use HasFactory;

    protected $fillable = [
        'scheduler_id',
        'user_id',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function scheduler() {
        return $this->belongsTo(Scheduler::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sendMail() {
        if ($this->status != 'in progress') {
            $this->status = 'in progress';
            $this->save();
        }

        try {
            $template = MailTemplate::where('id', $this->scheduler->template_id)->first();
            $properties = MailTemplateProperty::where('mail_template_id', '=', $template->id)
                ->get();

            $_properties = [];
            foreach ($properties as $property) {
                $_properties[$property->name] = MailTemplateController::getPropertyData([
                    'type' => $property->type,
                    'value' => $property->value,
                ]);
            }
            Log::debug($properties);
            $instance = app($template->template, ['data' => $_properties]);
            $instance->subject($template->subject);
            Log::info('Sending mail "' . $template->subject . '" to ' . $this->user->email);
            Mail::to($this->user->email)->queue($instance);
            $this->status = 'sent';
            $this->sent_at = now();
        } catch (\Throwable $th) {
            Log::error($th);
            $this->status = 'failed';
            $this->attempts += 1;
            $this->sent_at = now()->addMinutes(5);
        }
        $this->save();
    }
}
