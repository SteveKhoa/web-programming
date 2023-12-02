<?php
include_once("commons.php");

class RegisterModel extends Model
{
    private function validateInput($username, $password)
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

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=login&auth_err&err_msg=$err_msg&solution_href=$solution_href&solution_msg=$solution_msg&invalid_username=$username");
        } else {
            $conn->query("INSERT INTO OnlineStore.users (id, username, password, user_group) VALUES ('$userid', '$username', '$password', 'Client')");

            if (isset($data['city']) && isset($data['district'])) {
                $city = $data['city'];
                $district = $data['district'];
                $conn->query("INSERT INTO OnlineStore.user_addresses (id, city, province) VALUES ('$userid', '$city', '$district')");
            }

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=login&register_sucess=$username");
        }

        $conn->close();
    }
}

$model = new RegisterModel();
