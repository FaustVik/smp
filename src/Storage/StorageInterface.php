<?php

namespace Smp\Storage;

/**
 * Interface StorageInterface
 * @package Smp\Storage
 */
interface StorageInterface
{
    /**
     * get value by key
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function set(array $params);

    /**
     * delete value by key
     *
     * @param $key
     *
     * @return mixed
     */
    public function delete($key);

    /**
     * clear all values
     * @return mixed
     */
    public function clear();

    /**
     * get count values
     * @return mixed
     */
    public function count();

    /**
     * get all values
     * @return mixed
     */
    public function getAll();
}