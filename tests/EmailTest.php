<?php
declare(strict_types = 1);

/**
 * @covers Email
 */
class EmailTest extends PHPUnit_Framework_TestCase
{
    public function testHappyPath()
    {
        $emailString = 'test@example.com';
        $email = new Email($emailString);
        $this->assertEquals($emailString, (string) $email);
    }

    /**
     * @dataProvider invalidEmailProvider
     * @param $invalidEmail
     */
    public function testCannotBeInvalid($invalidEmail)
    {
        $this->expectException(InvalidArgumentException::class);
        new Email($invalidEmail);
    }

    /**
     * @return array
     */
    public function invalidEmailProvider()
    {
        return [
            ['invalid'],
            ['invalid@'],
            ['invalid@invalid'],
            ['invalid@.invalid'],
            ['@invalid.ch'],
        ];
    }
}

