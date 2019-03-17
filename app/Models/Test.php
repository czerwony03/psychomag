<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Test
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $order
 */
class Test extends Model
{
    public const TEST_STROOP_1 = 'stroop1';
    public const TEST_STROOP_2 = 'stroop2';
    public const TEST_STROOP_3 = 'stroop3';
    public const TEST_STROOP_4 = 'stroop4';
    public const TEST_TMT_A = 'tmt_a';
    public const TEST_TMT_B = 'tmt_b';
    public const TEST_GO_NOGO_1 = 'go_nogo1';
    public const TEST_GO_NOGO_2 = 'go_nogo2';
    public const TEST_WCST = 'wcst';

    protected $fillable = [
        'name', 'code', 'order'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class,'user_test');
    }
}
