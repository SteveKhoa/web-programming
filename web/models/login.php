<?php
include_once("commons.php");

class LoginModel extends Model
{
    public function validateInput($username, $password)
    {
        $is_valid_username = filter_var($username, FILTER_VALIDATE_EMAIL) !== "";
        $is_valid_password = preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z\d])(?=.*[A-Z]).*$/', $password);
        $is_long_password = strlen($password) >= 6;

        if ($is_valid_username == 1 && $is_valid_password == 1 && $is_long_password) {
            return true;
        } else {
            return false;
        }
    }

    public function handleData($data)
    {
        $conn = new mysqli("localhost", "root");

        $username = $data['user_name'];
        $password = hash("sha256", $data['user_password']);
        $userid = hash("sha256", $username . $password);

        if (!$this->validateInput($username, $data['user_password'])) {
            $err_msg = "Your username or password was not in a correct format.";
            $solution_msg = "";
            $solution_href = "";

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=register&auth_err&err_msg=$err_msg&solution_href=$solution_href&solution_msg=$solution_msg&invalid_username=$username");
        } else {

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

                $err_msg = "Your username or password was not registered yet.";
                $solution_msg = "Register an account";
                $solution_href = "index.php?page=register";

                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=login&auth_err&err_msg=$err_msg&solution_href=$solution_href&solution_msg=$solution_msg");
            }
        }
    }
}

$model = new LoginModel();
