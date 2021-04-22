<?php

namespace Smp\Storage;

use PDO;
use Smp\Smp;

/**
 * Class Database
 * @package Smp\Storage
 */
class Database
{
    protected const FETCH_ONE = 1;
    protected const FETCH_ALL = 2;

    /**@var \PDO $pdo */
    private $pdo;

    public function __construct()
    {
        $db_config = Smp::$app->db;

        try {
            $this->pdo = new PDO('mysql:host=' . $db_config['host'] . ';dbname=' . $db_config['dbname'], $db_config['user'], $db_config['password']);
            $this->pdo->exec("SET NAMES utf8");
        } catch (\PDOException $exception) {
            throw new \RuntimeException('Error connected Db: ' . $exception);
        }
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /* @param string $sql
     * @param int   $style
     * @param array $prepare_data
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
        $stmt = $this->getPdo()->prepare($sql);
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
        $stmt = $this->getPdo()->prepare($sql);

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
        $stmt = $this->getPdo()->prepare($sql);

        if (empty($prepare_data)) {
            $stmt->execute();
        } else {
            $stmt->execute($prepare_data);
        }

        if ($type === self::FETCH_ONE) {
            return $stmt->fetch($style);
        }

        return $stmt->fetchAll($style);
    }

    /**
     * @return int
     */
    public function getLastInsertId(): int
    {
        return (int)$this->getPdo()->lastInsertId();
    }
}