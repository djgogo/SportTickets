<?php


class FormValidator
{
    public function validateRequest(array $postRequest, \TheSeer\fDOM\fDOMDocument $dataModel)
    {
        if ($postRequest['name'] === '') {
            $dataModel->queryOne('//field[@id="name"]')->nodeValue = 'Der Benutzername darf nicht leer sein';
        }
    }
}

