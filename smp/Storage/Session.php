<?php

namespace Smp\Storage;

/**
 * Class Session
 * @package Smp\Storage
 */
class Session implements StorageInterface
{
    public function start()
    {
        session_start();
    }

    public function destroy()
    {
        session_destroy();
    }

    /**
     * @inheritDoc
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        if (is_array($key)) {
            foreach ($key as $item) {
                unset($_SESSION[$item]);
            }
        } else {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        unset($_SESSION);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($_SESSION);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $_SESSION;
    }

    /**
     * @inheritDoc
     */
    public function set(array $params)
    {
        $key = array_keys($params)[0];

        $_SESSION[$key] = $params[$key];
    }
}