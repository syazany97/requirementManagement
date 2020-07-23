<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class CustomMedia extends BaseMedia
{

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
        });
    }
}
