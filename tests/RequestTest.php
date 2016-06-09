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
//        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->post['anrede'] = 'Herr';
        $this->post['name'] = 'Muster';
        $this->post['vorname'] = 'Hans';

        $this->postRequest = new PostRequest($this->post);

        $this->postRequest->getParameter('anrede');
    }

    public function testGetRequestReturnsRightObject()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertInstanceOf(GetRequest::class, $this->postRequest->fromSuperGlobals());
    }

    public function testFromSuperGlobalsWithOtherRequestMethodThrowsException()
    {
        $this->expectException('Exception');

        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $this->postRequest->fromSuperGlobals();
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
