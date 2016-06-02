<?php


class FormValidator
{
    public function validateRequest(array $postRequest, \TheSeer\fDOM\fDOMDocument $dataModel)
    {
        if ($postRequest['name'] === '') {
            $dataModel->queryOne('//field[@name="name"]')->nodeValue = 'Bitte geben Sie einen Namen ein';
        }

        if ($postRequest['vorname'] === '') {
            $dataModel->queryOne('//field[@name="vorname"]')->nodeValue = 'Bitte geben sie einen Vornamen ein';
        }

        if ($postRequest['strasse'] === '') {
            $dataModel->queryOne('//field[@name="strasse"]')->nodeValue = 'Bitte geben sie den Strassen Namen ein';
        }

        if ($postRequest['plz'] === '') {
            $dataModel->queryOne('//field[@name="plz"]')->nodeValue = 'Bitte geben sie die Postleitzahl ein';
        }

        if ($postRequest['ort'] === '') {
            $dataModel->queryOne('//field[@name="ort"]')->nodeValue = 'Bitte geben sie den Ort ein';
        }

        if ($postRequest['email'] === '') {
            $dataModel->queryOne('//field[@name="email"]')->nodeValue = 'Bitte geben sie eine Email Adresse ein';
        }

        if ($postRequest['sportart'] === '') {
            $dataModel->queryOne('//field[@name="sportart"]')->nodeValue = 'Bitte wählen Sie eine Sportart aus';
        }

        if ($postRequest['anzahl'] === '') {
            $dataModel->queryOne('//field[@name="anzahl"]')->nodeValue = 'Bitte geben sie die Anzahl Tickets ein';
        }
    }
}

