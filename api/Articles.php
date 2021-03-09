<?php

namespace api;

use helpers\Debug;

/**
 * Articles API class.
 */
class Articles extends \core\API
{
    const TABLE_NAME = 'articles';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $articles = $this->db->query("SELECT * FROM :table", ['table' => self::TABLE_NAME]);
        
        $this->output($articles);
    }
}