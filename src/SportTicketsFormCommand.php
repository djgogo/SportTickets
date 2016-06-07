<?php
declare(strict_types=1);

class SportTicketsFormCommand
{
    private $anrede;
    private $name;
    private $vorname;
    private $strasse;
    private $plz;
    private $ort;
    private $phone;
    private $email;
    private $anzahl;
    private $dataModel;

    /**
     * @var CsvBackend
     */
    private $csvBackend;
    /**
     * @var Request
     */
    private $postRequest;

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
        }

        $this->dataModel = $dataModel;
        $this->postRequest = $postRequest;
        $this->csvBackend = $csvBackend;
    }

    public function validateRequest()
    {
        if ($this->name === '') {
            $this->dataModel->queryOne('//field[@name="name"]/error')->nodeValue = 'Bitte geben Sie einen Namen ein';
        }

        if ($this->vorname === '') {
            $this->dataModel->queryOne('//field[@name="vorname"]/error')->nodeValue = 'Bitte geben sie einen Vornamen ein';
        }

        if ($this->strasse === '') {
            $this->dataModel->queryOne('//field[@name="strasse"]/error')->nodeValue = 'Bitte geben sie den Strassen Namen ein';
        }

        if (!is_numeric($this->plz) || strlen($this->plz) > 4) {
            $this->dataModel->queryOne('//field[@name="plz"]/error')->nodeValue = 'Bitte geben sie eine gültige Postleitzahl ein';
        }

        if ($this->plz === '') {
            $this->dataModel->queryOne('//field[@name="plz"]/error')->nodeValue = 'Bitte geben sie die Postleitzahl ein';
        }

        if ($this->ort === '') {
            $this->dataModel->queryOne('//field[@name="ort"]/error')->nodeValue = 'Bitte geben sie den Ort ein';
        }

        try {
            new PhoneNumber($this->phone);
        } catch (\InvalidArgumentException $e) {
            $this->dataModel->queryOne('//field[@name="phone"]/error')->nodeValue = 'Bitte geben Sie eine gültige Telefon-Nummer ein';
        }

        try {
            new Email($this->email);
        } catch (\InvalidArgumentException $e) {
            $this->dataModel->queryOne('//field[@name="email"]/error')->nodeValue = 'Bitte geben Sie eine gültige E-Mail-Adresse ein';
        }

        if (!isset($this->sportart)) {
            $this->dataModel->queryOne('//field[@name="sportart"]/error')->nodeValue = 'Bitte wählen Sie eine Sportart aus';
        }

        if (!is_numeric($this->anzahl) || strlen($this->anzahl) > 3) {
            $this->dataModel->queryOne('//field[@name="anzahl"]/error')->nodeValue = 'Bitte geben sie eine gültige Anzahl Tickets ein';
        }

        if ($this->anzahl === '') {
            $this->dataModel->queryOne('//field[@name="anzahl"]/error')->nodeValue = 'Bitte geben sie die Anzahl Tickets ein';
        }

        //var_export($_POST); exit;
        //echo $this->dataModel->saveXML(); exit;
    }

    public function performAction()
    {
        if (!file_exists('/var/www/petersacco.ch/data/tickets.csv')) {
            $header = "Anrede;Name;Vorname;Strasse;PLZ;Ort;Telefon;Email;Sportart;Anzahl\n";
            $this->csvBackend->outputHeader($header);
        }

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

        if ($this->csvBackend->writeCsvFile($row)){
            $this->dataModel->queryOne('//field[@name="message"]/value')->nodeValue = 'Vielen Dank für die Bestellung';
        }
    }

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
        if (!empty($this->anrede)) {
            $this->dataModel->queryOne('//field[@name="anrede"]/value')->nodeValue = $this->anrede;
        }

        if (!empty($this->name)) {
            $this->dataModel->queryOne('//field[@name="name"]/value')->nodeValue = $this->name;
        }

        if (!empty($this->vorname)) {
            $this->dataModel->queryOne('//field[@name="vorname"]/value')->nodeValue = $this->vorname;
        }

        if (!empty($this->strasse)) {
            $this->dataModel->queryOne('//field[@name="strasse"]/value')->nodeValue = $this->strasse;
        }

        if (!empty($this->plz)) {
            $this->dataModel->queryOne('//field[@name="plz"]/value')->nodeValue = $this->plz;
        }

        if (!empty($this->ort)) {
            $this->dataModel->queryOne('//field[@name="ort"]/value')->nodeValue = $this->ort;
        }

        if (!empty($this->phone)) {
            $this->dataModel->queryOne('//field[@name="phone"]/value')->nodeValue = $this->phone;
        }

        if (!empty($this->email)) {
            $this->dataModel->queryOne('//field[@name="email"]/value')->nodeValue = $this->email;
        }

        if (!empty($this->sportart)) {
            $this->dataModel->queryOne('//field[@name="sportart"]/value')->nodeValue = $this->sportart;
        }

        if (!empty($this->anzahl)) {
            $this->dataModel->queryOne('//field[@name="anzahl"]/value')->nodeValue = $this->anzahl;
        }

    }
}

