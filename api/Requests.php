<?php

class Req {

    public static function queryId($id, $tableName) {

        return DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));

    }

    public static function GET($tableName, $id) {

        if($id != null){

            return self::queryId($id, $tableName);

        } else {

            return DB::query("SELECT * FROM $tableName");

        }
    }

    public static function POST($tableName, $postQuery, $postParams) {

        DB::query($postQuery, $postParams);

        return DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");

    }

    public static function PUT($tableName, $id, $putQuery, $putParams) {

        DB::query($putQuery, $putParams);

        return self::queryId($id, $tableName);

    }

    public static function DELETE($tableName, $id) {

        return DB::query("DELETE FROM $tableName WHERE id=:id", array(':id' => $id));

    }

}
