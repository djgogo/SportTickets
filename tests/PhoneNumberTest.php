<?php
declare(strict_types = 1);

/**
 * @covers PhoneNumber
 */
class PhoneNumberTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validNumberProvider
     */
    public function testValidNumbers($number, $expected)
    {
        $phoneNumber = new PhoneNumber($number);
        $this->assertInstanceOf(PhoneNumber::class, $phoneNumber);
        $this->assertSame($expected, (string) $phoneNumber);
    }

    /**
     * @dataProvider invalidNumberProvider
     */
    public function testInvalidNumbers($number)
    {
        $this->expectException('InvalidArgumentException');
        new PhoneNumber($number);
    }

    public function validNumberProvider()
    {
        return [
            ['056123546', '056123546'],
            ['123', '123'],
            ["056'126'54'21", '0561265421'],
            ['+41561235421', '0041561235421'],
            ['056 126 54 21', '0561265421'],
            ['1234mitdemkopfüberdietastaturrollen56', '123456'],
            ['+mitdemkopfüberdietastaturrollen', '00']
        ];
    }

    public function invalidNumberProvider()
    {
        return [
            ['mitdemkopfüberdietastaturrollen'],
            ['abcd'],
            ['einzweidrei'],
            [''],
            [null],
            [str_repeat('1', 51)],
        ];
    }
}
