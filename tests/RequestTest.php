<?php
declare(strict_types = 1);

/**
 * @covers Request
 * @covers PostRequest
 */
class PostRequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PostRequest
     */
    private $postRequest;

    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['anrede'] = 'Herr';
        $_POST['name'] = 'Muster';
        $_POST['vorname'] = 'Hans';

        $this->postRequest = new PostRequest($_POST);
    }

    public function testPostRequestReturnsRightObject()
    {
        $this->postRequest->fromSuperGlobals();
        $this->assertInstanceOf(PostRequest::class, $this->postRequest);
    }

    public function testGetRequestReturnsRightObject()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->postRequest->fromSuperGlobals();
        $this->assertInstanceOf(PostRequest::class, $this->postRequest);
    }

    public function testFromSuperGlobalsWithOtherRequestMethodThrowsException()
    {
        $this->expectException('Exception');

        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $this->postRequest->fromSuperGlobals();
    }

    public function testPostRequestReturnsRightParameters()
    {
        $this->postRequest->fromSuperGlobals();
        $this->assertEquals($_POST, ['anrede' => 'Herr', 'name' => 'Muster', 'vorname' => 'Hans']);
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
        $expectedRequest = $_POST;
        $this->assertEquals($expectedRequest, $this->postRequest->getParameters());
    }
}
