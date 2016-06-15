<?php
require_once __DIR__ . '/bootstrap.php';

$dom = new \TheSeer\fDOM\fDOMDocument();
$dom->load(__DIR__.'/templates/formular.xsl');

$renderer = new XslRenderer($dom, new \TheSeer\fXSL\fXSLTProcessor());

$dataModel = new \TheSeer\fDOM\fDOMDocument();
$dataModel->load('prototypes/formValidation.xml');

$filePath = '/var/www/petersacco.ch/data/tickets.csv';
$csvBackend = new CsvBackend($filePath);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $request = new GetRequest($_GET);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = new PostRequest($_POST);
}else {
    throw new Exception('Nicht unterstützte Request Methode '.$_SERVER['REQUEST_METHOD']);
}

$sportTicketsFormCommand = new SportTicketsFormCommand($csvBackend, $request, $dataModel);

$sportTicketsFormCommand->validateRequest();

if ($sportTicketsFormCommand->hasErrors()) {
    $sportTicketsFormCommand->repopulateForm();
} else {
    $sportTicketsFormCommand->performAction();
}

echo $renderer->render($dataModel);
