
<?php
require_once __DIR__ . '/bootstrap.php';

$dom = new \TheSeer\fDOM\fDOMDocument();
$dom->load(__DIR__.'/templates/formular.xsl');

$renderer = new XslRenderer($dom, new \TheSeer\fXSL\fXSLTProcessor());

$dataModel = new \TheSeer\fDOM\fDOMDocument();
$dataModel->load('prototypes/formValidation.xml');

$formValidator = new SportTicketsFormCommand($_POST, $dataModel);

$formValidator->validateRequest();
$hasErrors = $formValidator->hasErrors();

if ($hasErrors) {
    $formValidator->repopulateForm();
} else {
    $formValidator->writeCsvFile();
    $hasErrors = $formValidator->hasErrors();
}

echo $renderer->render($dataModel);
