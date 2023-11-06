<?php
include_once("commons.php");

class InsertProductModel extends Model
{
    public function handleData($data)
    {
        $id = $data['product_id'];
        $name = $data['product_name'];
        $price = $data['product_price'];

        $conn = new mysqli("localhost", "root");

        $conn->query("INSERT INTO OnlineStore.products VALUES ('$id', '$name', $price)");

        $conn->close();

        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . "index.php?page=products");
    }
}

$model = new InsertProductModel();