<?php

namespace MJErwin\ParseAChangelog;

use MJErwin\ParseAChangelog\Release;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class Reader
{
    protected $content;
    protected $releases = [];

    /**
     * Reader constructor.
     */
    public function __construct($filename)
    {
        $this->content = file($filename);
    }

    public function getReleases()
    {
        if (empty($this->releases))
        {
            $headings = preg_grep('/^## (\[?)([^\s\[\]#]*)(\]?)( - ([0-9]{4}-[0-9]{2}-[0-9]{2}))?$/', $this->content);

            while($current_heading = current($headings))
            {
                $start = key($headings);
                next($headings);
                $end = key($headings) - 1;

                $release_content = array_slice($this->content, $start, $end);

                $release = new Release($release_content);
                $this->releases[$release->getVersion()] = new Release($release_content);
            }
        }

        return $this->releases;
    }

    public function getRelease($version)
    {
        $releases = $this->getReleases();

        return isset($releases[$version]) ? $releases[$version] : null;
    }
}