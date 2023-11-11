<?php

namespace Core\Controllers;

use App\Lib\Flash;
use Core\Http\Request;

abstract class  BaseController
{
    protected $layout = 'application';
    protected $params = [];
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setParams($request->getParams());
    }
    public function render($view, $data = [])
    {
        extract($data);
        $_SESSION['lest_page'] = $this->request->getPath();
        $flash = Flash::message();
        $view = ROOT_PATH . '/app/views/' . $view .  '.phtml';
        require ROOT_PATH . '/app/views/layouts/' . $this->layout .  '.phtml';
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    protected function redirectTo(string $address)
    {
        header('location: ' . $address);
        exit();
    }
}
