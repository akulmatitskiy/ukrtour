<?php

/**
 * Shedule
 */

// search indexing
$schedule->command('search/indexing')->daily();
//$schedule->command('search/indexing')->cron('* * * * *');

// Clear cache
$schedule->command('cache/flush-all')->daily();

