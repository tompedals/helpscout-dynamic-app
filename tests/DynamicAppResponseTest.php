<?php

namespace TomPedals\HelpScoutApp;

class DynamicAppResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSetHtmlWithConstructor()
    {
        $response = new DynamicAppResponse('<h4>Test</h4>');

        $this->assertSame('<h4>Test</h4>', $response->getHtml());
    }

    public function testSetHtmlWithSetter()
    {
        $response = new DynamicAppResponse();
        $response->setHtml('<h4>Test</h4>');

        $this->assertSame('<h4>Test</h4>', $response->getHtml());
    }

    public function testGetDataReturnsArrayForJsonEncoding()
    {
        $response = new DynamicAppResponse('<h4>Test</h4>');

        $this->assertSame(['html' => '<h4>Test</h4>'], $response->getData());
    }
}
