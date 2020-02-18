<?php

//Posts Controller

// Check if method is a GET request
if ($method == 'GET') {

    // If there is an id
    if ($id) {

        // Perform query for specific model by id
        $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));

        // If data is present
        if ($data != null) {

            // Respond with data
            echo json_encode($data[0]);

        } else {

            // Respond with error message
            echo json_encode(['message' => 'Post Not Found.']);

        }
    } else {

        // If there is no id then get all data
        $data = DB::query("SELECT * FROM $tableName");

        // Respond with data
        echo json_encode($data);

    }

// Check if method is a POST request
} else if ($method == 'POST') {

    // If POST data is present and there is no id
    if ($_POST != null && !$id) {

        // Extract data from POST data
        extract($_POST);

        // Create query
        DB::query("INSERT INTO $tableName VALUES(null, :title, :body, :author, null)", array(':title' => $title, ':body' => $body, ':author' => $author));

        // Creation success/failure handling should be added

        // Retrieve submitted data for response
        $data = DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");

        // Respond with latest data and success
        echo json_encode(['message' => 'Post added to the database successfully.', 'success' => true, 'post' => $data[0]]);

    } else if ($id) {

        // Respond with error message for id presence
        echo json_encode(['message' => 'ERROR: ID should not be present in fields', 'success' => false]);

    } else {

        //return error message
        echo json_encode(['message' => 'ERROR: missing fields', 'success' => false]);

    }

// If id is present then we are handling a PUT or DELETE request at this stage
} else if ($id) {

    // Find Post in database
    $post = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));

    // Make sure obj exists
    if ($post != null) {

        // If the request method is PUT
        if ($method == 'PUT') {

            // Extract data
            extract(json_decode(file_get_contents('php://input'), true));

            // Update the Post in the Database
            DB::query("UPDATE $tableName SET title=:title, body=:body, author=:author WHERE id = :id", array(':title' => $title, ':body' => $body, ':author' => $author, ':id' => $id));

            // Retrieve the updated post
            $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));

            // Respond with updated post and success
            echo json_encode(['post' => $data[0], 'message' => 'Post Updated successfully', 'success' => true]);

        // If request is for DELETE
        } elseif ($method == 'DELETE') {

            // Find obj and delete
            DB::query("DELETE FROM $tableName WHERE id=:id", array(':id' => $id));

            // Respond with success message
            echo json_encode(['message' => 'Post Deleted successfully', 'success' => true]);

        }
    } else {

        // Respond with failure message if obj does not exist
        echo json_encode(['message' => 'Post not found.', 'success' => false]);

    }
} else {

    // Respond with error message
    echo json_encode(['message' => 'ERROR: Your response could not be processed', 'success' => false]);

}
