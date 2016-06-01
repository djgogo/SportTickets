<?php

use TheSeer\fDOM\fDOMDocument;
use TheSeer\fXSL\fXSLTProcessor;

class XslRenderer
{
    /**
     * @var fDOMDocument
     */
    private $xslTemplate;

    /**
     * @var fXSLTProcessor
     */
    private $xslProcessor;

    /**
     * @param fDOMDocument $xslTemplate
     * @param fXSLTProcessor $xslProcessor
     */
    public function __construct(fDOMDocument $xslTemplate, fXSLTProcessor $xslProcessor)
    {
        $this->xslTemplate = $xslTemplate;
        $this->xslProcessor = $xslProcessor;
    }

    /**
     * @param fDOMDocument $dom
     * @return fDOMDocument
     */
    public function render(fDOMDocument $dom)
    {
        $this->xslProcessor->importStylesheet($this->xslTemplate);

        $fDOM = new fDOMDocument;
        $fDOM->loadXML($this->xslProcessor->transformToDoc($dom)->saveXML());

        return $fDOM;
    }
}