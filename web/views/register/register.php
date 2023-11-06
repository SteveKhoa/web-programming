<div class="w-50 mx-auto">
    <div id="addProductsCard" class="p-5 shadow rounded-3">
        <div class="pb-5">
            <h4>REGISTER</h4>
            <p>Begin your journey, today.</p>
            <p>Register now as a Client.</p>
        </div>

        <div>
            <form action="controllers/form.php?type=register" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="user_name" maxlength="32"="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="user_password" maxlength="32" type="password" class="form-control" required>
                </div>
                <div class="mt-5">
                    <div class="mr-5">
                        <button type="submit" class="col-4 btn btn-primary">REGISTER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>