<?php

return [
    // Database configurations. Used by model and migrations. 
    'time_blocks_database'    => 'time_blocks',
    'time_intervals_database' => 'time_intervals',
    
    // Web Controllers route redirects
    'web'                     => [
        'time_blocks_delete'    => 'home',
        'time_blocks_store'     => 'home',
        'time_blocks_update'    => 'home',
        'time_intervals_delete' => 'home',
        'time_intervals_update' => 'home',
        'time_intervals_store'  => 'home',
    ],

    // Api configs
    'api'                     => [
        'time_blocks_paginate'    => 0,
        'time_intervals_paginate' => 0,
    ],


];