<?php

namespace CoreLib\Article\Service;

use CoreLib\Article\Repository\ArticleRepository;


class ArticleService
{
    public function __construct()
    {
        $this->defaultDB = new ArticleRepository();
    }

    public function getDataTable($options)
    {
        return $this->defaultDB->getDataTable($options);
    }

    public function getById(int $id)
    {
        return $this->defaultDB->getById($id);
    }

    public function insert($data)
    {
        $id = $this->defaultDB->insert(['stamp'=>new \DateTime()]);
        $filtered = $this->filterData($data);
        $filtered['is_active'] = true;
        $this->defaultDB->insertVersion($id, $filtered);
        //\Core\WebSocket\Sender::sendToUsers(["Bank", "Balance", "Insert", $id]);
        //(new \Notifications\Notifications())->Push((object)['message' => 'Nowa transakcja na twoim koncie', 'id_user' => $data->id_user, 'expirationTime' => new \DateInterval('P1D')]);
    }

    protected function filterData($data)
    {
        $ret = [];
        $ret['title'] = $data->title;
        $ret['content'] = $data->content;
        $ret['content_type'] = $data->content_type;
        $ret['stamp'] = new \DateTime();
        return $ret;
    }

    public function update(int $id, $data)
    {
        $filtered = $this->filterData($data);
        $versionId = $this->defaultDB->insertVersion($id, $filtered);
        $this->defaultDB->setCurrentVersion($id, $versionId);
        //\Core\WebSocket\Sender::sendToUsers(["Bank", "Balance", "Update", $id]);
    }
}