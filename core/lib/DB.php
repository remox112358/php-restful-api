<?php

namespace core\lib;

use PDO;

/**
 * Database connection class using PDO.
 */
final class DB
{
    /**
     * Database connection config.
     *
     * @var array
     */
    protected $config;

    /**
     * Database connection object.
     *
     * @var object
     */
    protected $db;

    /**
     * Database connection constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $cfg = require_once 'config/db.php';

        try {
            $db = new PDO($cfg['dsn'] . ';' . $cfg['charset'], $cfg['user'], $cfg['password']);
        } catch(PDOException $error) {
            die($error->getMessage());
        }

        $this->config = $cfg;
        $this->db     = $db;
    }

    /**
     * Makes query to database using PDO.
     *
     * @param  string $sql    - SQL query that needs to prepare.
     * @param  array  $params - Params that needs to bind.
     * @param  string $fetch  - Fetch type of query.
     * @return void
     */
    public function query(string $sql, array $params = [], string $fetch = 'row')
    {
        $stmt = $this->db->prepare($sql);

        if (! empty($params)) {
            foreach ($params as $param => $value) {
                $stmt->bindValue(':' . $param, $value);
            }
        }

        $stmt->execute();

        return $this->$fetch($stmt);
    }

    /**
     * Returns query result in row format.
     *
     * @param  object $stmt - SQL query statement.
     * @return array
     */
    public function row($stmt) : array
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns query result in column format.
     * If the result isn`t one field, returns first field value.
     *
     * @param  object $stmt - SQL query statement.
     * @return void
     */
    public function column($stmt)
    {
        return $stmt->fetchColumn();
    }
}