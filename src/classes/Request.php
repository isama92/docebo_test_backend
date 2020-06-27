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
     * Print the output
     * @param array $data
     */
    protected function output($data)
    {
        // json output
        header('Content-Type: application/json');

        // output the data
        echo json_encode($data);
    }

    /**
     * Print the error and exit
     * @param int $response_code Http error code
     * @param string|null $msg Error message
     */
    public function httpError($response_code, $msg = null)
    {
        http_response_code($response_code);
        $output = "error {$response_code}";
        if (!empty($output)) {
            $output .= ': ' . $msg;
        }
        echo $output;
        exit;
    }

    /**
     * Print the error in json format
     * @param string $msg Error message
     */
    public function jsonError($msg)
    {
        $this->output([
            'nodes' => [],
            'error' => $msg,
        ]);
    }

    /**
     * Check if request method is equals to the one given as param or exit after giving an 405 error
     * @param string $method
     */
    public function checkMethod($method)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->httpError(405, 'method not allowed');
        }
    }

    /**
     * Get given params and validate them
     * @return array The request parameters
     */
    protected function getParams()
    {
        // get the params from $_GET
        $params = [
            'nodeId' => isset($_GET['node_id']) && is_numeric($_GET['node_id']) ? $_GET['node_id'] : null,
            'language' => isset($_GET['language']) ? $_GET['language'] : null,
            'searchKeyword' => isset($_GET['search_keyword']) ? $_GET['search_keyword'] : null,
            'pageNum' => isset($_GET['page_num']) ? $_GET['page_num'] : null,
            'pageSize' => isset($_GET['page_size']) ? $_GET['page_size'] : null,
        ];

        // default page_num value (will overwrite any non numeric value)
        if (!is_numeric($params['pageNum'])) {
            $params['pageNum'] = $this->api->config('api.default_page_num');
        }

        // default page_size value (will overwrite any non numeric value)
        if (!is_numeric($params['pageSize'])) {
            $params['pageSize'] = $this->api->config('api.default_page_size');
        }

        // convert params
        $params['nodeId'] = intval($params['nodeId']);
        $params['pageNum'] = intval($params['pageNum']);
        $params['pageSize'] = intval($params['pageSize']);

        return $params;
    }

    /**
     * Validate request parameters
     * @param array $params Params to check
     * @return string|null The error that occurred
     */
    protected function validateParams($params)
    {
        if (is_null($params['nodeId'])) {
            return 'Missing mandatory params';
        }

        if (!$this->api->db()->nodeIdExists($params['nodeId'])) {
            return 'Invalid node id';
        }

        if ($params['language'] !== 'english' && $params['language'] !== 'italian') {
            return 'Missing mandatory params';
        }

        if ($params['pageNum'] < 0) {
            return 'Invalid page number requested';
        }

        if ($params['pageSize'] < 0 || $params['pageSize'] > 1000) {
            return 'Invalid page size requested';
        }

        return null;
    }

    /**
     * Handle the request
     */
    public function handle()
    {
        $params = $this->getParams();
        $validateError = $this->validateParams($params);

        // if a validation error occurred then output it and stop handling the request
        if (!empty($validateError)) {
            $this->jsonError($validateError);
            return;
        }

        $nodes = $this->api->db()->getChildrenNodesByNode(
            $params['nodeId'],
            $params['language'],
            $params['searchKeyword'],
            $params['pageNum'],
            $params['pageSize']
        );

        $output_data = ['nodes' => $nodes];
        
        $this->output($output_data);
    }
}
