<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $primaryKey = 'tank_id';
    protected $fillable = ['tank_id', 'exp_tank_id', 'name'];

    public function expected_tank_values(){
        return $this->belongsTo( 'App\Expected_tank_values', 'exp_tank_id', 'IDNum');
    }
}
