<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class source extends Model
{
    public function items()
    {
        return $this->hasMany('App\item');
    }
}
