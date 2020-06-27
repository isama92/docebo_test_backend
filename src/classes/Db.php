<?php


class Db
{
    /**
     * @var mysqli $db Database connection
     */
    public $db = null;

    /**
     * Db constructor, connect to the database
     * @param array $cfg
     */
    public function __construct($cfg)
    {
        $this->db = new mysqli(
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
        if ($this->db) {
            $this->db->close();
            $this->db = null;
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
        $q_res = $this->db->query("SELECT idNode FROM node_tree WHERE idNode = {$nodeId}");

        // return true if there is at least 1 result
        return $q_res->num_rows > 0;
    }
}
