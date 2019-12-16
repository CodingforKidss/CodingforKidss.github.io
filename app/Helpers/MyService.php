<?php

if (!function_exists('seconds_to_time')) {
    function seconds_to_time($seconds, $format) {
        $zero   = new \DateTime('@0');
        $offset = new \DateTime("@$seconds");
        $diff   = $zero->diff($offset);
        return sprintf($format, $diff->days * 24 + $diff->h, $diff->i, $diff->s);
    }
}
if (!function_exists('random_str')) {
    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $pieces = [];
        $max    = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }
}
if (!function_exists('file_type_from_type')) {
    function file_type_from_type($type) {
        $imageTypeArray = array(
            0  => 'UNKNOWN',
            1  => 'GIF',
            2  => 'JPEG',
            3  => 'PNG',
            4  => 'SWF',
            5  => 'PSD',
            6  => 'BMP',
            7  => 'TIFF_II',
            8  => 'TIFF_MM',
            9  => 'JPC',
            10 => 'JP2',
            11 => 'JPX',
            12 => 'JB2',
            13 => 'SWC',
            14 => 'IFF',
            15 => 'WBMP',
            16 => 'XBM',
            17 => 'ICO',
            18 => 'COUNT'
        );

        return $imageTypeArray[$type];
    }
}
