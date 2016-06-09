<?php
require_once __DIR__ . '/bootstrap.php';

$dom = new \TheSeer\fDOM\fDOMDocument();
$dom->load(__DIR__.'/templates/formular.xsl');

$renderer = new XslRenderer($dom, new \TheSeer\fXSL\fXSLTProcessor());

$dataModel = new \TheSeer\fDOM\fDOMDocument();
$dataModel->load('prototypes/formValidation.xml');

$filePath = '/var/www/petersacco.ch/data/tickets.csv';
$csvBackend = new CsvBackend($filePath);
$request = Request::fromSuperGlobals();

$sportTicketsFormCommand = new SportTicketsFormCommand($csvBackend, $request, $dataModel);

$sportTicketsFormCommand->validateRequest();

if ($sportTicketsFormCommand->hasErrors()) {
    $sportTicketsFormCommand->repopulateForm();
} else {
    $sportTicketsFormCommand->performAction();
}

echo $renderer->render($dataModel);
