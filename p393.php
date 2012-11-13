<?php

ini_set('max_execution_time', 0);
ini_set('xdebug.max_nesting_level', 300);

require 'common.php';

 class P393 {

    public function __construct($n) {
        $this->n = $n;
        $this->pre = array();
        $this->post = array();
        $this->sols = array();
    }

    public function solve() {
        if ($this->n % 2 == 1) {
            return array();
        }
        $this->depth_first_search();
        return $this->sols;
    }

    public function depth_first_search($start_i=0) {

        $n = $this->n;
        $s = $n*$n;

        for ($i=$start_i; $i < $s; $i++) {

            if (isset($this->pre[$i])) {
                continue;
            }

            // check if ant can move up
            if ($i >= $n && empty($this->post[$i-$n]) && @$this->pre[$i-$n] != 'd') {
                $this->pre[$i] = $this->post[$i-$n] = 'u';
                $this->depth_first_search($i+1);
                unset($this->pre[$i]); unset($this->post[$i-$n]);
            }

            // check if ant can move down
            if ($i < ($s-$n) && empty($this->post[$i+$n]) && @$this->pre[$i+$n] != 'u') {
                $this->pre[$i] = $this->post[$i+$n] = 'd';
                $this->depth_first_search($i+1);
                unset($this->pre[$i]); unset($this->post[$i+$n]);
            }

            // check if ant can move left
            if ($i % $n != 0 && empty($this->post[$i-1]) && @$this->pre[$i-1] != 'r') {
                $this->pre[$i] = $this->post[$i-1] = 'l';
                $this->depth_first_search($i+1);
                unset($this->pre[$i]); unset($this->post[$i-1]);
            }

            // check if ant can move right
            if (($i % $n) != ($n-1) && empty($this->post[$i+1]) && @$this->pre[$i+1] != 'l') {
                $this->pre[$i] = $this->post[$i+1] = 'r';
                $this->depth_first_search($i+1);
                unset($this->pre[$i]); unset($this->post[$i+1]);
            }

            if ($i != ($s-1)) {
                return;
            }

        }

        if (count($this->pre) == $s) {
            for ($i=0; $i < $s; $i++) {
                @$sol[$this->pre[$i]]++;
            }
            ksort($sol);
            @$this->sols[implode(',', $sol)]++;
        }

    }

}

function p393($n=4) {

    $c = new P393($n);
    $sols = array_merge(array('d,l,r,u' => 0), $c->solve());
    print_r($sols);
    return array_sum($sols);
    
}

