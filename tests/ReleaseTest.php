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
        $data = $this->loadContent('release_content_keepachangelog_0.3.0.md');

        $release = new Release($data);

        $this->assertEquals('0.3.0', $release->getVersion());
    }

    public function testReleaseDate()
    {
        $data = $this->loadContent('release_content_keepachangelog_0.3.0.md');

        $release = new Release($data);

        $this->assertEquals('2015-12-03', $release->getDate());
    }

    public function testAdded()
    {
        $data = $this->loadContent('release_content_keepachangelog_0.3.0.md');

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
        $data = $this->loadContent('release_content_keepachangelog_0.0.4.md');

        $release = new Release($data);

        $expected = [
            'Remove empty sections from CHANGELOG, they occupy too much space and
create too much noise in the file. People will have to assume that the
missing sections were intentionally left out because they contained no
notable changes.',
        ];

        $this->assertEquals($expected, $release->getRemoved());
    }

    /**
     * @dataProvider providerFiles
     */
    public function testJson($filename)
    {
        $data = $this->loadContent($filename . '.md');

        $release = new Release($data);

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/data/' . $filename . '.json', $release->toJson());
    }

    /**
     * @dataProvider providerFiles
     */
    public function testHtml($filename)
    {
        $data = $this->loadContent($filename . '.md');

        $release = new Release($data);

        $expected = file_get_contents(__DIR__ . '/data/' . $filename . '.html');

        $this->assertEquals($expected, $release->toHtml());
    }

    /**
     * @dataProvider providerFiles
     */
    public function testXml($filename)
    {
        $data = $this->loadContent($filename . '.md');

        $release = new Release($data);

        $this->assertXmlStringEqualsXmlFile(__DIR__ . '/data/' . $filename . '.xml', $release->toXml());
    }

    public function providerFiles()
    {
        return [
            ['release_content_keepachangelog_0.3.0'],
            ['release_content_keepachangelog_0.0.4'],
            ['release_content_hlibsass_0.1.2.0'],
        ];
    }

    public function loadContent($filename)
    {
        return file(__DIR__ . '/data/' . $filename, FILE_IGNORE_NEW_LINES);
    }
}