<?php
class AuthForm
{
    private $auth_type;

    public function __construct($auth_type)
    {
        $this->auth_type = strtolower($auth_type);

?>
        <div id="<?php echo $this->auth_type; ?>Card" class="p-5 shadow rounded-3">
            <div class="pb-5">
                <h4><?php echo ucfirst($this->auth_type); ?></h4>
                <div class="pt-2">
                    The username must be a valid email. <br>

                    The password must contain:
                    <ul>
                        <li>a special character,</li>
                        <li>a capitalized letter,</li>
                        <li>a letter,</li>
                        <li>a digit,</li>
                        <li>at least 6 characters long.</li>
                    </ul>
                </div>
            </div>

            <div>
                <form action="controllers/form.php?type=<?php echo $this->auth_type ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input name="user_name" type="email" class="form-control" placeholder="name@example.com" required value="<?php if (isset($_GET['invalid_username'])) {
                                                                                                                                        echo $_GET['invalid_username'];
                                                                                                                                    } else if (isset($_GET['register_sucess'])) {
                                                                                                                                        echo $_GET['register_sucess'];
                                                                                                                                    } ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input name="user_password" type="password" class="form-control" placeholder="At least 6 characters." minlength="6" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z\d])(?=.*[A-Z]).*$" required>
                        <!-- <input name="user_password" type="password" class="form-control" placeholder="At least 6 characters." minlength="6" required> -->
                    </div>
                    <div class="mt-5">
                        <?php
                        if (isset($_GET['auth_err'])) {
                        ?>
                            <p>
                                <span class="text-danger"><?php echo $_GET['err_msg']; ?></span><br>

                                <a href="<?php echo $_GET['solution_href']; ?>"><?php echo $_GET['solution_msg']; ?></a>
                            </p>
                        <?php } ?>
                        <div class="mr-5">
                            <button type="submit" class="col-4 btn btn-primary"><?php echo ucfirst($this->auth_type); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
?>