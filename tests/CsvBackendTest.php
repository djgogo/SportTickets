<?php
declare(strict_types = 1);

/**
 * @covers CsvBackend
 */
class CsvBackendTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $header;
    /**
     * @var CsvBackend
     */
    private $csvBackend;
    /**
     * @var array
     */
    private $row;

    public function setUp()
    {
        $this->path = '/var/www/petersacco.ch/tests/testdata/test.csv';
        $this->header = "Anrede;Name;Vorname;Strasse;PLZ;Ort;Telefon;Email;Sportart;Anzahl\n";

        $this->row = [
            'Herr',
            'Muster',
            'Hans',
            'Strasse',
            '1111',
            'Zuerich',
            '0111111111',
            'hans@muster.ch',
            'Handball',
            '5',
        ];

        $this->csvBackend = new CsvBackend($this->path);
    }

    public function testFileCannotBeOpenedThrowsException()
    {
        $this->expectException('Exception');

        $invalidPath = '/var/www/petersacco.ch/wrong/wrong.csv';
        $invalidCsvBackend = new CsvBackend($invalidPath);

        $this->assertFalse($invalidCsvBackend->writeDataToCsv($this->header, $this->row));
    }

    public function testHeaderAndRowCanBeWritten()
    {
        $this->csvBackend->writeDataToCsv($this->header, $this->row);
        $this->assertTrue(file_exists($this->path));

        $expectedContent = implode(';', $this->row);
        $expectedContent = $this->header . $expectedContent . "\n";
        $content = file_get_contents($this->path);
        unlink($this->path);

        $this->assertEquals($expectedContent, $content);
    }
}
