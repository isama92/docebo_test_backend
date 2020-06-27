<?php


class Api
{
    /**
     * @var array $config App configurations
     */
    protected $config;

    /**
     * @var Db $db Database connection
     */
    protected $db = null;

    /**
     * Api constructor.
     * @param array $config App configurations
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->db = new Db($config['db']);
    }


    /**
     * Print the error and exit
     * @param int $response_code
     * @param string|null $response_msg
     */
    protected function error($response_code, $response_msg = null)
    {
        http_response_code($response_code);
        $msg = "error {$response_code}";
        if(!empty($msg)) {
            $msg .= ': ' . $response_msg;
        }
        echo $msg;
        exit;
    }

    /**
     * Dump a variable, testing purpose
     * @param $v
     */
    protected function dump($v)
    {
        echo '<pre>';
        var_dump($v);
        echo '</pre>';
    }

    /**
     * Start to elaborate the request
     */
    public function run()
    {
        $this->check_request_method('GET');
    }

    /**
     * Check if request method is equals to the one given as param or exit after giving an 405 error
     * @param string $method
     */
    protected function check_request_method($method)
    {
        if($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->error(405, 'method not allowed');
        }
    }
}
