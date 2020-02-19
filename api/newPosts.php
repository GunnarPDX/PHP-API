<?php

if ($method == 'GET') {

    echo Req::GET($tableName, $id);

} else if ($method == 'POST') {

    if ($_POST == null) {

        echo json_encode(['message' => 'ERROR: missing fields', 'success' => false]);

    } else {

        extract($_POST);

        $query = "INSERT INTO $tableName VALUES(null, :title, :body, :author, null)";

        $params = array(':title' => $title, ':body' => $body, ':author' => $author);

        $data = Req::POST($tableName, $query, $params);

        echo json_encode(['message' => 'Post added successfully', 'success' => true, 'post' => $data[0]]);

    }

} else if ($method == 'PUT') {

    if ($id == null){

        echo json_encode(['message' => 'Post id missing', 'success' => false]);

    } else {

        extract(json_decode(file_get_contents('php://input'), true));

        $query = "UPDATE $tableName SET title=:title, body=:body, author=:author WHERE id = :id";

        $params = array(':title' => $title, ':body' => $body, ':author' => $author, ':id' => $id);

        $data = Req::PUT($tableName, $id, $query, $params);

        echo json_encode(['post' => $data[0], 'message' => 'Post updated successfully', 'success' => true]);

    }

} else if ($method == 'DELETE') {

    if ($id == null) {

        echo json_encode(['message' => 'Post id missing', 'success' => false]);

    } else if (Req::DELETE($tableName, $id)) {

        echo json_encode(['message' => 'Post deleted successfully', 'success' => true]);

    } else {

        echo json_encode(['message' => 'Post deleted successfully', 'success' => false]);

    }

} else {

    echo json_encode(['message' => 'Method not found', 'success' => false]);

}
