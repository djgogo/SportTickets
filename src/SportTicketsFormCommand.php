<?php


class SportTicketsFormCommand
{
    public function __construct(array $postRequest, \TheSeer\fDOM\fDOMDocument $dataModel)
    {
        $this->anrede = $postRequest['anrede'];
        $this->name = $postRequest['name'];
        $this->vorname = $postRequest['vorname'];
        $this->strasse = $postRequest['strasse'];
        $this->plz = $postRequest['plz'];
        $this->ort = $postRequest['ort'];
        $this->phone = $postRequest['phone'];
        $this->email = $postRequest['email'];
        $this->sportart = $postRequest['sportart'];
        $this->anzahl = $postRequest['anzahl'];

        $this->dataModel = $dataModel;
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

        if ( $this->plz === '') {
            $this->dataModel->queryOne('//field[@name="plz"]/error')->nodeValue = 'Bitte geben sie die Postleitzahl ein';
        }

        if ($this->ort === '') {
            $this->dataModel->queryOne('//field[@name="ort"]/error')->nodeValue = 'Bitte geben sie den Ort ein';
        }

        if ($this->email === '') {
            $this->dataModel->queryOne('//field[@name="email"]/error')->nodeValue = 'Bitte geben sie eine Email Adresse ein';
        }

        if (empty($this->sportart)) {
            $this->dataModel->queryOne('//field[@name="sportart"]/error')->nodeValue = 'Bitte wählen Sie eine Sportart aus';
        }

        if ($this->anzahl === '') {
            $this->dataModel->queryOne('//field[@name="anzahl"]/error')->nodeValue = 'Bitte geben sie die Anzahl Tickets ein';
        }

        //var_export($_POST); exit;
        //echo $this->dataModel->saveXML(); exit;
    }

    public function writeCsvFile()
    {
        if (!file_exists('/var/www/petersacco.ch/data/tickets.csv')) {
            $this->outputHeader();
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

        $file = fopen("/var/www/petersacco.ch/data/tickets.csv","a");
        fputcsv($file, $row, ';');
        fclose($file);
    }

    private function outputHeader()
    {
        $header = "Anrede;Name;Vorname;Strasse;PLZ;Ort;Telefon;Email;Sportart;Anzahl\n";
        $file = fopen("/var/www/petersacco.ch/data/tickets.csv","c");
        fputs($file, $header);
        fclose($file);
    }

    public function hasErrors()
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

