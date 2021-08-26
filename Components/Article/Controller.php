<?php

namespace CoreLib\Article\Components\Article;

use Core\ComponentManager\ComponentController;
use CoreLib\Article\Repository\ArticleRepository;

class Controller extends ComponentController
{
    public function __construct($params)
    {
        $this->id = $params->id;
        $this->version = (new ArticleRepository())->getCurrentVersion($params->id);
    }

    public static function DefinedParameters()
    {
        return [
            'id' => (object)['Title' => 'Id', 'type' => 'int', 'canFromQuery' => true]
        ];
    }

    public function loadView()
    {
        include __DIR__ . '/View.php';
    }

    protected function getContentHtml()
    {
        if ($this->version->content_type == 'text/plain')
            return '<p>' . str_replace('\r\n', '<br>', str_replace('\r\n\r\n', '</p><p>', htmlspecialchars($this->version->content))) . '</p>';
        else if ($this->version->content_type == 'text/pmeditor')
            return $this->version->content;//todo tmp
        else if ($this->version->content_type == 'text/html')
            return $this->version->content;
        else
            throw new \Exception("Not recognized format");
    }
}