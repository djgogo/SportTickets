<?php
declare(strict_types = 1);

class PhoneNumber
{
    /**
     * @var string
     */
    private $number;

    /**
     * @param $number
     */
    public function __construct($number)
    {
        $this->ensureValid($number);
        $this->number = $number;
    }

    /**
     * @param $number
     *
     * @throws \InvalidPhoneNumberException
     */
    private function ensureValid($number)
    {
        $number = str_replace('+', '00', $number);
        $number = preg_replace('/[^0-9]/', '', $number);
        if (empty($number) || strlen($number) > 50) {
            throw new \InvalidPhoneNumberException();
        }
    }

    /**
     * @return string
     */
    function __toString() : string
    {
        return $this->number;
    }
}
