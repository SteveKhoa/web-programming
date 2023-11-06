<?php
include_once("commons.php");

class ProductModel extends Model
{
    private $mode;

    private $column_names;

    public function __construct()
    {
        $conn = new mysqli("localhost", "root");
        $information_schema =  $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'products'");
        $this->column_names = $information_schema->fetch_all(MYSQLI_NUM);
        $conn->close();
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

    public function queryFromDatabase()
    {
        $conn = new mysqli("localhost", "root");

        $products_query = $conn->query("SELECT * FROM OnlineStore.products");
        $products = $products_query->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return $products;
    }

    public function handleData($data)
    {
        if (isset($this->mode)) {
            if ($this->mode == 'add') {
                $this->insertToDatabase($data);

                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=products");
            } else if ($this->mode == 'view') {
                $products_data = $this->queryFromDatabase();

                session_start();
                $_SESSION['products_data'] = $products_data;
                $_SESSION['column_names'] = $this->column_names;

                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=products");
            }
        }
    }

    public function handleParams($params)
    {
        $this->mode = $params[0];
    }
}

$model = new ProductModel();
