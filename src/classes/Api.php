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
     * @var Request $request Http request
     */
    protected $request = null;

    /**
     * Api constructor.
     * @param array $config App configurations
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->db = new Db($config['db']);
        $this->request = new Request($this);
    }

    /**
     * Get db
     * @return Db
     */
    public function db()
    {
        return $this->db;
    }

    /**
     * Start to elaborate the request
     */
    public function run()
    {

        $this->request->check_method('GET');
        $this->request->handle();
    }
}
