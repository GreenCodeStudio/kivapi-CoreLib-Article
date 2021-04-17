<?php

namespace CoreLib\Article\Components\ArticlesList;

use Core\ComponentManager\ComponentController;
use Core\Routing\RouteHelper;
use CoreLib\Article\Repository\ArticleRepository;

class Controller extends ComponentController
{
    public function __construct($params)
    {
        $this->list = (new ArticleRepository())->getNews();
        $this->articleUrl=(new RouteHelper())->reverseRoute('CoreLib\Article', 'Article');
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