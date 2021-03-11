<?php

namespace api;

use core\Validator;
use core\helpers\Debug;

/**
 * Articles API class.
 */
class Articles extends \core\API
{
    /**
     * API resource table name.
     *
     * @var string
     */
    public $tableName = 'articles';

    /**
     * @inheritDoc
     */
    public function index()
    {
        $articles = $this->db->query("SELECT * FROM $this->tableName");

        $this->status(200);
        $this->output($articles);
    }

    /**
     * @inheritDoc
     */
    public function show()
    {
        $id = (int) $this->params[0];

        $article = $this->db->query("SELECT * FROM $this->tableName WHERE id = :id LIMIT 1", ['id' => $id]);

        $this->status(200);
        $this->output($article[0] ?? []);
    }

    /**
     * @inheritDoc
     */
    public function store()
    {
        $input = $this->getRequestInput();
        $expected = ['title', 'excerpt', 'content'];

        // TODO: Rewrite validator call and functionality.
        if (Validator::check(['title', 'excerpt', 'content'], $input)) {
            $params = [
                'title'       => (string) $input['title'],
                'excerpt'     => (string) $input['excerpt'],
                'content'     => (string) $input['content'],
                'created_at'  => date('Y-m-d H:i:s'),
            ];
    
            $this->db->query("INSERT INTO $this->tableName (title, excerpt, content, created_at) VALUES(:title, :excerpt, :content, :created_at)", $params);
    
            $this->status(201);
            $this->output();
        }
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        $input = $this->getRequestInput();
        $params = [
            'id'         => $this->params[0],
            'title'      => isset($input['title']) ? (string) $input['title'] : null,
            'excerpt'    => isset($input['excerpt']) ? (string) $input['excerpt'] : null,
            'content'    => isset($input['content']) ? (string) $input['content'] : null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->query("UPDATE $this->tableName SET title = :title, excerpt = :excerpt, content = :content, updated_at = :updated_at WHERE id = :id", $params);

        $this->status(200);
        $this->output();
    }
}