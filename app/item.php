<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    public function medicine()
    {
        return $this->belongsTo('App\medicine');
    }
    public function source()
    {
        return $this->belongsTo('App\source');
    }
}
