<?php
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