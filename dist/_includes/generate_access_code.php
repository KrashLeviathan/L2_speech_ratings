<?php
function generateAccessCode($length, $withDash = true)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        if ($withDash && $i !== 0 && ($i % 4 === 0)) {
            $string .= '-';
        }
        $string .= $characters[mt_rand(0, $max)];
    }
    return $string;
}
