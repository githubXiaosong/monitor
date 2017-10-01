<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    public function collect_current_interval()
    {
        return $this->belongsTo('App\Interval','collect_current_interval_id');
    }

    public function collect_global_interval()
    {
        return $this->belongsTo('App\Interval','collect_global_interval_id');
    }

    public function online_interval()
    {
        return $this->belongsTo('App\Interval','online_interval_id');
    }

    public function validate_cycle()
    {
        return $this->belongsTo('App\Validate_cycle','validate_cycle_id');
    }

}
