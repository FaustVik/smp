<?php

namespace Smp;

use PDO;

/**
 * Class DataBase
 * @package Smp
 */
class DataBase
{
    protected const FETCH_ONE = 1;
    protected const FETCH_ALL = 2;

    /**
     * @return PDO
     * @throws \Exception
     */
    protected function getDb()
    {
        $db_config = Application::$app['db'];

        try {
            $pdo = new PDO('mysql:host=' . $db_config['host'] . ';dbname=' . $db_config['dbname'], $db_config['user'], $db_config['password']);
            $pdo->exec("SET NAMES utf8");
            return $pdo;
        } catch (\PDOException $exception) {
            throw new \Exception('error connected Db ' . $exception);
        }
    }

    /**
     * @param string $sql
     * @param int    $style
     * @param array  $prepare_data
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function fetchAll(string $sql, $prepare_data = [], $style = PDO::FETCH_ASSOC)
    {
        return $this->fetch($sql, $style, self::FETCH_ALL, $prepare_data);
    }

    /**
     * @param string $sql
     * @param int    $style
     * @param array  $prepare_data
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function fetchOne(string $sql, $prepare_data = [], $style = PDO::FETCH_ASSOC)
    {
        return $this->fetch($sql, $style, self::FETCH_ONE, $prepare_data);
    }

    /**
     * @param string $sql
     * @param array  $prepare_data
     *
     * @return mixed
     * @throws \Exception
     */
    public function fetchObj(string $sql, $prepare_data = [])
    {
        $db   = self::getDb();
        $stmt = $db->prepare($sql);
        if ($prepare_data) {
            $stmt->execute($prepare_data);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchObject();
    }

    /**
     * @param string $sql
     * @param array  $prepare_data
     *
     * @return bool
     * @throws \Exception
     */
    public function execute(string $sql, $prepare_data = [])
    {
        $pdo  = self::getDb();
        $stmt = $pdo->prepare($sql);

        return $stmt->execute($prepare_data);
    }

    /**
     * @param string $sql
     * @param        $style
     * @param        $type
     * @param array  $prepare_data
     *
     * @return array|mixed
     * @throws \Exception
     */
    protected function fetch(string $sql, $style, $type, $prepare_data = [])
    {
        $pdo  = self::getDb();
        $stmt = $pdo->prepare($sql);

        if (empty($prepare_data)) {
            $stmt->execute();
        } else {
            $stmt->execute($prepare_data);
        }

        if ($type == self::FETCH_ONE) {
            return $stmt->fetch($style);
        }

        return $stmt->fetchAll($style);
    }
}