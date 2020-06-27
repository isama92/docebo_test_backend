<?php


class Request
{
    /**
     * @var Api $api
     */
    protected $api;

    /**
     * Request constructor
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * Print the error and exit
     * @param int $response_code
     * @param string|null $response_msg
     */
    public function error($response_code, $response_msg = null)
    {
        http_response_code($response_code);
        $msg = "error {$response_code}";
        if (!empty($msg)) {
            $msg .= ': ' . $response_msg;
        }
        echo $msg;
        exit;
    }

    /**
     * Check if request method is equals to the one given as param or exit after giving an 405 error
     * @param string $method
     */
    public function check_method($method)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->error(405, 'method not allowed');
        }
    }

    /**
     * Handle the request
     */
    public function handle()
    {
        // TODO
    }
}
