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
namespace Cache\Interfacing;

abstract class FileCacheAbstract extends CacheAbstract
{
    private $cachePath;

    public function __construct($cachePath)
    {
        $this->setCachePath($cachePath);
    }

    public function setCachePath($cachePath)
    {
        // Format the cache path with correct directory separator
        $cachePath = str_replace('\\', DIRECTORY_SEPARATOR, $cachePath);

        // Add trailing slash
        if (substr($cachePath, -1) !== DIRECTORY_SEPARATOR) {
            $cachePath .= DIRECTORY_SEPARATOR;
        }

        // Try to create the path
        if (!file_exists($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        // Error handling
        if (!file_exists($cachePath)) {
            throw new Exception("Cache path {$cachePath} does not exist.");
        }

        if (!is_writable($cachePath)) {
            throw new Exception("Cache path {$cachePath} is not writable.");
        }

        // Return this object to provide chaining
        return $this;
    }

    public function getCachePath()
    {
        return $this->cachePath;
    }

    protected function getCacheFilename($id)
    {
        return $this->cachePath . md5($id);
    }

    public function touch($id)
    {
        touch($this->getCacheFilename($id));
        return $this;
    }

    public function clear($id)
    {
        $cacheFile = $this->getCacheFilename($id);
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        return $this;
    }

    public function has($id)
    {
        $cacheFile = $this->getCacheFilename($id);

        if (!file_exists($cacheFile)) {
            return false;
        }

        $cacheUpdated = filemtime($cacheFile);
        $cacheExpires = time() - $this->getCacheExpiration();

        if ($cacheUpdated < $cacheExpires) {
            $this->clear($id);
            return false;
        }

        return true;
    }
}
