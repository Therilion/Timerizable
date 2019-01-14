<?php

namespace Therilion\Timerizable\Model;

use Illuminate\Database\Eloquent\Model;

class TimeBlock extends Model
{
    protected $fillable = ['name', 'description'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->table = config('timerizable.time_blocks_database', 'time_blocks');
    }

    public function time_intervals() {
        return $this->hasMany('Therilion\Timerizable\Model\TimeInterval')->orderBy('starts_at');
    }

    public function timerizable() {
        return $this->morphTo();
    }
}
