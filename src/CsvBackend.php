<?php
declare(strict_types=1);

class CsvBackend
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param string $header
     * @param array $row
     * @return bool
     * @throws CsvBackendException
     */
    public function writeDataToCsv(string $header, array $row) : bool
    {
        if(!file_exists($this->path)) {
            $this->outputHeader($header);
        }

        $file = fopen($this->path,'a');
        if ($file != false) {
            fputcsv($file, $row, ';');
            fclose($file);
            return true;
        }

        fclose($file);
        return false;
    }

    /**
     * @param string $header
     * @throws CsvBackendException
     */
    private function outputHeader(string $header)
    {
        $file = @fopen($this->path,'c');
        if ($file == false) {
            throw new CsvBackendException('Datei "' . $this->path . '" konnte nicht geöffnet werden');
        }

        fputs($file, $header);
        fclose($file);
    }
}

