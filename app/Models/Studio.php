<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studios';

    // melakukan relasi dengan table movies
    public function movies(){
        //return $this->hasMany('App\Models\Movie', 'id', 'movies_id');
        return $this->belongsTo('App\Models\Movie', 'movies_id', 'id');
    }
}
