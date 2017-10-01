<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    public function interval()
    {
        return $this->belongsTo('App\Interval');
    }
}
