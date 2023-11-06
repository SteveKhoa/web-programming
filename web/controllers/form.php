<div>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    class FormController
    {
        private $data;
        private $available_models;

        public function __construct($data, $available_models)
        {
            $this->data = $data;
            $this->available_models = $available_models;
        }

        public function updateData($data)
        {
            $this->data = $data;
        }

        public function delegateToModel($model_type)
        {
            if (array_key_exists($model_type, $this->available_models)) {
                // Delegate the data to appropriate model

                include "../" . $this->available_models[$model_type];
                $model->handleData($this->data);
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "error_handler.php?type=invalid_service");
            }
        }
    }

    $available_models = array(
        "login" => "models/login.php",
        "add_products" => "models/insert.php",
        "register" => "models/register.php",
        "logout" =>  "models/logout.php"
    );

    $form_controller = new FormController(array(), $available_models);

    if (isset($_GET['type'])) {
        $form_type = $_GET['type'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form_controller->updateData($_POST);
        } else {
            $form_controller->updateData($_GET);
        }

        $form_controller->delegateToModel($form_type);
    }
    ?>
</div>