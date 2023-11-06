<?php
include_once("commons.php");

class LoginModel extends Model
{
    public function handleData($data)
    {
        $conn = new mysqli("localhost", "root");

        $username = $data['user_name'];
        $password = hash("sha256", $data['user_password']);
        $userid = hash("sha256", $username . $password);

        $user_query = $conn->query("SELECT * FROM OnlineStore.users WHERE id='$userid'");

        if (mysqli_num_rows($user_query) > 0) {
            $row = mysqli_fetch_assoc($user_query);

            session_start();

            session_regenerate_id(true);
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_group'] = $row['user_group'];
            $_SESSION['STARTED'] = time();

            $conn->close();
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php");
        } else {

            $conn->close();
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=login&invalid_acc");
        }
    }
}

$model = new LoginModel();