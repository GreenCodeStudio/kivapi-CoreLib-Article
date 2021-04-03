<?php
namespace CoreLib\Article\Panel\Ajax;

use Core\Panel\Infrastructure\PanelAjaxController;
use CoreLib\Article\Service\ArticleService;

class ArticleAjaxController extends PanelAjaxController
{
    public function getTable($options)
    {
        $this->will('Article', 'show');
        $service = new ArticleService();
        return $service->getDataTable($options);
    }

    public function update($data)
    {
        $this->will('Article', 'edit');
        $service = new ArticleService();
        $service->update($data->id, $data);
    }

    public function insert($data)
    {
        $this->will('Article', 'add');
        $service = new ArticleService();
        $id = $service->insert($data);
    }
}