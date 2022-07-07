<?php

namespace App\DataFixtures\Trait;

use DateTimeImmutable;

Trait DateTimeTrait{

    protected function randomDate(string $start_date = '2010-01-01', string $end_date = 'now'):DateTimeImmutable
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);
    
        // Generate random number using above bounds
        $val = rand($min, $max);
    
        // Convert back to desired date format
        return new DateTimeImmutable(date('Y-m-d H:i', $val));
    }

}