<?php
declare(strict_types = 1);

class PostRequest extends Request
{
    public function isPostRequest() : bool
    {
        return true;
    }
}
