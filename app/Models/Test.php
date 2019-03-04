<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name', 'code'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class,'user_test');
    }
}
