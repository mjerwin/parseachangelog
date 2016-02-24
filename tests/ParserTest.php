<?php

namespace MJErwin\ParseAChangelog\Tests;

use MJErwin\ParseAChangelog\Reader;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $filename
     * @param $release_count
     *
     * @dataProvider providerReleaseCount
     */
    public function testReleaseCount($filename, $release_count)
    {
        $changelog = new Reader(__DIR__ . '/data/' . $filename . '.md');
        $releases = $changelog->getReleases();

        $this->assertEquals($release_count, sizeof($releases));
    }

    /**
     * @param $filename
     * @param $version
     *
     * @dataProvider providerRelease
     */
    public function testGetRelease($filename, $version)
    {
        $changelog = new Reader(__DIR__ . '/data/' . $filename . '.md');
        $release = $changelog->getRelease($version);

        $this->assertEquals($version, $release->getVersion());
    }

    /**
     * @dataProvider providerVersions
     */
    public function testGetVersions($filename, $versions)
    {
        $changelog = new Reader(__DIR__ . '/data/' . $filename . '.md');

        $this->assertEquals($versions, $changelog->getVersions());
    }

    public function providerReleaseCount()
    {
        return [
            ['changelog_keepachangelog', 12],
            ['changelog_hlibsass', 8],
        ];
    }

    public function providerRelease()
    {
        return [
            ['changelog_keepachangelog', '0.0.8'],
            ['changelog_hlibsass', '0.1.1.1'],
        ];
    }

    public function providerVersions()
    {
        return [
            [
                'changelog_keepachangelog',
                [
                    'Unreleased',
                    '0.3.0',
                    '0.2.0',
                    '0.1.0',
                    '0.0.8',
                    '0.0.7',
                    '0.0.6',
                    '0.0.5',
                    '0.0.4',
                    '0.0.3',
                    '0.0.2',
                    '0.0.1',
                ],
            ]
        ];
    }
}