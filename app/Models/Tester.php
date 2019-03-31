<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * Class Tester
 * @package App\Models
 *
 * @property string $uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Tester extends Model
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_tester')
            ->withPivot('result', 'created_at', 'updated_at');
    }
}
