# Cache #

[![Build Status](https://api.travis-ci.org/Soneritics/Cache.svg?branch=master)](https://travis-ci.org/Soneritics/Currency)
[![Coverage Status](https://coveralls.io/repos/Soneritics/Cache/badge.svg?branch=master)](https://coveralls.io/r/Soneritics/Cache?branch=master)
![License](http://img.shields.io/badge/license-MIT-green.svg)

by
* [@Soneritics](https://github.com/Soneritics) - Jordi Jolink


## Introduction ##
Caching interfaces and implementation of caching methods.

## Minimum Requirements ##

- PHP 5.5+

## Features ##

Currently supports the following caches:
- TextCache
- FileCache
- MemCache
- ArrayCache
- SessionCache

### Example ###

```php
$textCache = (new TextCache('tmp'))
    ->setCacheExpiration(4)
    ->set('test', 'test');

echo $textCache->get('test');
// sleep(5);
// $textCache->has('test') === false


$fileCache = (new FileCache('tmp'))
    ->setCacheExpiration(3600)
    ->set('test', ['test1', 'test2']);

var_dump($fileCache->get('test'));
$fileCache->clear('test');
