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
    public function __construct(array $cfg)
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
        if($this->db) {
            $this->db->close();
            $this->db = null;
        }
    }
}
