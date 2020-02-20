<?php

class Req {

    // Basic CRUD methods

    public static function create($tableName, $postQuery, $postParams) {

        // Create query
        DB::query($postQuery, $postParams);

        // Retrieve and return submitted data for response
        return DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");

    }

    public static function read($tableName, $id) {

        // If data is present
        if($id != null){

            // Perform query for specific model by id
            return self::queryId($id, $tableName);

        } else {

            // If there is no id then get all data
            return DB::query("SELECT * FROM $tableName");

        }
    }

    public static function update($tableName, $id, $putQuery, $putParams) {

        // Update the Post in the Database
        DB::query($putQuery, $putParams);

        // Perform query for specific model by id
        return self::queryId($id, $tableName);

    }

    public static function delete($tableName, $id) {

        // Find obj and delete
        return DB::query("DELETE FROM $tableName WHERE id=:id", array(':id' => $id));

    }

    public static function queryId($id, $tableName) {

        // Perform query by id
        return DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));

    }

}
