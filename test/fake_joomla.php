<?php

class JFactory
{
    public static function getDBO()
    {
        return new FakeJoomlaDBO(new PDO(getenv('PDO_DSN'), getenv('PDO_USER'), getenv('PDO_PASS')));
    }
}

class FakeJoomlaDBO
{
    /**
     * @var string
     */
    private $fields;

    /**
     * @var string
     */
    private $table;

    /**
     * @var mixed
     */
    private $where;

    /**
     * @var string
     */
    private $glue;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getQuery($unused)
    {
        return $this;
    }

    /**
     * @param $table
     * @return FakeJoomlaDBO
     */
    public function from($table)
    {
        $this->table = str_replace('#_', 'j25', $table);
        return $this;
    }

    /**
     * @param $fields
     * @return FakeJoomlaDBO
     */
    public function select($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param mixed $predicates
     * @param string $glue
     */
    public function where($predicates, $glue = "AND")
    {
        $this->where = $predicates;
        $this->glue = $glue;
        return $this;
    }

    /**
     * @param FakeJoomlaDBO $unused
     * @return FakeJoomlaDBO
     */
    public function setQuery(FakeJoomlaDBO $unused)
    {
        return $this;
    }

    public function loadObject($className = 'stdClass')
    {
        return $this->load()->fetchObject($className);
    }

    public function loadObjectList($indexField = '', $className = 'stdClass')
    {
        return $this->reIndex($indexField, $this->load()->fetchAll(PDO::FETCH_CLASS, $className));
    }

    /**
     * @return PDOStatement
     * @throws Exception
     */
    private function load()
    {
        $sql = "SELECT {$this->fields} FROM {$this->table} WHERE " . implode(" {$this->glue} ", $this->where);
        $stmt = $this->pdo->query($sql, PDO::FETCH_OBJ);
        if (!$stmt) {
            throw new Exception($this->pdo->errorInfo()[2]);
        }
        return $stmt;
    }

    private function reIndex($indexField, $resultSet)
    {
        if (!$indexField) {
            return $resultSet;
        }

        $result = [];
        foreach ($resultSet as $item) {
            $result[$item->$indexField] = $item;
        }
        return $result;
    }
}
