<?php

namespace MJErwin\ParseAChangelog;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class Release
{
    protected $content;
    protected $version;
    protected $date;

    /**
     * Release constructor.
     *
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;

        $heading_line = isset($this->content[0]) ? $this->content[0] : null;

        if($heading_line)
        {
            preg_match('/^## (\[?)(?<version>[^\s\[\]#]*)(\]?)( - (?<date>[0-9]{4}-[0-9]{2}-[0-9]{2}))?$/', $heading_line, $matches);

            $this->version = isset($matches['version']) ? $matches['version'] : null;
            $this->date = isset($matches['date']) ? $matches['date'] : null;
        }
    }

    public function getVersion()
    {
        return $this->version;
    }
}