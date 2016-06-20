<?php
declare(strict_types = 1);
abstract class Request
{
    /**
     * @var array
     */
    private $parameters;

    public function __construct(array $request)
    {
        $this->parameters = $request;
    }

    /**
     * @param string $parameter
     * @return bool
     */
    public function hasParameter(string $parameter) : bool
    {
        return isset($this->parameters[$parameter]);
    }

    /**
     * @param string $parameter
     * @return string
     * @throws Exception
     */
    public function getParameter(string $parameter) : string
    {
        if ($this->hasParameter($parameter)) {
            return $this->parameters[$parameter];
        } else {
            throw new Exception('Request Parameter '. $parameter .' steht nicht zur Verfügung!');
        }
    }

    /**
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
}

