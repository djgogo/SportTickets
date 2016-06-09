<?php
declare(strict_types = 1);

/**
 * @covers \SportTicketsFormCommand
 * @uses \Request
 * @uses \CsvBackend
 * @uses \TheSeer\fDOM\fDOMDocument
 * @uses \Email
 * @uses \PhoneNumber
 */
class SportTicketsFormCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var CsvBackend
     */
    private $csvBackend;
    /**
     * @var \TheSeer\fDOM\fDOMDocument
     */
    private $dataModel;
    /**
     * @var SportTicketsFormCommand
     */
    private $sportTicketsFormCommand;

    public function setUp()
    {
        $this->request = $this->getRequest();
        $this->csvBackend = $this->getMockBuilder(CsvBackend::class)->disableOriginalConstructor()->getMock();
        $this->dataModel = new \TheSeer\fDOM\fDOMDocument();
        $this->dataModel->load('prototypes/formValidation.xml');

        $this->sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $this->request, $this->dataModel);
    }

    /**
     * @dataProvider formFieldProvider
     * @param $fieldToEmpty
     * @param $expectedErrorMessage
     */
    public function testEmptyFormFieldTriggersError($fieldToEmpty, $expectedErrorMessage)
    {
        $requestArray = $this->getValidRequestArray();
        $requestArray[$fieldToEmpty] = '';

        $this->sportTicketsFormCommand->validateRequest();

        $this->assertEquals($expectedErrorMessage,
            $this->dataModel->queryOne('//field[@name="' . $fieldToEmpty . '"]/error')->nodeValue);
    }

    /**
     * @return array
     */
    public function formFieldProvider() : array
    {
        return [
            ['name', 'Bitte geben sie einen Namen ein'],
            ['vorname', 'Bitte geben sie einen Vornamen ein'],
            ['strasse', 'Bitte geben sie einen Strassen Namen ein'],
            ['plz', 'Bitte geben sie die Postleitzahl ein'],
            ['ort', 'Bitte geben sie den Ort ein'],
            ['phone', 'Bitte geben sie eine Telefon-Nummer ein'],
            ['email', 'Bitte geben sie eine Email Adresse ein'],
            ['sportart', 'Bitte wählen Sie eine Sportart aus'],
            ['anzahl', 'Bitte geben sie die Anzahl Tickets ein'],
        ];
    }

    private function getValidRequestArray() : array
    {
        return [
            'anrede' => 'Herr',
            'name' => 'Muster',
            'vorname' => 'Hans',
            'strasse' => 'Street',
            'plz' => '1111',
            'ort' => 'Walhalla',
            'phone' => '011111111',
            'email' => 'example@example.org',
            'anzahl' => '99',
        ];
    }

    private function getRequest() : Request
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['anrede'] = 'Herr';
        $_POST['name'] = 'Muster';
        $_POST['vorname'] = 'Hans';
        $_POST['strasse'] = 'Street';
        $_POST['plz'] = '1111';
        $_POST['ort'] = 'Walhalla';
        $_POST['phone'] = '011111111';
        $_POST['email'] = 'example@example.org';
        $_POST['anzahl'] = '99';

        return new PostRequest($_POST);
    }
}
