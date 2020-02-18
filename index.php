<?php
//MAMP App


// Allow any cross origin access
header('Access-Control-Allow-Origin: *');

// Allow CRUD methods
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

// Set request method var
$method = $_SERVER['REQUEST_METHOD'];

// Get request URI for route
$request_uri = $_SERVER['REQUEST_URI'];


// Sanitize URI
$route = filter_var($request_uri, FILTER_SANITIZE_URL);

// Delimit the route into array
$route = explode('/', $route);

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

    // Include the api matching route
    if (strcmp($tableName, 'posts') == 0) include_once './api/posts.php';

} else {

    // If table route does not exist then return error
    echo json_encode(['message' => 'Method does not exist']);
}



