<?php

# USAGE: php common.php 28 1001

$problem = $_SERVER['argv'][1];
$arg = $_SERVER['argv'][2];

require 'p' . $problem . '.php';
$func = 'p' . $problem;
echo $func($arg) . "\n";