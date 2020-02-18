<?php

class DB
{
    // This function handles the DB connection
    private static function connect()
    {
        // Set up connection
        $pdo = new PDO('mysql:host=localhost:8889;dbname=rest_api_php', 'root', 'root');

        // Set error mode and exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Return connection
        return $pdo;

    }

    // This function handles queries
    public static function query($query, $params = array())
    {
        // Reference this class instance and connect
        $statement = self::connect()->prepare($query);

        // Execute the query
        $statement->execute($params);

        // If query starts with select
        if (explode(' ', $query)[0] == 'SELECT') {

            //
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            //
            return $data;

        }
    }
}