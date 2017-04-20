<?php

// Modified the snippet at http://snipplr.com/view/285/

/**
 * Returns the millisecond duration of the file
 * @param $file
 * @return int
 */
function wavDur($file)
{
    $fp = fopen($file, 'r');
    if (fread($fp, 4) == "RIFF") {
        fseek($fp, 20);
        $rawheader = fread($fp, 16);
        $header = unpack('vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits', $rawheader);
        $pos = ftell($fp);
        while (fread($fp, 4) != "data" && !feof($fp)) {
            $pos++;
            fseek($fp, $pos);
        }
        $rawheader = fread($fp, 4);
        $data = unpack('Vdatasize', $rawheader);
        $ms = (int)($data['datasize'] * 1000 / $header['bytespersec']);
        return $ms;
        // Below is the original snippet code
//        $sec = $data['datasize'] / $header['bytespersec'];
//        $minutes = intval(($sec / 60) % 60);
//        $seconds = intval($sec % 60);
//        return str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);

    }
}
