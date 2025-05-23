<?php

class DatabaseSingleton {
    private $host;
    private $db;
    private $user;
    private $pass;

    private static $instance;

    // Singleton para obligar a tener solo una instancia de este objeto
    static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function connect() {
        $config = json_decode(file_get_contents(DB_CONFIG), true);

        $this->host = $config['host'];
        $this->db = $config['db'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];

        try {
            return new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8mb4", $this->user, $this->pass,[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        } catch (PDOException $e) {
            echo ("Excepción al conectar con la base de datos: " . $e);
        }
    }
}