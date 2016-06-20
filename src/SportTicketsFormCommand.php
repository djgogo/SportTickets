<?php
declare(strict_types=1);

class SportTicketsFormCommand
{
    /**
     * @var string
     */
    private $anrede;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $vorname;
    /**
     * @var string
     */
    private $strasse;
    /**
     * @var string
     */
    private $plz;
    /**
     * @var string
     */
    private $ort;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $anzahl;
    /**
     * @var \TheSeer\fDOM\fDOMDocument
     */
    private $dataModel;
    /**
     * @var CsvBackend
     */
    private $csvBackend;
    /**
     * @var Request
     */
    private $postRequest;

    /**
     * @param CsvBackend $csvBackend
     * @param Request $postRequest
     * @param \TheSeer\fDOM\fDOMDocument $dataModel
     */
    public function __construct(CsvBackend $csvBackend, Request $postRequest, \TheSeer\fDOM\fDOMDocument $dataModel)
    {
        $this->anrede = $postRequest->getParameter('anrede');
        $this->name = $postRequest->getParameter('name');
        $this->vorname = $postRequest->getParameter('vorname');
        $this->strasse = $postRequest->getParameter('strasse');
        $this->plz = $postRequest->getParameter('plz');
        $this->ort = $postRequest->getParameter('ort');
        $this->phone = $postRequest->getParameter('phone');
        $this->email = $postRequest->getParameter('email');
        $this->anzahl = $postRequest->getParameter('anzahl');

        if ($postRequest->hasParameter('sportart')) {
            $this->sportart = $postRequest->getParameter('sportart');
        } else {
            $this->sportart = '';
        }

        $this->dataModel = $dataModel;
        $this->postRequest = $postRequest;
        $this->csvBackend = $csvBackend;
    }

    public function validateRequest()
    {
        if (!ctype_digit($this->plz) || strlen($this->plz) > 4) {
            $this->dataModel->queryOne('//field[@name="plz"]/error')->nodeValue = 'Bitte geben sie eine gültige Postleitzahl ein';
        }

        try {
            new PhoneNumber($this->phone);
        } catch (\InvalidArgumentException $e) {
            $this->dataModel->queryOne('//field[@name="phone"]/error')->nodeValue = 'Bitte geben Sie eine gültige Telefon-Nummer ein';
        }

        try {
            new Email($this->email);
        } catch (\InvalidArgumentException $e) {
            $this->dataModel->queryOne('//field[@name="email"]/error')->nodeValue = 'Bitte geben Sie eine gültige Email-Adresse ein';
        }

        if (!ctype_digit($this->anzahl) || strlen($this->anzahl) > 3) {
            $this->dataModel->queryOne('//field[@name="anzahl"]/error')->nodeValue = 'Bitte geben sie eine gültige Anzahl Tickets ein';
        }

        $this->validateEmptyFormField($this->name, 'name', 'Bitte geben sie einen Namen ein');
        $this->validateEmptyFormField($this->vorname, 'vorname', 'Bitte geben sie einen Vornamen ein');
        $this->validateEmptyFormField($this->strasse, 'strasse', 'Bitte geben sie einen Strassen Namen ein');
        $this->validateEmptyFormField($this->plz, 'plz', 'Bitte geben sie die Postleitzahl ein');
        $this->validateEmptyFormField($this->ort, 'ort', 'Bitte geben sie den Ort ein');
        $this->validateEmptyFormField($this->phone, 'phone', 'Bitte geben sie eine Telefon-Nummer ein');
        $this->validateEmptyFormField($this->email, 'email', 'Bitte geben sie eine Email Adresse ein');
        $this->validateEmptyFormField($this->sportart, 'sportart', 'Bitte wählen Sie eine Sportart aus');
        $this->validateEmptyFormField($this->anzahl, 'anzahl', 'Bitte geben sie die Anzahl Tickets ein');
    }

    /**
     * @param string $field
     * @param string $fieldName
     * @param string $value
     */
    private function validateEmptyFormField(string $field, string $fieldName, string $value)
    {
        if ($field === '') {
            $this->dataModel->queryOne('//field[@name="'. $fieldName .'"]/error')->nodeValue = $value;
        }
    }

    public function performAction()
    {
        $row = [
            $this->anrede,
            $this->name,
            $this->vorname,
            $this->strasse,
            $this->plz,
            $this->ort,
            $this->phone,
            $this->email,
            $this->sportart,
            $this->anzahl
        ];

        $csvHeader = "Anrede;Name;Vorname;Strasse;PLZ;Ort;Telefon;Email;Sportart;Anzahl\n";

        try {
            $this->csvBackend->writeDataToCsv($csvHeader, $row);
            $this->dataModel->queryOne('//field[@name="message"]/value')->nodeValue = 'Vielen Dank für die Bestellung';
        } catch (\Throwable $e) {
            $this->dataModel->queryOne('//field[@name="message"]/value')->nodeValue = 'Fehler: Die Bestellung konnte nicht ausgeführt werden';
        }
    }

    /**
     * @return bool
     */
    public function hasErrors() : bool
    {
        $nodeList = $this->dataModel->query('//field/error');
        foreach ($nodeList as $node) {
            /** @var \TheSeer\fDOM\fDOMElement */
            if ($node->nodeValue !== '') {
                return true;
            }
        }
        return false;
    }

    public function repopulateForm()
    {
        if ($this->anrede == 'Herr') {
            $this->dataModel->queryOne('//field[@name="anrede"]/herr')->nodeValue = 'selected';
            $this->dataModel->queryOne('//field[@name="anrede"]/frau')->nodeValue = '';
        } else {
            $this->dataModel->queryOne('//field[@name="anrede"]/herr')->nodeValue = '';
            $this->dataModel->queryOne('//field[@name="anrede"]/frau')->nodeValue = 'selected';
        }

        $this->repopulate($this->name, 'name');
        $this->repopulate($this->vorname, 'vorname');
        $this->repopulate($this->strasse, 'strasse');
        $this->repopulate($this->plz, 'plz');
        $this->repopulate($this->ort, 'ort');
        $this->repopulate($this->phone, 'phone');
        $this->repopulate($this->email, 'email');
        $this->repopulate($this->sportart, 'sportart');
        $this->repopulate($this->anzahl, 'anzahl');
    }

    /**
     * @param string $field
     * @param string $fieldName
     */
    private function repopulate(string $field, string $fieldName)
    {
        if (!empty($field)) {
            $this->dataModel->queryOne('//field[@name="'. $fieldName .'"]/value')->nodeValue = $field;
        }
    }
}

