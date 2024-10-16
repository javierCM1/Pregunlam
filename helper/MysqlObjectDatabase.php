<?php
class MysqlObjectDatabase
{
    private $conn;

    public function __construct($host, $port, $username, $password, $database)
    {
        $this->conn = mysqli_connect($host, $username, $password, $database, $port);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function query($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function execute($sql)
    {
        mysqli_query($this->conn, $sql);
        return $this->conn->affected_rows;
    }

    public function prepare($sql)
    {
        return mysqli_prepare($this->conn, $sql);
    }

    public function bindParam($stmt, $types, ...$params) {
        $paramsWithTypes = array_merge([$types], $params);
        call_user_func_array([$stmt, 'bind_param'], $paramsWithTypes);
    }

    public function executeStmt($stmt)
    {
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt);
    }

    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}
