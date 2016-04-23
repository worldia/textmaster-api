# PHP Textmaster API

[![Build Status](https://api.travis-ci.com/worldia/php-textmaster-api.svg?token=Q8y3gRp4jqWYsvqpVV1z&branch=master)](https://travis-ci.com/worldia/php-textmaster-api) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/worldia/php-textmaster-api/badges/quality-score.png?b=master&s=3014bb9f0c312da6ab7e9b8cd50830d8e5254319)](https://scrutinizer-ci.com/g/worldia/php-textmaster-api/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/worldia/php-textmaster-api/badges/coverage.png?b=master&s=b8b6ebabd4ae08eccffd5b4e6e0ee7040f4b382c)](https://scrutinizer-ci.com/g/worldia/php-textmaster-api/?branch=master)

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
