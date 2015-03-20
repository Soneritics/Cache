<?php
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