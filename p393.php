<?php

ini_set('max_execution_time', 0);
ini_set('xdebug.max_nesting_level', 300);

require 'common.php';

function dfs_recursive(&$n, $start_i=0) {

    $s = $n*$n;
    static $sols = array();
    static $pre = array();
    static $post = array();
    static $func = __FUNCTION__;

    for ($i=$start_i; $i < $s; $i++) {

        // check if ant can move up
        if ($i >= $n && empty($post[$i-$n]) && @$pre[$i-$n] != 'd') {
            $pre[$i] = $post[$i-$n] = 'u';
            $func($n, $i+1);
            unset($pre[$i]); unset($post[$i-$n]);
        }

        // check if ant can move down
        if ($i < ($s-$n) && empty($post[$i+$n]) && @$pre[$i+$n] != 'u') {
            $pre[$i] = $post[$i+$n] = 'd';
            $func($n, $i+1);
            unset($pre[$i]); unset($post[$i+$n]);
        }

        // check if ant can move left
        if ($i % $n != 0 && empty($post[$i-1]) && @$pre[$i-1] != 'r') {
            $pre[$i] = $post[$i-1] = 'l';
            $func($n, $i+1);
            unset($pre[$i]); unset($post[$i-1]);
        }

        // check if ant can move right
        if (($i % $n) != ($n-1) && empty($post[$i+1]) && @$pre[$i+1] != 'l') {
            $pre[$i] = $post[$i+1] = 'r';
            $func($n, $i+1);
            unset($pre[$i]); unset($post[$i+1]);
        }

        if ($i != ($s-1)) {
            return $sols;
        }

    }

    if (count($pre) == $s) {
        for ($i=0; $i < $s; $i++) {
            @$sol[$pre[$i]]++;
        }
        ksort($sol);
        @$sols[implode(',', $sol)]++;
    }

}

function dfs($n=4) {

    $i = $total = 0;
    $s = $n*$n;
    $pre = $post = $sols = $tried = array();

    while (true) {

        // check if ant can move up
        if (!@$tried[$i]['u'] && $i >= $n && !@$post[$i-$n] && @$pre[$i-$n] != 'd') {
            $pre[$i] = $post[$i-$n] = 'u';
            $tried[$i]['u'] = true;
            $i++; continue;
        }

        // check if ant can move down
        if (!@$tried[$i]['d'] && $i < ($s-$n) && !@$post[$i+$n] && @$pre[$i+$n] != 'u') {
            $pre[$i] = $post[$i+$n] = 'd';
            $tried[$i]['d'] = true;
            $i++; continue;
        }

        // check if ant can move left
        if (!@$tried[$i]['l'] && $i % $n != 0 && !@$post[$i-1] && @$pre[$i-1] != 'r') {
            $pre[$i] = $post[$i-1] = 'l';
            $tried[$i]['l'] = true;
            $i++; continue;
        }

        // check if ant can move right
        if (!@$tried[$i]['r'] && ($i % $n) != ($n-1) && !@$post[$i+1] && @$pre[$i+1] != 'l') {
            $pre[$i] = $post[$i+1] = 'r';
            $tried[$i]['r'] = true;
            $i++; continue;
        }

        if ($i == $s) {
            $sol = array();
            for ($j=0; $j < $s; $j++) {
                $key = $pre[$j];
                $sol[$key] = !isset($sol[$key]) ? 1 : ($sol[$key]+1);
            }
            ksort($sol);
            $key = implode(',', $sol);
            $sols[$key] = !isset($sols[$key]) ? 1 : ($sols[$key]+1);
        }

        $tried[$i] = array();

        if (--$i < 0) {
            return $sols;
        }

        // cleanup
        if ($pre[$i] == 'u') {
            unset($post[$i-$n]);
        } elseif ($pre[$i] == 'd') {
            unset($post[$i+$n]);
        } elseif ($pre[$i] == 'l') {
            unset($post[$i-1]);
        } elseif ($pre[$i] == 'r') {
            unset($post[$i+1]);
        }
        unset($pre[$i]);
        
    }

}

function p393_recursive($n=4) {
    print_r($sols = get_solution($n, true));
    return array_sum($sols);  
}

function p393($n=4) {
    print_r($sols = get_solution($n, false));
    return array_sum($sols);  
}

function get_solution($n=4, $recursive) {
    $func = $recursive ? 'dfs_recursive' : 'dfs';
    return ($n % 2 == 1) ? array() : array_merge(array('d,l,r,u' => 0), $func($n));
}

// An nxn grid of squares contains n^2 ants, one ant per square.
// All ants decide to move simultaneously to an adjacent square (usually 4 possibilities, except for ants on the edge of the grid or at the corners).
// We define f(n) to be the number of ways this can happen without any ants ending on the same square and without any two ants crossing the same edge between two squares.
// 
// You are given that f(4) = 88.
// Find f(10).