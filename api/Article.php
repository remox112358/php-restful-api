<?php

namespace api;

use core\helpers\Debug;

/**
 * Example API class for Article.
 */
class Article extends \core\API
{
    /**
     * API resource table name.
     *
     * @var string
     */
    private $tableName = 'articles';

    /**
     * @inheritDoc
     */
    public function index()
    {
        $sql      = "SELECT * FROM $this->tableName";
        $articles = $this->db->query($sql);

        $this->status(200);
        $this->output($articles);
    }

    /**
     * @inheritDoc
     */
    public function show()
    {
        $sql     = "SELECT * FROM $this->tableName WHERE id = :id LIMIT 1";
        $id      = (int) $this->params[0];
        $article = $this->db->query($sql, ['id' => $id])[0] ?? [];

        $this->status(200);
        $this->output($article);
    }

    /**
     * @inheritDoc
     */
    public function store()
    {
        $sql    = "INSERT INTO $this->tableName (title, excerpt, content, created_at) VALUES(:title, :excerpt, :content, :created_at)";
        $input  = $this->getRequestInput();
        $params = [
            'title'       => (string) $input['title'],
            'excerpt'     => (string) $input['excerpt'],
            'content'     => (string) $input['content'],
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $this->db->query($sql, $params);

        $this->status(201);
        $this->output();
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        $sql    = "UPDATE $this->tableName SET title = :title, excerpt = :excerpt, content = :content, updated_at = :updated_at WHERE id = :id";
        $input  = $this->getRequestInput();
        $params = [
            'id'         => $this->params[0],
            'title'      => isset($input['title']) ? (string) $input['title'] : null,
            'excerpt'    => isset($input['excerpt']) ? (string) $input['excerpt'] : null,
            'content'    => isset($input['content']) ? (string) $input['content'] : null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->query($sql, $params);

        $this->status(200);
        $this->output();
    }

    /**
     * @inheritDoc
     */
    public function destroy()
    {
        $sql    = "DELETE FROM $this->tableName WHERE id = :id";
        $input  = $this->getRequestInput();
        $params = [
            'id' => $this->params[0],
        ];

        $this->db->query($sql, $params);

        $this->status(200);
        $this->output();
    }
}