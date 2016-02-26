# mjerwin/parseachangelog

[![Build Status](https://travis-ci.org/mjerwin/parseachangelog.svg)](https://travis-ci.org/mjerwin/sendowl)
[![HHVM](https://img.shields.io/hhvm/mjerwin/parseachangelog.svg)]()
[![Scrutinizer](https://img.shields.io/scrutinizer/g/mjerwin/parseachangelog.svg)]()
[![Packagist](https://img.shields.io/packagist/v/mjerwin/parseachangelog.svg)](https://packagist.org/packages/mjerwin/sendowl)

A library for parsing change logs using the format defined by [keepachangelog.com](http://keepachangelog.com).

## Installation
```
composer require mjerwin/parseachangelog
```

## Basic Usage
### Get changes by version
```php
$changelog = new Reader('path_to_changelog.md');
$release = $changelog->getRelease('0.2.0');
print_r($release->getAdded());
```

### Get all changes
```php
$changelog = new Reader('path_to_changelog.md');
$releases = $changelog->getReleases();
foreach($releases as $release)
{
	echo $release->getVersion();
	foreach ($release->getChanged() as $change)
	{
		echo $change;
	}
}
```

### Methods
##### getVersion()
Get the version number of the release e.g. 0.2.0

##### getDate()
Get the date of the release

##### getAdded()
Get an array of messages from the *Added* section

##### getChanged()
Get an array of messages from the *Changed* section

##### getDeprecated()
Get an array of messages from the *Deprecated* section

##### getRemoved()
Get an array of messages from the *Removed* section

##### getFixed()
Get an array of messages from the *Fixed* section

##### getSecurity()
Get an array of messages from the *Security* section

##### toArray()
Represents the release as an array

##### toJson()
Represents the release in JSON format

##### toXml()
Represents the release as XML

##### toHtml()
Represents thr release as HTML using `erusev/parsedown`