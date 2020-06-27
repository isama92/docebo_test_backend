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
        $this->handler->set_charset($cfg['charset']);
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
     * Query result to array of assoc array
     * @param $res
     * @return array
     */
    protected function resToArray($res)
    {
        $rows = [];

        while($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
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

    /**
     * Get the given node children
     * @param int $nodeId Parent node id
     * @param string $language Language
     * @param string $search Search keyword
     * @param int $pageNum Page number
     * @param int $pageSize Page size
     * @return array Children nodes
     */
    public function getChildrenNodesByNode($nodeId, $language, $search, $pageNum, $pageSize)
    {
        $pageOffset = $pageNum * $pageSize;

        // search sql parts, this will be empty if no search keywords was given
        $search_sql = '';
        if(!is_null($search) && $search !== '') {
            $search_sql = "AND ntn.nodeName like '%{$search}%'";
        }

        $sql = "
            SELECT
                nt.idNode as node_id,
                nt.level as node_level,
                ntn.nodeName as node_name
            FROM node_tree AS nt
            LEFT JOIN node_tree_names ntn on nt.idNode = ntn.idNode
            WHERE
                nt.iLeft > (
                    SELECT iLeft FROM node_tree AS nt2 WHERE nt2.idNode = {$nodeId}
                ) AND nt.iRight < (
                    SELECT iRight FROM node_tree AS nt2 WHERE nt2.idNode = {$nodeId}
                ) AND ntn.language = '{$language}'
                {$search_sql}
            LIMIT {$pageSize} OFFSET {$pageOffset}
        ";

        // get query results
        $q_res = $this->handler->query($sql);
        return $this->resToArray($q_res);
    }
}
