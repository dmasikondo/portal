<?php
/**
 * Created by PhpStorm.
 * User: Tapiwanashe
 * Date: 29/01/2019
 * Time: 14:19
 */

function displayMoney($amount)
{
    $sign = ($amount < 0) ? "-" : "";
    return $sign . "$" . number_format(abs($amount), 2);
}

function zeroPadNumber($str, $length)
{
    return str_pad($str, $length, "0", STR_PAD_LEFT);
}