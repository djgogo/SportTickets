<?php
declare(strict_types = 1);

class GetRequest extends Request
{
    public function isGetRequest() : bool
    {
        return true;
    }
}

