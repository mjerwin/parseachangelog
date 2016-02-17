<?php

namespace MJErwin\ParseAChangelog\Tests;

use MJErwin\ParseAChangelog\Reader;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testReleaseCount()
    {
        $changelog = new Reader(__DIR__ . '/data/changelog_1.md');
        $releases = $changelog->getReleases();

        $this->assertEquals(12, sizeof($releases));
    }

    public function testGetRelease()
    {
        $changelog = new Reader(__DIR__ . '/data/changelog_1.md');
        $release = $changelog->getRelease('0.0.8');

        $this->assertEquals('0.0.8', $release->getVersion());
    }
}