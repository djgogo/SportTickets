<?php
declare(strict_types = 1);

/**
 * @covers Request
 * @covers PostRequest
 */
class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PostRequest
     */
    private $postRequest;

    private $post;

    public function setUp()
    {
        $this->post['anrede'] = 'Herr';
        $this->post['name'] = 'Muster';
        $this->post['vorname'] = 'Hans';

        $this->postRequest = new PostRequest($this->post);
    }

    public function testHasParameterReturnsRightBoolean()
    {
        $this->assertTrue($this->postRequest->hasParameter('name'));
        $this->assertFalse($this->postRequest->hasParameter('Invlaid Parameter'));
    }

    public function testParameterCanBeRetrieved()
    {
        $this->assertEquals('Muster', $this->postRequest->getParameter('name'));
    }

    public function testWrongParameterThrowsException()
    {
        $this->expectException('Exception');
        $this->postRequest->getParameter('invalid parameter');
    }

    public function testParametersCanBeRetrieved()
    {
        $this->assertEquals($this->post, $this->postRequest->getParameters());
    }
}
