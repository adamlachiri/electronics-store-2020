<?php
class Database
{
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;

    private function connection()
    {
        $db_info = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            return new PDO($db_info, $this->db_user, $this->db_pass, $options);
        } catch (PDOException $error) {
            echo $error->getMessage();
            die();
        }
    }

    protected function get_data($sql, $info = [])
    {
        $db = $this->connection();
        $statement = $db->prepare($sql);
        $statement->execute($info);
        return $statement->fetchAll();
    }

    protected function post_data($sql, $info)
    {
        $db = $this->connection();
        $statement = $db->prepare($sql);
        $statement->execute($info);
    }
}
