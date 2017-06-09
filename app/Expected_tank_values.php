<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expected_tank_values extends Model
{
    protected $primaryKey = 'IDNum';
    protected $fillable = ['IDNum', 'expFrag', 'expDamage', 'expSpot', 'expDef', 'expWinRate', 'name'];

    public function tanks(){
        return $this->hasMany('App\Tank', 'exp_tank_id', 'IDNum');
    }
}
