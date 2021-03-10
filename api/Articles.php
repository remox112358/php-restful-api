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

        Debug::show($id);
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
                'title'   => (string) $input['title'],
                'excerpt' => (string) $input['excerpt'],
                'content' => (string) $input['content'],
            ];
    
            $this->db->query("INSERT INTO $this->tableName (title, excerpt, content) VALUES(:title, :excerpt, :content)", $params);
    
            $this->status(201);
            $this->output();
        }
    }
}