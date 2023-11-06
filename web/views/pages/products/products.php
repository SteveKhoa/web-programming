<div class="w-50 mx-auto">
    <div class="p-5 shadow rounded-3">
        <div class="pb-5">
            <h4>View Products</h4>
            <p>Your dream market here.</p>
        </div>

        <div class="my-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search products">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Search by</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">By ID</a></li>
                    <li><a class="dropdown-item" href="#">By Name</a></li>
                    <li><a class="dropdown-item" href="#">By Price</a></li>
                </ul>
                <button class="btn btn-primary" type="button">Search</button>
            </div>
        </div>

        <?php if (isset($_SESSION['products_data']) && count($_SESSION['products_data']) > 0) { ?>
            <div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <?php foreach ($_SESSION['column_names'] as $row) { ?>
                                    <th scope="col"><?php echo $row[0]; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['products_data'] as $row) { ?>
                                <tr>
                                    <th scope="row"><?php echo $row['id']; ?></th>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else if (isset($_SESSION['products_data']) && count($_SESSION['products_data']) <= 0) { ?>
                <p class="fw-bold text-center">No product exists.</p>
            <?php } else { ?>
                <div class="mt-5">
                    <a type="submit" class="btn btn-outline-dark" href="controllers/form.php?type=view_products">See all products</a>
                </div>
            </div>
        <?php } ?>
        <?php
        unset($_SESSION['products_data']);
        unset($_SESSION['column_names']);
        ?>
    </div>
</div>

<?php if (isset($_SESSION['STARTED']) && isset($_SESSION['user_group']) && $_SESSION['user_group'] == 'Admin') { ?>
    <div class="col-2 mx-auto my-5" data-bs-toggle="collapse" data-bs-target="#addProductsCard">
        <button class="btn btn-outline-primary">ADD NEW PRODUCT</button>
    </div>
<?php } ?>

<div class="w-50 mx-auto">
    <div id="addProductsCard" class="collapse p-5 shadow rounded-3">
        <div class="pb-5">
            <h4>Add new Products</h4>
            <p>Start selling your items today.</p>
        </div>

        <div>
            <form action="controllers/form.php?type=add_products" method="POST">
                <div class="mb-3">
                    <label class="form-label">Product ID</label>
                    <input name="product_id" type="text" class="form-control" placeholder="xxxx" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input name="product_name" type="text" class="form-control" placeholder="ProductABC..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input name="product_price" type="number" step="0.01" class="form-control" placeholder="$$$" required>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="mr-5">
                        <button type="submit" class="col-4 btn btn-primary">INSERT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>