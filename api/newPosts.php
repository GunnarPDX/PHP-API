<?php

// Check if method is a GET request
if ($method == 'GET') {

    // Request read for post/posts
    $data = DB::read($tableName, $id);

    // Return data - NOTE: Add error handling/responses to methods including this one
    echo json_encode($data);

// Check if method is a POST request
} else if ($method == 'POST') {

    // Ensure post params are present
    if ($_POST == null) {

        // Respond with failure if params are missing
        echo json_encode(['message' => 'ERROR: missing fields', 'success' => false]);

    } else {

        // Extract post params
        extract($_POST);

        // Create SQL query
        $query = "INSERT INTO $tableName VALUES(null, :title, :body, :author, null)";

        // Create params array
        $params = array(':title' => $title, ':body' => $body, ':author' => $author);

        // Request create action
        $data = DB::create($tableName, $query, $params);

        // Respond with data
        echo json_encode(['message' => 'Post added successfully', 'success' => true, 'post' => $data]);

    }

// If the request method is PUT
} else if ($method == 'PUT') {

    // Ensure id's presence
    if ($id == null){

        // Respond with failure if id is missing
        echo json_encode(['message' => 'Post id missing', 'success' => false]);

    } else {

        // Extract PUT params
        extract(json_decode(file_get_contents('php://input'), true));

        // Create update query
        $query = "UPDATE $tableName SET title=:title, body=:body, author=:author WHERE id = :id";

        // Create params array
        $params = array(':title' => $title, ':body' => $body, ':author' => $author, ':id' => $id);

        // Request update
        $data = DB::update($tableName, $id, $query, $params);

        // Return updated data on success
        echo json_encode(['post' => $data[0], 'message' => 'Post updated successfully', 'success' => true]);

    }

// If request is for DELETE
} else if ($method == 'DELETE') {

    // Ensure id's presence
    if ($id == null) {

        // Return failure if id is missing
        echo json_encode(['message' => 'Post id missing', 'success' => false]);

    // If post deletes successfully
    } else if (DB::delete($tableName, $id)) {

        // Respond with success
        echo json_encode(['message' => 'Post deleted successfully', 'success' => true]);

    } else {

        // Respond with failure if post is unable to be removed
        echo json_encode(['message' => 'Post failed to delete', 'success' => false]);

    }

// If the request could not be handled the respond with base failure message
} else {

    echo json_encode(['message' => 'Your request could not be processed.', 'success' => false]);

}
