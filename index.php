<?php

// Allow any cross origin access
header('Access-Control-Allow-Origin: *');

// Allow CRUD methods
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

// Set request method var
$method = $_SERVER['REQUEST_METHOD'];

// Get, Sanitize, and Delimit the URI route into array
$route = explode('/', filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));

// Create model/table var
$tableName = (string) $route[3];

// Check for id
if ($route[4] != null) {

    // Set id var if present
    $id = (int) $route[4];

} else {

    // Set id to null if not present
    $id = null;

}

// Create array full of table names
$tables = ['posts'];

// Check table names
if (in_array($tableName, $tables)) {

    // Include the DB
    include_once './classes/Database.php';

    // Router switch
    switch ($tableName) {
        case 'posts':
            // Include posts 'controller'
            include_once './api/posts.php';

            break;
        case 'auth':
            // Include auth 'controller'
            include_once './api/auth.php';

            break;
    }

} else {

    // If route does not exist then return error
    echo json_encode(['message' => 'Route does not exist']);
}




