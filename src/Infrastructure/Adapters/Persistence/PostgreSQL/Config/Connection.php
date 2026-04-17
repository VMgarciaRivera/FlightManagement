<?php

class Connection {
    private static ?PDO $connection = null;

    public static function getInstance(): PDO {
        if (self::$connection === null) {
            
            $host = getenv('DB_HOST') ?: 'localhost';
            $db   = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            $port = getenv('DB_PORT') ?: '5432';

            $dsn = "pgsql:host=$host;port=$port;dbname=$db";
            
            try {
                // Creamos la conexión PDO
                self::$connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                // Si falla, mostramos el error (importante para debugging)
                die("Error de conexión a PostgreSQL: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}