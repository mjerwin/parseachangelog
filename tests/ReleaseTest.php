<?php

namespace MJErwin\ParseAChangelog\Tests;

use MJErwin\ParseAChangelog\Reader;
use MJErwin\ParseAChangelog\Release;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ReleaseTest extends \PHPUnit_Framework_TestCase
{
    public function testReleaseVersion()
    {
        $data = file(__DIR__ . '/data/release_content_1.md');

        $release = new Release($data);

        $this->assertEquals('0.3.0', $release->getVersion());
    }
}