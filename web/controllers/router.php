<?php
class Router
{
    private $page;

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function updatePage($page)
    {
        $this->page = $page;
    }

    public function loadLayout()
    {
        $router = $this; // For _layout to use
        include "views/_layout.php";
    }

    public function renderPage()
    {
        include "views/" . "pages/" . $this->page . "/" . $this->page . ".php";
    }
}
