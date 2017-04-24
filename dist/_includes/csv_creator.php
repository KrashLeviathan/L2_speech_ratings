<?php

class CsvCreator
{
    var $file;
    var $errorMsg;

    function __construct($filepath, $filename)
    {
        $fullFilepath = $_SERVER['DOCUMENT_ROOT'] . $filepath . $filename;
        // Make sure file doesn't already exist
        if (is_file($fullFilepath)) {
            $this->errorMsg = "Filename already exists!";
            return;
        }

        // Create a new file (implicitly)
        $this->file = fopen($fullFilepath, 'w')
        or $this->errorMsg = 'Cannot open file:  ' . $filepath . $filename;
    }

    function append($fieldArray)
    {
        if (!isset($this->errorMsg)) {
            // Append data to the file
            fputcsv($this->file, $fieldArray);
        }
    }

    function hasError()
    {
        return isset($this->errorMsg);
    }

    function __destruct()
    {
        if (!isset($this->errorMsg)) {
            // Close the file
            fclose($this->file);
        }
    }
}
