<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'songs' => 'array'
    ];

    public function owner()
    {
        $this->belongsTo('App\User');
    }

    public function contributors()
    {
        $this->hasMany('App\User');
    }
}
