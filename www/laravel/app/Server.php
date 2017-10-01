<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{


    public function streams(){
        return $this->hasMany('App\Stream');
    }

}
