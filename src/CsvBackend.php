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
    public function writeDataToCsv(string $header, array $row)
    {
        if(!file_exists($this->path)) {
            $this->outputHeader($header);
        }

        $file = fopen($this->path,'a');
        if ($file !== false) {
            $lengthOfWrittenString = fputcsv($file, $row, ';');
            if ($lengthOfWrittenString === false) {
                throw new CsvBackendException('Datensatz konnte nicht gespeichert werden');
            }
            $close = fclose($file);
            if ($close === false) {
                throw new CsvBackendException('Datei "' . $this->path . '" konnte nicht geschlossen werden');
            }
            return;
        }

        $close2 = fclose($file);
        if ($close2 === false) {
            throw new CsvBackendException('Datei "' . $this->path . '" konnte nicht geschlossen werden');
        }
    }

    /**
     * @param string $header
     * @throws CsvBackendException
     */
    private function outputHeader(string $header)
    {
        $file = @fopen($this->path,'c');
        if ($file === false) {
            throw new CsvBackendException('Datei "' . $this->path . '" konnte nicht geöffnet werden');
        }

        $amountOfWrittenBytes = fputs($file, $header);
        if ($amountOfWrittenBytes === false) {
            throw new CsvBackendException('Datensatz konnte nicht gespeichert werden');
        }

        $close = fclose($file);
        if ($close === false) {
            throw new CsvBackendException('Datei "' . $this->path . '" konnte nicht geschlossen werden');
        }
    }
}

