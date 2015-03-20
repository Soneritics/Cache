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

abstract class CacheAbstract
{
    private $cacheExpiration;

    public abstract function set($id, $value);

    public abstract function get($id);

    public abstract function clear($id);

    public abstract function has($id);

    public function touch($id)
    {
        $this->set($id, $this->get($id));
        return $this;
    }

    public function setCacheExpiration($seconds)
    {
        $this->cacheExpiration = $seconds;
        return $this;
    }

    public function getCacheExpiration()
    {
        if ($this->cacheExpiration === null) {
            throw new Exception(
                "Expiration time not set.\n" .
                "Use setCacheExpiration(\$seconds) function first."
            );
        }

        return $this->cacheExpiration;
    }
}