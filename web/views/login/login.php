<div class="w-50 mx-auto">
    <div id="addProductsCard" class="p-5 shadow rounded-3">
        <div class="pb-5">
            <h4>LOGIN</h4>
        </div>

        <div>
            <form action="controllers/form.php?type=login" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="user_name" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="user_password" type="password" class="form-control" required>
                </div>
                <div class="mt-5">
                    <p>
                        <?php
                        if (isset($_GET['invalid_acc'])) {
                            echo "Your Username or Password is invalid.";
                        }
                        ?>
                    </p>
                    <div class="mr-5">
                        <button type="submit" class="col-4 btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>