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
    public function __construct($config)
    {
        $this->config = $config;
        $this->db = new Db($this->config('db'));
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
     * Get configs
     * @param string $search The configuration you want to get in dot notation
     * @return mixed The search config value if found else null
     */
    public function config($search)
    {
        $config = $this->config;
        $split = explode('.', $search);
        foreach($split as $s) {
            if(isset($config[$s])) {
                $config = $config[$s];
            } else {
                return null;
            }
        }
        return $config;
    }

    /**
     * Start to elaborate the request
     */
    public function run()
    {
        $this->request->checkMethod('GET');
        $this->request->handle();
    }
}
