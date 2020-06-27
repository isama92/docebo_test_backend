<?php

/**
 * Dump a variable, testing purpose
 * @param mixed $v Value to dump
 * @param bool $die If die is true then exit the app
 */
function dump($v, $die = false)
{
    echo '<pre>';
    var_dump($v);
    echo '</pre>';

    if($die) {
        exit;
    }
}
