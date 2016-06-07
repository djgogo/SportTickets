<?php
declare(strict_types=1);

class CsvBackend
{
    /**
     * @var string
     */
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function writeCsvFile(array $row) : bool
    {
        $file = fopen($this->path,"a");
        if ($file != false) {
            fputcsv($file, $row, ';');
            return true;
        }
        fclose($file);
        return false;
    }

    public function outputHeader(string $header)
    {
        $file = fopen($this->path,"c");
        fputs($file, $header);
        fclose($file);
    }
}

