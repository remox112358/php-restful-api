<?php

namespace api;

use helpers\Debug;

/**
 * Articles API class.
 */
class Articles extends \core\API
{
    /**
     * API table name.
     *
     * @var string
     */
    public $tableName = 'articles';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $articles = $this->db->query("SELECT * FROM $this->tableName");
        
        $this->output($articles);
    }
}