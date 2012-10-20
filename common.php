<?php

# USAGE: php p<problem_number>.php <argument_to_problem>
# EXAMPLE: php p28.php 1001 --recursive

$problem = array_shift(sscanf($_SERVER['argv'][0], 'p%d.php'));
$arg = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null;
$recursive = !empty($_SERVER['argv'][2]) && $_SERVER['argv'][2] == '--recursive';

if ($arg) {
    ini_set('xdebug.max_nesting_level', (int)$arg || 2000);
}

$func = 'p' . $problem . ($recursive ? '_recursive' : '');
echo ($arg ? $func($arg) : $func()) . "\n";