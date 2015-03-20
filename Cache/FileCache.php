<?php
class FileCache extends FileCacheAbstract
{
    public function set($id, $value)
    {
        $cacheFile = $this->getCacheFilename($id);
        file_put_contents($cacheFile, serialize($value));
        return $this;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            return '';
        }

        return unserialize(file_get_contents($this->getCacheFilename($id)));
    }
}