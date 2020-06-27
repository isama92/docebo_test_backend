<?php


class Db
{
    /**
     * @var mysqli $handler Database connection
     */
    public $handler = null;

    /**
     * Db constructor, connect to the database
     * @param array $cfg
     */
    public function __construct($cfg)
    {
        $this->handler = new mysqli(
            $cfg['hostname'],
            $cfg['username'],
            $cfg['password'],
            $cfg['database']
        );
    }

    /**
     * Db destructor, close the database
     */
    public function __destruct()
    {
        if ($this->handler) {
            $this->handler->close();
            $this->handler = null;
        }
    }

    /**
     * Check if nodeId exists in the node_tree table
     * @param $nodeId
     * @return bool
     */
    public function nodeIdExists($nodeId)
    {
        // query the database to get the number of rows having idNode equals to the param
        $q_res = $this->handler->query("SELECT idNode FROM node_tree WHERE idNode = {$nodeId}");

        // return true if there is at least 1 result
        return $q_res->num_rows > 0;
    }
}
