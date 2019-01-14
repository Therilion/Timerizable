<?php
namespace Therilion\Timerizable\Traits;

/**
 * Trait para incluir en los modelos que utilizarán timerizable
 */
trait Timerizable
{

    public function __construct(array $attr = []) 
    {
        parent::__construct($attr);
        $this->setAppends();
    }

    public function setAppends()
    {
        $appends = ['in_time'];
        $this->appends = array_merge($this->appends, $appends);
    }

    public function time_block() 
    {
        return $this->morphMany('App\TimeBlock', 'timerizable');
    }

    public function inTime() 
    {
        $now = Carbon\Carbon::createFromDate(1000,1,1);
        foreach($this->time_block->time_intervals as $interval) {
            if($now->between($interval->carbon_starts_at, $interval->carbon_ends_at)){
                return true;
            }
        }
        return false;
    }

    public function getInTimeAttribute()
    {
        return $this->inTime();
    }
    
}
