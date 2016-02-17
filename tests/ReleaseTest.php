<?php

namespace MJErwin\ParseAChangelog\Tests;

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

    public function testReleaseDate()
    {
        $data = file(__DIR__ . '/data/release_content_1.md');

        $release = new Release($data);

        $this->assertEquals('2015-12-03', $release->getDate());
    }

    public function testAdded()
    {
        $data = file(__DIR__ . '/data/release_content_1.md');

        $release = new Release($data);

        $expected = [
            'RU translation from @aishek.',
            'pt-BR translation from @tallesl.',
            'es-ES translation from @ZeliosAriex.',
        ];

        $this->assertEquals($expected, $release->getAdded());
    }
}