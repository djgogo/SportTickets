<?php
class Email
{
    private $email;

    public function __construct(string $email)
    {
        $this->ensureValid($email);

        $this->email = $email;
    }

    private function ensureValid(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException;
        }
    }
}
