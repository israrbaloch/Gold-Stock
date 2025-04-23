<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class IdentificationMailAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Send Identification Mail';
    }

    public function getIcon()
    {
        return 'voyager-file-text';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning pull-right custom-action',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.send.identification.mail', ['user_id' => $this->data->{$this->data->getKeyName()}]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users';
    }
}
