<?php

namespace TomPedals\HelpScoutApp;

class DynamicAppResponse
{
    /**
     * @var string
     */
    private $html;

    /**
     * @param string $html
     */
    public function __construct($html = '')
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * @return array JSON data
     */
    public function getData()
    {
        return ['html' => $this->html];
    }
}
