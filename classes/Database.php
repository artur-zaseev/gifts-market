<?php

  class Database
  {
    public $dbhost   = "localhost";
    public $db       = "";
    public $dblogin  = "";
    public $dbpass   = "";

    public $link;
    public $query;
    public $query_sql;
    public $result;
    public $data;
    public $fetch;

    public function __construct()
    {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $this->link = new mysqli($this->dbhost, $this->dblogin, $this->dbpass, $this->db);
    }

    public function getData($query)
    {
      $this->query = $query;
      $this->result = $this->link->query($query);
      if (!$this->result) echo "SELECT failed: (" . $this->link->errno . ") " . $this->link->error;
      while ($this->data = $this->result->fetch_assoc()) {
        $this->fetch[] = $this->data;
      }
      return $this->fetch;
    }

    public function setData($query_sql)
    {
      $this->query = $query_sql;
      $this->result = $this->link->query($this->query);
      if (!$this->result) echo "setData failed: (" . $this->link->errno . ") " . $this->link->error;
    }

    public function delData($tableName)
    {
      $this->query = $tableName;
      $this->result = $this->link->query("TRUNCATE TABLE $this->query");
      if (!$this->result) echo "DELETE failed: (" . $this->link->errno . ") " . $this->link->error;
    }

    public function close()
    {
      mysqli_close($this->link);
    }

    public function stop()
    {
      unset($this->query);
      unset($this->query_sql);
      unset($this->result);
      unset($this->data);
      unset($this->fetch);
    }
  }

  $db = new Database();
?>
