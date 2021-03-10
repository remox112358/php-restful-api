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
     * @param integer $code - HTTP response code.
     * @return void
     */
    protected function status(int $code)
    {
        switch ($code) {
            case 200:
                \header("HTTP/1.1 200 OK");
                break;
            case 201:
                \header("HTTP/1.1 201 Created");
                break;
            case 404:
                \header("HTTP/1.1 404 Not Found");
                break;
            case 422:
                \header("HTTP/1.1 422 Unprocessable Entity");
                break;
        }
    }

    /**
     * Returns decoded request input.
     *
     * @return array
     */
    protected function getRequestInput() : array
    {
        return (array) \json_decode(\file_get_contents('php://input', true));
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