<?php

namespace MJErwin\ParseAChangelog;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class Release
{
    protected $content;

    /**
     * Release constructor.
     *
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
}