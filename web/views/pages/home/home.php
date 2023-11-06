<div>
    <h1>
        <?php
        if (isset($_SESSION['STARTED'])) {
            echo "You are logged in!";
        } else {
            echo "HOME";
        }
        ?>
    </h1>

    <?php if (isset($_SESSION['STARTED'])) { ?>
        <div>
            <h4>Welcome back,
                <span class="text-primary">
                    <?php
                    echo $_SESSION['username'];
                    ?>.
                </span>
            </h4>
        </div>
    <?php } else { ?>
        <div>
            <h4>You are not logged in.
            </h4>
        </div>
    <?php } ?>
</div>