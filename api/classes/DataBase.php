<?php

class DataBase
{
    public $db;
    public $result;

    function __construct()
    {
        $settings = Settings::get('db');
        $this->db = new \PDO(
            "mysql:hostname={$settings['host']};dbname={$settings['name']}",
            $settings['user'],
            $settings['pass'],
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
            ]
        );
    }

    function get_db()
    {
        return $this->db;
    }

    private function prepare($sql)
    {
        return $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    }

    /**
     * Executes a SELECT
     * 
     * @param string $sql 'SELECT name, colour, calories FROM fruit WHERE calories < :calories AND colour = :colour';
     * $params = ['calories' => 150, 'colour' => 'red']
     */
    function select($sql, $params = [])
    {
        try {
            $sth = $this->prepare($sql);
            $sth->execute($params);
            $this->result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $this->result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function echo_json($result = null)
    {
        header('Content-Type: application/json');
        echo json_encode($result ? $result : $this->result);
    }

    function query($sql, $params = [])
    {
        $sth = $this->prepare($sql);
        try {
            $sth->execute($params);
        } catch (Exception $e) {
            throw $e;
        }
    }

    function query_multiple($sql, $params = [])
    {
        $sth = $this->prepare($sql);
        try {
            $this->db->beginTransaction();
            foreach ($params as $param_row) {
                $sth->execute($param_row);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}