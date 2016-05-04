# PHP Textmaster API v1 client

[![Build Status](https://api.travis-ci.org/worldia/textmaster-api.svg?token=4dDhVzWiZtpfbs4qv8Fs&branch=master)](https://travis-ci.org/worldia/php-textmaster-api) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/worldia/textmaster-api/badges/quality-score.png?b=master&s=5fe7eadeed5f83c414833dd34c02fc7728640c03)](https://scrutinizer-ci.com/g/worldia/textmaster-api/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/worldia/textmaster-api/badges/coverage.png?b=master&s=5eb2f3076cee19862c32136126712889f1740df8)](https://scrutinizer-ci.com/g/worldia/textmaster-api/?branch=master)

A simple Object Oriented wrapper for Textmaster API, written with PHP5.

Uses [Textmaster API v1](https://www.textmaster.com/documentation). The object API is very similar to the RESTful API.

## Features

* Follows PSR-0/PSR-4 conventions and coding standard: autoload friendly
* Light and fast thanks to lazy loading of API classes
* Extensively tested and documented

## Requirements

* PHP >= 5.3.3 with [cURL](http://php.net/manual/en/book.curl.php) extension,
* [Guzzle](https://github.com/guzzle/guzzle) library,
* (optional) PHPUnit to run tests.

## Installation

```sh
$ php composer.phar require worldia/texmaster-api
```

## Basic usage of `php-textmaster-api` client

```php
$client = new \Textmaster\Client();
$projects = $client->projects()->all();
```

From `$client` object, you get access to the entire Textmaster api.

## Documentation

See the [`doc` directory](doc/) for more detailed documentation. [Yet to be written]

## License

`php-textmaster-api` is unlicensed. You may not use it without worldia group sas' written consent.

## Credits

Thanks to Textmaster for the high quality API and documentation.
