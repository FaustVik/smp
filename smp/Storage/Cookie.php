<?php

namespace Smp\Storage;

/**
 * Class Cookie
 * @package Smp\Storage
 */
class Cookie implements StorageInterface
{
    /**
     * @inheritDoc
     */
    public function get($key)
    {
        return $_COOKIE[$key];
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        if (is_array($key)) {
            foreach ($key as $item) {
                setcookie($item, null, -1, '/');
            }
        } else {
            setcookie($key, null, -1, '/');
        }
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        foreach ($_COOKIE as $name => $value) {
            $this->delete($name);
        }
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($_COOKIE);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $_COOKIE;
    }

    /**
     * @inheritDoc
     * keys params : name, value, expire, path, secure, domain, httOnly
     * @example  [key => value]
     */
    public function set(array $params): bool
    {
        $name    = $params['name'];
        $value   = $params['value'];
        $expire  = $params['expire'] ? time() + $params['expire'] : time();
        $path    = $params['path'] ?? '/';
        $secure  = $params['secure'] ?? false;
        $domain  = $params['domain'] ?? $_SERVER['SERVER_NAME'];
        $httOnly = $params['httOnly'] ?? true;

       return setcookie($name, $value, $expire, $path, $domain, $secure, $httOnly);
    }
}