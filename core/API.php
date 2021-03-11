<?php

namespace core;

use core\lib\DB;

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
     * Current route request params.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Available HTTP statuses.
     *
     * @var array
     */
    protected $statuses = [];

    /**
     * API class constructor.
     * 
     * @param  array $params - Request params.
     * @return void
     */
    public function __construct(array $params)
    {
        $this->db       = new DB;
        $this->params   = $params;
        $this->statuses = require_once 'core/config/statuses.php';

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    /**
     * Outputs dismitted array in any format.
     *
     * @param  array  $array  - Dismitted array that needs to output.
     * @param  string $format - Format of output.
     * @return void
     */
    protected function output(array $array = [], string $format = 'json')
    {
        switch ($format) {
            case 'json':
                header('Content-type: application/json; charset=UTF-8');
                print \json_encode($array);
                break;
        }
    }

    /**
     * Declares HTTP response.
     *
     * @param  integer $code - HTTP response code.
     * @return void
     */
    protected function status(int $code)
    {
        if ($this->statuses[$code]) {
            \header("HTTP/1.1 " . $code . " " . $this->statuses[$code]);
        } else {
            \header("HTTP/1.1 " . 500 . " " . $this->statuses[500]);
        }
    }

    /**
     * Returns decoded request input.
     *
     * @return array
     */
    protected function getRequestInput() : array
    {
        return (array) \json_decode(\file_get_contents('php://input', true), JSON_FORCE_OBJECT);
    }

    /**
     * Display a listing of the API resource.
     *
     * @return void
     */
    public function index()
    {
        
    }

    /**
     * Display the specified API resource.
     *
     * @return void
     */
    public function show()
    {

    }

    /**
     * Store a newly created API resource in storage.
     *
     * @return void
     */
    public function store()
    {

    }

    /**
     * Update the specified API resource in storage.
     *
     * @return void
     */
    public function update()
    {

    }

    /**
     * Remove the specified API resource from storage.
     *
     * @return void
     */
    public function destroy()
    {

    }
}