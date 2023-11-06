<?php
abstract class Model {
    abstract public function handleData($data);
    public function handleParams($params) {}
}