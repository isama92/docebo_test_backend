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
    public function checkMethod($method)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->error(405, 'method not allowed');
        }
    }

    /**
     * Get given params and validate them
     * @return array The request parameters
     */
    protected function getParams()
    {
        return [
            'nodeId' => isset($_GET['node_id']) ? $_GET['node_id'] : null,
            'language' => isset($_GET['language']) ? $_GET['language'] : null,
            'searchKeyword' => isset($_GET['search_keyword']) ? $_GET['search_keyword'] : null,
            'pageNum' => isset($_GET['page_num']) ? $_GET['page_num'] : 0,
            'pageSize' => isset($_GET['page_size']) ? $_GET['page_size'] : 100,
        ];
    }

    /**
     * Validate request parameters
     * @param array $params
     * @return array Array of errors that occurs
     */
    protected function validateParams($params)
    {
        $errors = [];

        if(!is_numeric($params['nodeId'])) {
            $errors[] = 'nodeId must be a number';
        }

        if($params['language'] !== 'english' && $params['language'] !== 'italian') {
            $errors[] = 'language must be either \'english\' or \'italian\'';
        }

        if(!is_numeric($params['pageNum']) || $params['pageNum'] < 0) {
            $errors[] = 'page_num must be a number';
        }

        if($params['pageSize'] < 0 || $params['pageSize'] > 1000) {
            $errors[] = 'page_size must be a number between 0 and 1000';
        }

        return $errors;
    }

    /**
     * Handle the request
     */
    public function handle()
    {
        $params = $this->getParams();
        $validateErrors = $this->validateParams($params);

        // if any errors occur during validation then output them and stop handling the request
        if(!empty($validateErrors)) {
            $this->output([], implode(', ', $validateErrors));
            return;
        }
    }

    /**
     * Print the output
     * @param array $data
     * @param string|null $error
     */
    protected function output($data, $error = null)
    {
        // result that will be echoed
        $res = [];

        // TODO: generalize the 'nodes' key
        $res['nodes'] = $data;

        // append errors to the result
        if(!empty($error)) {
            $res['error'] = $error;
        }

        // json output
        header('Content-Type: application/json');

        // output the data
        echo json_encode($res);
    }
}
