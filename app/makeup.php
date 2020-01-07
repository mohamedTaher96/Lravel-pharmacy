<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class makeup extends Model
{
    public function makeupItems()
    {
        return $this->hasMany('App\makeupItem');
    }
}
