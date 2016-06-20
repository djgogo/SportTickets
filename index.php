<?php
require_once __DIR__ . '/bootstrap.php';

$dom = new \TheSeer\fDOM\fDOMDocument();
$dom->load(__DIR__.'/templates/formular.xsl');

$renderer = new XslRenderer($dom, new \TheSeer\fXSL\fXSLTProcessor());

$dataModel = new \TheSeer\fDOM\fDOMDocument();
$dataModel->load('prototypes/formValidation.xml');

echo $renderer->render($dataModel);
