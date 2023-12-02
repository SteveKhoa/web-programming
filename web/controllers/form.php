
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

        public function listeningToRequests()
        {
            if (isset($_GET['type'])) {
                $form_type = $_GET['type'];

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->updateData($_POST);
                } else {
                    $this->updateData($_GET);
                }

                $this->delegateToModel($form_type);
            }
        }

        private function updateData($data)
        {
            $this->data = $data;
        }

        private function delegateToModel($model_type)
        {
            if (array_key_exists($model_type, $this->available_models)) {
                // Delegate the data to appropriate model
                include_once($_SERVER['DOCUMENT_ROOT'] . "/" . $this->available_models[$model_type]['src']);

                if (isset($this->available_models[$model_type]['params']))
                    $model->handleParams($this->available_models[$model_type]['params']);
                $model->handleData($this->data);
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "error_handler.php?type=invalid_service");
            }
        }
    }

    $available_models = array(
        "login" => array("src" => "models/login.php", "params" => array()),
        "add_products" => array("src" => "models/products.php", "params" => array("add")),
        "view_products" => array("src" => "models/products.php", "params" => array("view")),
        "query_products" => array("src" => "models/products.php", "params" => array("query")),
        "details_product" => array("src" => "models/products.php", "params" => array("details")),
        "register" => array("src" => "models/register.php", "params" => array()),
        "logout" =>  array("src" => "models/logout.php", "params" => array())
    );

    $form_controller = new FormController(array(), $available_models);
    $form_controller->listeningToRequests();
    ?>