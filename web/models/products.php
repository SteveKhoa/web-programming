<?php
include_once("commons.php");

class ProductModel extends Model
{
    private $responder;
    private $column_names;

    public function __construct()
    {
        $conn = new mysqli("localhost", "root");
        $information_schema =  $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'products'");
        $this->column_names = $information_schema->fetch_all(MYSQLI_NUM);
        $conn->close();

        $this->responder = new ProductModelResponder();
    }

    public function insertToDatabase($data)
    {
        $id = $data['product_id'];
        $name = $data['product_name'];
        $price = $data['product_price'];

        $conn = new mysqli("localhost", "root");
        $conn->query("INSERT INTO OnlineStore.products VALUES ('$id', '$name', $price)");
        $conn->close();
    }

    public function queryAll()
    {
        $conn = new mysqli("localhost", "root");

        $products_query = $conn->query("SELECT * FROM OnlineStore.products");
        $products = $products_query->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return $products;
    }

    public function querySearch($filter, $input)
    {
        $conn = new mysqli("localhost", "root");

        $products_query = $conn->query("SELECT * FROM OnlineStore.products WHERE $filter LIKE '%$input%'");
        $products = $products_query->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return $products;
    }

    public function query($prod_id)
    {
        $conn = new mysqli("localhost", "root");

        $product_query = $conn->query("SELECT * FROM OnlineStore.products WHERE id = '$prod_id'");
        $product = $product_query->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return $product;
    }

    public function handleData($data)
    {
        /** 
         * These bindings are not put at the constructor because I want
         * to make it clear about how the data is handled inside handleData function,
         * I dont want to move them elsewhere.
         * */
        $this->responder->bind('add', function ($data) {
            $this->insertToDatabase($data);

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=products");
        });
        $this->responder->bind('view', function ($data) {
            $products_data = $this->queryAll();

            session_start();
            $_SESSION['products_data'] = $products_data;
            $_SESSION['column_names'] = $this->column_names;

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=products");
        });
        $this->responder->bind('query', function ($data) {
            /** 
             * Note, this is functionality is implemented using AJAX 
             * */

            $column_map = array(
                "ID" => "id",
                "Name" => "product_name",
                "Price" => "price"
            );

            $searched_data = $this->querySearch($column_map[$data['filter']], $data['q']);

            // Print out JSON string
            // This text is sent back to the page who AJAX-ly requested it.
            // NOTE: send pure text, nothing more! <script> and such will not work once sent using AJAX

            // Construct JSON object
            $response = (object) [
                'head' => $this->column_names,
                'contents' => $searched_data
            ];

            echo json_encode($response);
            return;
        });
        $this->responder->bind('details', function ($data) {
            $product_data = $this->query($data['id']);

            $response = (object) [
                'column_names' => $this->column_names,
                'contents' => $product_data
            ];

            echo json_encode($response);
            return;
        });

        // Reponsder will not be able to bind new functions after first execution
        $this->responder->disableBinding();

        // Make respond
        $this->responder->response($data);
    }

    public function handleParams($params)
    {
        $this->responder->setRequestedMethod($params[0]);
    }
}

class ProductModelResponder
{
    private $requested_method;
    private $method_handlers;
    private $allow_binding;

    public function setRequestedMethod($method)
    {
        $this->requested_method = $method;
        $this->method_handlers = array();
        $this->allow_binding = true;
    }

    public function bind($method, $handler)
    {
        // Push a method - handler pair into the array
        if ($this->allow_binding == true) $this->method_handlers[$method] = $handler;
        else return;
    }

    public function disableBinding()
    {
        // Sometimes we disable binding for performance purposes
        $this->allow_binding = false;
    }

    public function response($data)
    {
        if (!isset($this->requested_method)) return;

        // Get and Execute the handler associated with requested method
        $handler = $this->method_handlers[$this->requested_method];
        $handler($data);
    }
}

$model = new ProductModel();
