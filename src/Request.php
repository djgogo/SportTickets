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

    public static function fromSuperGlobals() : Request
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return new GetRequest($_GET);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return new PostRequest($_POST);
        }

        throw new Exception();
    }

    public function isGetRequest() : bool
    {
        return false;
    }

    public function isPostRequest() : bool
    {
        return false;
    }

    public function hasParameter(string $parameter) : bool
    {
        return isset($this->parameters[$parameter]);
    }

    public function getParameter(string $parameter) : string
    {
        return $this->parameters[$parameter];
    }

    public function getParameters() : array
    {
        return $this->parameters;
    }
}

