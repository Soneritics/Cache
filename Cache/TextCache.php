<?php
class TextCache extends FileCacheAbstract
{
    public function set($id, $value)
    {
        $cacheFile = $this->getCacheFilename($id);
        file_put_contents($cacheFile, $value);
        return $this;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            return '';
        }

        return file_get_contents($this->getCacheFilename($id));
    }
}