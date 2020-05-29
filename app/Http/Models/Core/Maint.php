<?php

namespace App\Models\Core;

use Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Maint extends Eloquent{
  
     public static function boot()
     {
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();          
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
            $model->version = 0;
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });      
    }
  
}
