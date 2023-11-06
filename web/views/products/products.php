<div class="w-50 mx-auto">
    <div class="p-5 shadow rounded-3">
        <div class="pb-5">
            <h4>View Products</h4>
            <p>Your dream market here.</p>
        </div>

        <div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <?php
                        $conn = new mysqli("localhost", "root");

                        $res =  $conn->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'products'");

                        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                            echo '<th scope="col">' . $row['COLUMN_NAME'] . '</th>';
                        }

                        $conn->close();
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root");

                    $res =  $conn->query("SELECT * FROM OnlineStore.products");

                    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo "</tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
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