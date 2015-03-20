<?php
require 'Cache/Abstract/CacheAbstract.php';
require 'Cache/Abstract/FileCacheAbstract.php';
require 'Cache/TextCache.php';
require 'Cache/FileCache.php';

echo "TEXTCACHE\n";
$textCache = new TextCache('tmp');
$textCache->setCacheExpiration(4);
$textCache->set('test', 'test');
echo "Cache set\n";
echo "Cache get: " . $textCache->get('test') . "\n";
echo "Waiting 5 seconds..\n";
sleep(5);
echo "has cache: " . ($textCache->has('test') ? 'true' : 'false') . "\n\n\n";
$textCache->clear('test');

echo "FILECACHE\n";
$fileCache = new FileCache('tmp');
$fileCache->setCacheExpiration(4);
$fileCache->set('test', array('test'));
echo "Cache set\n";
echo "Cache get: " . print_r($fileCache->get('test'), true) . "\n";
echo "Waiting 5 seconds..\n";
sleep(5);
echo "has cache: " . ($fileCache->has('test') ? 'true' : 'false') . "\n\n\n";
$fileCache->clear('test');