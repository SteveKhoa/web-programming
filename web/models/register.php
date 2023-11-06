<?php
include_once("commons.php");

class RegisterModel extends Model
{
    public function handleData($data)
    {
        $conn = new mysqli("localhost", "root");

        $username = $data['user_name'];
        $password = hash("sha256", $data['user_password']);
        $userid = hash("sha256", $username . $password);

        $conn->query("INSERT INTO OnlineStore.users (id, username, password, user_group) VALUES ('$userid', '$username', '$password', 'Client')");

        $conn->close();

        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=home");
    }
}

$model = new RegisterModel();
