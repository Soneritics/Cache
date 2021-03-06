<?php
/* 
 * The MIT License
 *
 * Copyright 2014 Soneritics Webdevelopment.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once __DIR__ . '/../Soneritics/Cache/Interfacing/CacheAbstract.php';
require_once __DIR__ . '/../Soneritics/Cache/Interfacing/FileCacheAbstract.php';
require_once __DIR__ . '/../Soneritics/Cache/TextCache.php';

use Cache\TextCache;

/**
 * Unit testing for the TextCache object.
 *
 * @author Jordi Jolink
 * @since 20-3-2015
 */
class TextCacheTest extends PHPUnit_Framework_TestCase
{
    private function getCacheObject()
    {
        return (new TextCache('tmp'))
            ->setCacheExpiration(3600);
    }

    public function testCacheExpiration()
    {
        $cache = $this->getCacheObject();

        for ($i = 100; $i <= 300; $i += 100) {
            $cache->setCacheExpiration($i);
            $this->assertEquals($cache->getCacheExpiration(), $i);
        }
    }

    public function testSetGet()
    {
        $cache = $this->getCacheObject();
        $testValue = 'This is just a string to test for.';

        $cache->set('testvalue', $testValue);
        $this->assertEquals($cache->get('testvalue'), $testValue);

        $cache->set('test-value', $testValue);
        $this->assertEquals($cache->get('test-value'), $testValue);

        $cache->set('test value', $testValue);
        $this->assertEquals($cache->get('test value'), $testValue);
    }
}
