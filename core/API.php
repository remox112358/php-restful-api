<?php

namespace core;

use core\DB;

/**
 * API functionality class.
 */
abstract class API
{
    /**
     * Database object.
     *
     * @var object
     */
    protected $db;

    /**
     * API class constructor.
     */
    public function __construct()
    {
        $this->db = new DB;
    }

    /**
     * Outputs dismitted array in any format.
     *
     * @param  array  $array  - Dismitted array that needs to output.
     * @param  string $format - Format of output.
     * @return void
     */
    protected function output(array $array, string $format = 'json')
    {
        switch ($format) {
            case 'json':
                header('Content-type: application/json');
                print json_encode($array);
                break;
        }
    }

    /**
     * Executes API script.
     *
     * @return void
     */
    protected function execute()
    {

    }
}