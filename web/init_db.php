<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root");

/** Create database tables */
$conn->query("CREATE DATABASE IF NOT EXISTS OnlineStore");
$conn->select_db("OnlineStore");
$conn->query("CREATE TABLE IF NOT EXISTS products (id CHAR(4), product_name VARCHAR(255), price FLOAT(24))");
$conn->query("CREATE TABLE IF NOT EXISTS users (id VARCHAR(256) PRIMARY KEY, username VARCHAR(128), password VARCHAR(128), user_group VARCHAR(32))");
$conn->query("CREATE TABLE IF NOT EXISTS user_addresses (id VARCHAR(256) PRIMARY KEY, city VARCHAR(128), district VARCHAR(128))");


/** Insert a default 'admin' account */
$username = "admin@store.com";
$password = hash("sha256", "Abc123@");
$userid = hash("sha256", $username . $password);
if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.users WHERE id='$userid'")) <= 0) {
    $conn->query("INSERT INTO OnlineStore.users (id, username, password, user_group) VALUES ('$userid', '$username', '$password', 'Admin')");
}

/** Insert a default 'client' account */
$username = "teacher@store.com";
$password = hash("sha256", "Abc123@");
$userid = hash("sha256", $username . $password);
if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.users WHERE id='$userid'")) <= 0) {
    $conn->query("INSERT INTO OnlineStore.users (id, username, password, user_group) VALUES ('$userid', '$username', '$password', 'Client')");
}


/** Insert default 'product's */
$mock_products = json_decode(file_get_contents("mock_products.json"));;

foreach ($mock_products as $product) {
    $product_id = $product->{'id'};
    $product_name = $product->{'product_name'};
    $product_price = $product->{'price'};
    if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.products WHERE id='$product_id'")) <= 0) {
        $conn->query("INSERT INTO OnlineStore.products VALUES ('$product_id', '$product_name', $product_price)");
    }
}

// $product_id = "0000";
// $product_name = "ExampleProduct";
// $product_price = 125.50;
// if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.products WHERE id='$product_id'")) <= 0) {
//     $conn->query("INSERT INTO OnlineStore.products VALUES ('$product_id', '$product_name', $product_price)");
// }
// $product_id = "0100";
// $product_name = "SeaProduct";
// $product_price = 25.50;
// if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.products WHERE id='$product_id'")) <= 0) {
//     $conn->query("INSERT INTO OnlineStore.products VALUES ('$product_id', '$product_name', $product_price)");
// }
// $product_id = "0102";
// $product_name = "LandProduct";
// $product_price = 15.50;
// if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.products WHERE id='$product_id'")) <= 0) {
//     $conn->query("INSERT INTO OnlineStore.products VALUES ('$product_id', '$product_name', $product_price)");
// }
// $product_id = "0170";
// $product_name = "AirProduct";
// $product_price = 95.50;
// if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.products WHERE id='$product_id'")) <= 0) {
//     $conn->query("INSERT INTO OnlineStore.products VALUES ('$product_id', '$product_name', $product_price)");
// }


$conn->close();
