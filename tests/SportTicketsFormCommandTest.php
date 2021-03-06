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
     * @var PHPUnit_Framework_MockObject_MockObject
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
    /**
     * @var Request
     */
    private $request;

    public function setUp()
    {
        $this->csvBackend = $this->getMockBuilder(CsvBackend::class)->disableOriginalConstructor()->getMock();
        $this->dataModel = new \TheSeer\fDOM\fDOMDocument();
        $this->dataModel->load(__DIR__.'/../prototypes/formValidation.xml');

        $this->request = $this->getValidRequestArray();
        $this->request = new PostRequest($this->request);
        $this->sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $this->request, $this->dataModel);
    }

    /**
     * @dataProvider formFieldProvider
     * @param $fieldToEmpty
     * @param $expectedErrorMessage
     */
    public function testEmptyFormFieldTriggersError($fieldToEmpty, $expectedErrorMessage)
    {
        $request = $this->getValidRequestArray();
        $request[$fieldToEmpty] = '';
        $request = new PostRequest($request);

        $sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $request, $this->dataModel);
        $sportTicketsFormCommand->validateRequest();

        $this->assertEquals($expectedErrorMessage,
            $this->dataModel->queryOne('//field[@name="'. $fieldToEmpty .'"]/error')->nodeValue);
    }

    /**
     * @dataProvider invalidNumberProvider
     */
    public function testInvalidPLZTriggersError($number)
    {
        $expectedErrorMessage = 'Bitte geben sie eine gültige Postleitzahl ein';
        $request = $this->getValidRequestArray();
        $request['plz'] = $number;
        $request = new PostRequest($request);

        $sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $request, $this->dataModel);
        $sportTicketsFormCommand->validateRequest();

        $this->assertEquals($expectedErrorMessage,
            $this->dataModel->queryOne('//field[@name="plz"]/error')->nodeValue);
    }

    /**
     * @dataProvider invalidNumberProvider
     */
    public function testInvalidAnzahlTriggersError($number)
    {
        $expectedErrorMessage = 'Bitte geben sie eine gültige Anzahl Tickets ein';
        $request = $this->getValidRequestArray();
        $request['anzahl'] = $number;
        $request = new PostRequest($request);

        $sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $request, $this->dataModel);
        $sportTicketsFormCommand->validateRequest();

        $this->assertEquals($expectedErrorMessage,
            $this->dataModel->queryOne('//field[@name="anzahl"]/error')->nodeValue);
    }

    public function testInvalidPhoneNumberCatchesException()
    {
        $expectedErrorMessage = 'Bitte geben Sie eine gültige Telefon-Nummer ein';
        $request = $this->getValidRequestArray();
        $request['phone'] = 'invalidphonenumber';
        $request = new PostRequest($request);

        $sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $request, $this->dataModel);
        $sportTicketsFormCommand->validateRequest();

        $this->assertEquals($expectedErrorMessage,
            $this->dataModel->queryOne('//field[@name="phone"]/error')->nodeValue);
    }

    public function testInvalidEmailCatchesException()
    {
        $expectedErrorMessage = 'Bitte geben Sie eine gültige Email-Adresse ein';
        $request = $this->getValidRequestArray();
        $request['email'] = 'invalidemail';
        $request = new PostRequest($request);

        $sportTicketsFormCommand = new SportTicketsFormCommand($this->csvBackend, $request, $this->dataModel);
        $sportTicketsFormCommand->validateRequest();

        $this->assertEquals($expectedErrorMessage,
            $this->dataModel->queryOne('//field[@name="email"]/error')->nodeValue);
    }

    public function invalidNumberProvider()
    {
        return [
            ['12345'],
            ['abcd'],
            ['blablabla'],
            ['2.34'],
        ];
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
            'sportart' => 'Handball',
            'anzahl' => '99',
        ];
    }

    public function testHappyPath()
    {
        $expectedMessage = 'Vielen Dank für die Bestellung';

        $this->csvBackend
            ->expects($this->once())
            ->method('writeDataToCsv');

        $this->sportTicketsFormCommand->performAction();

        $this->assertEquals($expectedMessage,
            $this->dataModel->queryOne('//field[@name="message"]/value')->nodeValue);
    }

    public function testOrderFailedCatchesException()
    {
        $expectedMessage = 'Fehler: Die Bestellung konnte nicht ausgeführt werden';

        $this->csvBackend
            ->expects($this->once())
            ->method('writeDataToCsv')
            ->will($this->throwException(new \RuntimeException('festplatte kaputt')));

        $this->sportTicketsFormCommand->performAction();

        $this->assertEquals($expectedMessage,
            $this->dataModel->queryOne('//field[@name="message"]/value')->nodeValue);
    }

    public function testHasErrorsReturnsRightBoolean()
    {
        $this->dataModel->queryOne('//field[@name="email"]/error')->nodeValue = 'Fehler';
        $this->assertTrue($this->sportTicketsFormCommand->hasErrors());

        $this->dataModel->queryOne('//field[@name="email"]/error')->nodeValue = '';
        $this->assertFalse($this->sportTicketsFormCommand->hasErrors());
    }

    /**
     * @dataProvider FormFieldValuesProvider
     * @param $fieldName
     * @param $fieldValue
     */
    public function testRepopulatingFormFieldsWorksFine($fieldName, $fieldValue)
    {
        $this->sportTicketsFormCommand->repopulateForm();
        $this->assertEquals($fieldValue, $this->dataModel->queryOne('//field[@name="'. $fieldName .'"]/value')->nodeValue);
    }

    public function FormFieldValuesProvider() : array
    {
        return [
            ['name', 'Muster'],
            ['vorname', 'Hans'],
            ['strasse', 'Street'],
            ['plz', '1111'],
            ['ort', 'Walhalla'],
            ['phone', '011111111'],
            ['email', 'example@example.org'],
            ['sportart', 'Handball'],
            ['anzahl', '99'],
        ];
    }

}
