<?php

# We boiled the problem down to a formula for the sum of corners of a generic nxn
# square. Since the top right corner is always n^2, the top left corner is n^2 - (n-1),
# etc, you can summarize the sum of corners with the formula: 4n^2 -6n + 6. You can then
# calculate the sum for a given nxn square by recursively summing the sum of the corners
# for the nxn square + the sum of the diagonals in the square of size (n-2)x(n-2). Base
# case is when n==1, return a

# Analytical soluton obtained from http://www.mathblog.dk/project-euler-28-sum-diagonals-spiral/

#f (n) = 16/3*n^3 + 10*n^2 + 26/3*n + 1
function p28($n) {
    $n = (int)$n;
    // ensure $n is odd
    if ($n % 2 != 1) {
        die("invalid input\n");
    }
    $n = ($n - 1) / 2;
    if ($n == 1) {
        return 1;
    }
    return 16/3*pow($n,3) + 10*pow($n,2) + 26/3*$n + 1;
}

// recursive solution
function p28_rec($n) {
    ini_set('xdebug.max_nesting_level', $n);
    if ($n == 1) {
        return 1;
    }
    $func = __FUNCTION__;
    return 4*pow($n,2) - (6*$n) + 6 + $func($n-2);
}