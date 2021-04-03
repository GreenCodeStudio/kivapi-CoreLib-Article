<?php

namespace CoreLib\Article\Repository;

use Core\Database\DB;
use Core\Database\Repository;


class ArticleRepository extends Repository
{
    public function getCurrentVersion(int $articleId)
    {
        $version = DB::get("SELECT * FROM article a JOIN article_version v ON v.article_id = a.id AND v.is_active WHERE a.id = ? ORDER BY v.stamp DESC LIMIT 1", [$articleId])[0] ?? null;
        return $version;
    }

    public function getDataTable($options)
    {
        $start = (int)$options->start;
        $limit = (int)$options->limit;
        $sqlOrder = $this->getOrderSQL($options);
        $rows = DB::get("SELECT a.*, v.title FROM article a JOIN article_version v ON v.article_id = a.id AND v.is_active $sqlOrder LIMIT $start,$limit");
        $total = DB::get("SELECT count(*) as count FROM article")[0]->count;
        return ['rows' => $rows, 'total' => $total];
    }

    private function getOrderSQL($options)
    {
        if (empty($options->sort))
            return "";
        else {
            $mapping = [];
            if (empty($mapping[$options->sort->col]))
                throw new Exception();
            return ' ORDER BY '.DB::safeKey($mapping[$options->sort->col]).' '.($options->sort->desc ? 'DESC' : 'ASC').' ';
        }
    }

    public function getById(int $id)
    {
        return DB::get("SELECT *, a.id FROM article a JOIN article_version v ON v.article_id = a.id AND v.is_active WHERE a.id = ?", [$id])[0] ?? null;
    }

    public function defaultTable(): string
    {
        return 'article';
    }

    public function insertVersion(int $id, array $data)
    {
        $data['article_id'] = $id;
        return DB::insert('article_version', $data);
    }

    public function setCurrentVersion(int $id, int $versionId)
    {
        DB::query("UPDATE article_version SET is_active = (id = ?) WHERE article_id = ?", [$versionId, $id]);
    }
    public function getNews(){
        return DB::get("SELECT a.id, av.content, av.content_type, av.title, a.stamp
FROM article a
JOIN article_version av on a.id = av.article_id
WHERE av.is_active
ORDER BY a.stamp DESC
LIMIT 10");
    }
}