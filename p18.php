<?php

require 'common.php';

function p18($input_file='p18a.txt') {

    $graph = process_file($input_file);
    $length_to = $path_to = array('0:0' => $graph[0][0]);

    foreach ($graph as $i => $row) {
        foreach ($row as $j => $node) {
            
            $id = "$i:$j";
            $l_id = ($i+1) . ':' . ($j);
            $r_id = ($i+1) . ':' . ($j+1);
            $l_weight = isset($graph[$i+1][$j]) ? $graph[$i+1][$j] : 0;
            $r_weight = isset($graph[$i+1][$j+1]) ? $graph[$i+1][$j+1] : 0;

            if (isset($graph[$i+1][$j])) {
                $length_to[$l_id] = isset($length_to[$l_id]) ? $length_to[$l_id] : $graph[0][0];
                $length_to[$r_id] = isset($length_to[$r_id]) ? $length_to[$r_id] : $graph[0][0];
                $path_to[$l_id] = isset($path_to[$l_id]) ? $path_to[$l_id] : $graph[0][0];
                $path_to[$r_id] = isset($path_to[$r_id]) ? $path_to[$r_id] : $graph[0][0];
            
                if ($length_to[$l_id] < $length_to[$id] + $l_weight) {
                    $length_to[$l_id] = $length_to[$id] + $l_weight;
                    $path_to[$l_id] = $path_to[$id] . ' + ' . $l_weight;
                }

                if ($length_to[$r_id] < $length_to[$id] + $r_weight) {
                    $length_to[$r_id] = $length_to[$id] + $r_weight;
                    $path_to[$r_id] = $path_to[$id] . ' + ' . $r_weight;
                }
            }
        }
    }

    arsort($length_to);
    list($k, $v) = each($length_to);

    echo 'Max: ' . $path_to[$k] . ' = ' . $v;
}

function p18_recursive($input_file='p18a.txt') {

    $graph = process_file($input_file);
    $func = __FUNCTION__ . '_best_path';
    $results = array_pop($func($graph));

    arsort($results);
    list($k, $v) = each($results);
    echo 'Best: ' . $k . ' = ' . $v;
    
}

function p18_recursive_best_path(&$graph, $i=0, $j=0, $path='', $length=0, &$results=array()) {

    $new_path = $path . (!empty($path) ? ' + ' : '') . $graph[$i][$j];
    $new_length = $length + $graph[$i][$j];
    $func = __FUNCTION__;

    if (isset($graph[$i+1][$j])) {
        list($path, $length) = $func($graph, $i+1, $j, $new_path, $new_length, $results);
        if (isset($graph[$i+1][$j+1])) {
            list($path, $length) = $func($graph, $i+1, $j+1, $new_path, $new_length, $results);
        }
    } else {
        $results[$new_path] = $new_length;
    }

    return array($new_path, $new_length, $results);

}

// parses the input file and returns a graph as a 2d array
function process_file($input_file) {
    foreach (file($input_file) as $line) {
        $graph[] = array_filter(preg_split('/\s+/', $line));
     }
    return $graph;
}