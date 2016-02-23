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
        $data = $this->loadContent('release_content_1.md');

        $release = new Release($data);

        $this->assertEquals('0.3.0', $release->getVersion());
    }

    public function testReleaseDate()
    {
        $data = $this->loadContent('release_content_1.md');

        $release = new Release($data);

        $this->assertEquals('2015-12-03', $release->getDate());
    }

    public function testAdded()
    {
        $data = $this->loadContent('release_content_1.md');

        $release = new Release($data);

        $expected = [
            'RU translation from @aishek.',
            'pt-BR translation from @tallesl.',
            'es-ES translation from @ZeliosAriex.',
        ];

        $this->assertEquals($expected, $release->getAdded());
    }

    public function testRemoved()
    {
        $data = $this->loadContent('release_content_2.md');

        $release = new Release($data);

        $expected = [
            'Remove empty sections from CHANGELOG, they occupy too much space and
create too much noise in the file. People will have to assume that the
missing sections were intentionally left out because they contained no
notable changes.',
        ];

        $this->assertEquals($expected, $release->getRemoved());
    }

    public function loadContent($filename)
    {
        return file(__DIR__ . '/data/' . $filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
}