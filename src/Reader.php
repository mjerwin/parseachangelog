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
        $this->content = file($filename, FILE_IGNORE_NEW_LINES);
    }

    /**
     * @return Release[]
     */
    public function getReleases()
    {
        if (empty($this->releases))
        {
            $headings = preg_grep('/^## (\[?)([^\s\[\]#]*)(\]?)( - ([0-9]{4}-[0-9]{2}-[0-9]{2}))?$/', $this->content);

            while($current_heading = current($headings))
            {
                $start = key($headings);
                next($headings);
                $end = key($headings);

                if ($end) {
                    $end -= $start;
                }

                $release_content = array_slice($this->content, $start, $end);

                $release = new Release($release_content);
                $this->releases[$release->getVersion()] = new Release($release_content);
            }
        }

        return $this->releases;
    }

    /**
     * @param $version
     *
     * @return Release|null
     */
    public function getRelease($version)
    {
        $releases = $this->getReleases();

        return isset($releases[$version]) ? $releases[$version] : null;
    }

    /**
     * @return array
     */
    public function getVersions()
    {
        $versions = [];

        $headings = preg_grep('/^## (\[?)([^\s\[\]#]*)(\]?)( - ([0-9]{4}-[0-9]{2}-[0-9]{2}))?$/', $this->content);

        foreach($headings as $heading)
        {
            preg_match('/^## (\[?)(?<version>[^\s\[\]#]*)(\]?)/', $heading, $matches);

            if(isset($matches['version']))
            {
                $versions[] = $matches['version'];
            }
        }

        return $versions;
    }
}
