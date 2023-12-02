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
                <h1><?php echo ucfirst($this->auth_type); ?></h1>
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
                    <?php if ($this->auth_type == "register") { ?>
                        <div class="mb-3">
                            <label class="form-label">City/Province</label>
                            <select name="city" id="city" class="form-select" aria-label="Default select example">

                                <option value="Ho Chi Minh" selected>Ho Chi Minh</option>

                                <option value="Hanoi">Hanoi</option>

                                <option value="Danang">Danang</option>

                                <option value="Vinh Long">Vinh Long</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">District</label>
                            <select name="district" id="district" class="form-select">
                                <option value="Quan 1" selected>Quan 1</option>
                                <option value="Quan 2">Quan 2</option>

                                <option value="Ba Dinh">Ba Dinh</option>
                                <option value="Hoan Kiem">Hoan Kiem</option>

                                <option value="Son Tra">Son Tra</option>
                                <option value="Hai Chau">Hai Chau</option>

                                <option value="Binh Tan">Binh Tan</option>
                                <option value="Long Ho">Long Ho</option>
                            </select>
                            <script>
                                /**
                                 * Multi-level dependency between the options in the same form
                                 */
                                // If Javascript is not enabled, a full list of default options is diplayed
                                // If Javascript is enabled, multi-level dependency is activated

                                let cities = {
                                    "Ho Chi Minh": ["Quan 1", "Quan 2"],
                                    "Hanoi": ["Ba Dinh", "Hoan Kiem"],
                                    "Danang": ["Son Tra", "Hai Chau"],
                                    "Vinh Long": ["Binh Tan", "Long Ho"]
                                };

                                const updateDistrictDropdown = (event, districts) => {
                                    districtDropDown = document.querySelector("#district");
                                    districtDropDown.innerHTML = ""; // Clear default display

                                    for (const [_, district] of Object.entries(districts)) {
                                        let html = `<option value="${district}">${district}</option>`;
                                        districtDropDown.innerHTML += html;
                                    }
                                }

                                let cityDropdown = document.querySelector("#city");
                                let selectedCity = "Ho Chi Minh";

                                cityDropdown.onchange = (event) => {
                                    selectedCity = event.target.value;
                                    updateDistrictDropdown(event, cities[selectedCity]);
                                }
                                updateDistrictDropdown(event, cities["Ho Chi Minh"]);
                            </script>
                        </div>
                    <?php } ?>
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