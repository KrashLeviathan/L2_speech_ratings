<?php

// Parses data from the audio filename
class FilenameParser
{
    // Language (refers to the target language or L2): l1, l2, l3, l4, etc. (typically I
    // only deal with Spanish, or Spanish and French, so at this stage it could simply
    // be 'sp' and 'fr')
    var $language;
    const LANGUAGES = array('sp' => 'Spanish', 'fr' => 'French');

    // Level (refers to the course in which the participant is enrolled at the outset of
    // the study): 101, 102, 201, 202, 300, 400
    var $level;
    const LEVELS = array('101', '102', '201', '202', '300', '400');

    // ID (refers to the subject/participant): 1, 2, 3, 4, 5, 6, etc.
    var $id;

    // Wave (refers to data collection session/wave): w1, w2, w3, w4, etc.
    var $wave;

    // Task (refers to the specific speaking task): t1, t2, t3, t4, etc.
    var $task;

    // Item (refers to the items within each task; can be used for subgrouping by phonetic
    // features): i1, i2, i3, i4, etc.
    var $item;

    // For tokens that don't match any of the above categories
    var $errorTokens = array();

    function __construct($filename)
    {
        $nameAndExtension = explode('.', $filename);
        $tokens = explode('_', $nameAndExtension[0]);
        foreach ($tokens as $token) {
            if ($token[0] === 'l' || $token[0] === 'L') {

                // Language
                if (!isset($this->language)) {
                    $this->language = strtolower($token);
                } else {
                    array_push($this->errorTokens, $token . ' : Language already set!');
                }

            } else if ($token[0] === 'w' || $token[0] === 'W') {

                // Wave
                if (!isset($this->wave)) {
                    $this->wave = substr($token, 1);
                } else {
                    array_push($this->errorTokens, $token . ' : Wave already set!');
                }

            } else if ($token[0] === 't' || $token[0] === 'T') {

                // Task
                if (!isset($this->task)) {
                    $this->task = substr($token, 1);
                } else {
                    array_push($this->errorTokens, $token . ' : Task already set!');
                }

            } else if ($token[0] === 'i' || $token[0] === 'I') {

                // Item
                if (!isset($this->item)) {
                    $this->item = substr($token, 1);
                } else {
                    array_push($this->errorTokens, $token . ' : Item already set!');
                }

            } else if (ctype_digit($token)) {

                // Level
                if (!isset($this->level)) {
                    foreach (self::LEVELS as $LEVEL) {
                        if ($token === $LEVEL) {
                            $this->level = $token;
                            break;
                        }
                    }
                    if (isset($this->level)) {
                        continue;
                    }
                }

                if (!isset($this->id)) {
                    $this->id = $token;
                } else {
                    array_push($this->errorTokens, $token . ' : Id already set! ' .
                        'Level doesn\'t match known levels or is already set!');
                }

            } else if (!isset($this->language)) {

                // Language
                foreach (self::LANGUAGES as $LANGUAGE => $_) {
                    if (strtolower($token) === $LANGUAGE) {
                        $this->language = $LANGUAGE;
                        break;
                    }
                }

                if (!isset($this->language)) {
                    // Not a language
                    array_push($this->errorTokens, $token . ' : Unknown token!');
                }
            } else {
                array_push($this->errorTokens, $token . ' : Unknown token, or Language already set!');
            }
        }
    }

    function hasErrors()
    {
        return !empty($this->errorTokens);
    }
}
