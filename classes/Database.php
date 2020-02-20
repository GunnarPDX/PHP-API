<?php

// Database class
// This includes methods used to setup the DB connection and perform basic CRUD actions

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
        // Reference this class instance and connect to db before query
        $statement = self::connect()->prepare($query);

        // Execute the query
        $statement->execute($params);

        // If query starts with select
        if (explode(' ', $query)[0] == 'SELECT') {

            // Fetch data
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Return data
            return $data;
        }
    }

    // Basic CRUD methods

    // CREATE
    public static function create($tableName, $postQuery, $postParams) {

        // Create query
        self::query($postQuery, $postParams);

        // Retrieve and return submitted data for response
        return self::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");

    }

    // READ
    public static function read($tableName, $id) {

        // If data is present
        if($id != null){

            // Perform query for specific model by id
            return self::queryId($id, $tableName);

        } else {

            // If there is no id then get all data
            return self::query("SELECT * FROM $tableName");

        }
    }

    // UPDATE
    public static function update($tableName, $id, $putQuery, $putParams) {

        // Update the Post in the Database
        DB::query($putQuery, $putParams);

        // Perform query for specific model by id
        return self::queryId($id, $tableName);

    }

    // DELETE
    public static function delete($tableName, $id) {

        // Find obj and delete
        return self::query("DELETE FROM $tableName WHERE id=:id", array(':id' => $id));

    }

    // Query by obj id
    public static function queryId($id, $tableName) {

        // Perform query by id
        return self::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));

    }
}