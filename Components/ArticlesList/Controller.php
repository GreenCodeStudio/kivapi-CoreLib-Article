<?php

namespace CoreLib\Article\Components\ArticlesList;

use Core\ComponentManager\ComponentController;
use CoreLib\Article\Repository\ArticleRepository;

class Controller extends ComponentController
{
    public function __construct($params)
    {
        $this->list = (new ArticleRepository())->getNews();
    }

    public static function DefinedParameters()
    {
        return [
        ];
    }

    public function loadView()
    {
        include __DIR__.'/View.php';
    }
}