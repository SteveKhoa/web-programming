<?php

/** Enable PHP error reporting */
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
session_start();

// Each session will be terminated after 30 seconds
$session_timeout = 30;

if (isset($_SESSION['STARTED']) && isset($session_timeout) && (time() - $_SESSION['STARTED'] > $session_timeout)) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "controllers/form.php?type=logout");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Online Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div id="app-header">
        <nav class="navbar navbar-expand-lg m-1">
            <div class="container-fluid">
                <div>
                    <a class="navbar-brand" href="/">
                        <img src="/assets/favicon.png" alt="" width="32" height="32" class="d-inline-block align-text-top">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarContents">
                    <div class="navbar-nav fw-bold">
                        <a class="nav-link" href="index.php?page=home">Home</a>
                        <a class="nav-link" href="index.php?page=products">Products</a>
                        <?php if (isset($_SESSION['STARTED'])) { ?>
                            <a class="nav-link" href="controllers/form.php?type=logout">Logout</a>
                        <?php } else { ?>
                            <a class="nav-link" href="index.php?page=login">Login</a>
                            <a class="nav-link" href="index.php?page=register">Register</a>
                        <?php } ?>
                    </div>
                </div>
                <?php if (isset($_SESSION['STARTED'])) { ?>
                    <div class="navbar-item">
                        <span class="fw-bold text-primary nav-text"><?php echo $_SESSION['username']; ?></span> <br>
                        <span class="nav-text"><?php echo $_SESSION['user_group'] ?></span>
                    </div>
                <?php } ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContents">
                    <span class="navbar-toggler-icon material-icons nav-link">unfold_more</span>
                </button>
            </div>
        </nav>
    </div>
    <div id="app-body">
        <div class='m-5'>
            <?php
            $router->renderPage();
            ?>
        </div>
    </div>
    <div id="app-footer" style="height:200px;"></div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>