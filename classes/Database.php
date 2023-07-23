<?php
/**
 * Database
 *
 * A connection to the database
 */
class Database{
    /**
     * Hostname
     * @var string
     */
    protected $db_host;

    /**
     * Hostname
     * @var string
     */
    protected $db_name;

    /**
     * Hostname
     * @var string
     */
    protected $db_user;

    /**
     * Hostname
     * @var string
     */
    protected $db_pass;


    public function __construct($host, $name, $user, $password)
    {
        $this ->db_host = $host;
        $this ->db_name = $name;
        $this ->db_user = $user;
        $this ->db_pass = $password;
    }
    /**
     * Get database connection
     *
     * @return PDO object Connection to the database server
     */
    public function getConn() {

        $dsn = 'mysql:host='. $this->db_host . ';dbname=' . $this->db_name . ';charset=utf8';

        try {
            $db = new PDO($dsn, $this->db_user,  $this->db_pass);
            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            $e->getMessage();
            exit;
        }
    }
}