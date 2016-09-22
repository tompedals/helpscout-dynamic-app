<?php

namespace TomPedals\HelpScoutApp;

class AppResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSetHtmlWithConstructor()
    {
        $response = new AppResponse('<h4>Test</h4>');

        $this->assertSame('<h4>Test</h4>', $response->getHtml());
    }

    public function testSetHtmlWithSetter()
    {
        $response = new AppResponse();
        $response->setHtml('<h4>Test</h4>');

        $this->assertSame('<h4>Test</h4>', $response->getHtml());
    }

    public function testGetDataReturnsArrayForJsonEncoding()
    {
        $response = new AppResponse('<h4>Test</h4>');

        $this->assertSame(['html' => '<h4>Test</h4>'], $response->getData());
    }
}
