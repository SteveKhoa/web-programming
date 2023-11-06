<?php
$conn = new mysqli("localhost", "root");

/** Create database tables */
$conn->query("CREATE DATABASE IF NOT EXISTS OnlineStore");
$conn->select_db("OnlineStore");
$conn->query("CREATE TABLE IF NOT EXISTS products (id CHAR(4), product_name VARCHAR(255), price FLOAT(24))");
$conn->query("CREATE TABLE IF NOT EXISTS users (id VARCHAR(256) PRIMARY KEY, username VARCHAR(128), password VARCHAR(128), user_group VARCHAR(32))");

/** Insert a default 'admin' account */
$username = "me";
$password = hash("sha256", "123");
$userid = hash("sha256", $username . $password);
if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.users WHERE id='$userid'")) <= 0) {
    $conn->query("INSERT INTO OnlineStore.users (id, username, password, user_group) VALUES ('$userid', '$username', '$password', 'Admin')");
}

/** Insert a default 'client' account */
$username = "teacher";
$password = hash("sha256", "123");
$userid = hash("sha256", $username . $password);
if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.users WHERE id='$userid'")) <= 0) {
    $conn->query("INSERT INTO OnlineStore.users (id, username, password, user_group) VALUES ('$userid', '$username', '$password', 'Client')");
}

/** Insert a default 'product' */
$product_id = "0000";
$product_name = "ExampleProduct";
$product_price = 125.50;
if (mysqli_num_rows($conn->query("SELECT * FROM OnlineStore.products WHERE id='$product_id'")) <= 0) {
    $conn->query("INSERT INTO OnlineStore.products VALUES ('$product_id', '$product_name', $product_price)");
}


$conn->close();
