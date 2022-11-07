<?php

namespace App\Traits;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                if(backpack_user()){
                    $model->created_by = backpack_user()->id;
                }
            }
            if (!$model->isDirty('updated_by')) {
                if(backpack_user()){
                    $model->updated_by = backpack_user()->id;
                }
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                if(backpack_user()){
                    $model->updated_by = backpack_user()->id;
                }
            }
        });
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}