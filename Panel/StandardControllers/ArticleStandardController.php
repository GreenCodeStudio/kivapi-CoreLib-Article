<?php

namespace CoreLib\Article\Panel\StandardControllers;

use Authorization\Permissions;
use Core\ComponentManager\Page;
use Core\Exceptions\NotFoundException;
use Core\Panel\Infrastructure\PanelStandardController;
use CoreLib\Article\Service\ArticleService;

class ArticleStandardController extends PanelStandardController
{

    function index()
    {
        $this->will('Article', 'show');
        $this->addView('CoreLib/Article', 'ArticleList');
        $this->pushBreadcrumb(['title' => 'Article', 'url' => 'Article']);

    }

    function edit(int $id)
    {
        $this->will('Article', 'edit');
        $this->addView('CoreLib/Article', 'ArticleEdit', ['type' => 'edit']);
        $this->pushBreadcrumb(['title' => 'Article', 'url' => 'Article']);
        $this->pushBreadcrumb(['title' => 'Edycja', 'url' => 'Article/edit/'.$id]);
    }

    function edit_data(int $id)
    {
        $this->will('Article', 'edit');
        $service = new ArticleService();
        $data = $service->getById($id);
        if ($data == null)
            throw new NotFoundException();
        return ['Article' => $data];
    }

    /**
     * @OfflineConstant
     */
    function add()
    {
        $this->will('Article', 'add');
        $this->addView('CoreLib/Article', 'ArticleEdit', ['type' => 'add']);
        $this->pushBreadcrumb(['title' => 'Article', 'url' => '/panel/article']);
        $this->pushBreadcrumb(['title' => 'Dodaj', 'url' => '/panel/article/add']);
    }

}
