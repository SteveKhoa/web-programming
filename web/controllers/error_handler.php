<?php
class ErrorHandler {
    public function renderErrorPage($err_type) {
        header("Location: views/error/error.php?type='$err_type'");
    }
}