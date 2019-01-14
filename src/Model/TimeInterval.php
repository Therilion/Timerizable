<?php

namespace Therilion\Timerizable\Model;

use Illuminate\Database\Eloquent\Model;

class TimeInterval extends Model
{
    protected $fillable = ['starts_at', 'ends_at',];
    public $timestamps = false;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->table = config('timerizable.time_intervals_database', 'time_intervals');
    }

    public function time_block() {
        return $this->belongsTo('Therilion\Timerizable\Mode\TimeBlock');
    }

    public function getCarbonStartsAtAttribute() {
        $time = explode(':', $this->starts_at);
        return \Carbon\Carbon::create(1000, 1, 1, $time[0], $time[1]);
    }
    
    public function getCarbonEndsAtAttribute() {
        $time = explode(':', $this->ends_at);
        return \Carbon\Carbon::create(1000, 1, 1, $time[0], $time[1]);
    }
}
