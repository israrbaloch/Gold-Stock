<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class IdentificationAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Verify Documents';
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
            'class' => 'btn btn-sm btn-success pull-right custom-action',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.identifications.user', ['user_id' => $this->data->{$this->data->getKeyName()}]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users';
    }
}
