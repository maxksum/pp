<?php

class DBClass
{
    private $db_address = "";
    private $db_name = "";
    private $db_user = "";
    private $db_password = "";
    private $db;


    public function __construct($address, $name, $user, $password) {
        $this->db_address = $address;
        $this->db_name = $name;
        $this->db_user = $user;
        $this->db_password = $password;
        $this->db = new mysqli($this->db_address,$this->db_user,$this->db_password,$this->db_name);
    }

    public function checkConnection() {
        if ($this->db->connect_errno)
        {
            return false;
        } else {
            return true;
        }
    }

    public function getLastError() {
        return "Mysqli Error: " . $this->db->connect_error();
    }

    public function getTables() {
        $result = $this->db->query("SHOW tables");
        $tables = array();
        while ($table = $result->fetch_assoc()) {
            $tables[] = $table["Tables_in_" . $this->db_name];
        }
		
        return $tables;
    }
	
	public function getTableColumns($table) {
		$result = $this->db->query("DESCRIBE " . $table);
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row["Field"];
        }
		
        return $rows;
	}
	
	public function deleteRow($table, $conditions = null) {
		$temp = array();
		foreach ($conditions as $key=>$condition) {
			$temp[] = "`" . $key . "`='" . $condition . "'";
		}
		$query = "DELETE FROM " . $table . " WHERE " . implode(', ', $temp);
		//die($query);
		if (!$this->db->query($query)) {
			die($this->db->error);
		}
	}
	
	public function insertTableData($table, $data) {
		$query = "INSERT INTO " . $table;
		$columns = array();
		$values = array();
		foreach ($data as $key=>$value) {
			$columns[] = $key;
			$values[] = "'" . $value . "'";
		}
		
		$query .= "(" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
		if (!$this->db->query($query)) {
			die($this->db->error);
		}
		return;
	}
	
	public function editRow($table, $row_id, $fields) {
		$columns = $this->getTableColumns($table);
		$search_column = $columns[0];
		
		$values = array();
		foreach ($fields as $key=>$field) {
			$values[] = "`" . $key . "`='" . $field . "'";
		}
		
		$query = "UPDATE " . $table . " SET " . implode(',', $values) . " WHERE `" . $search_column . "`='" . $row_id . "'";  
		$this->db->query($query);
		return;
	}

    public function getTableData($table, $condition = null ,$order_by = null, $limit = null) {
		
		if (!empty($condition)) {
			$conditions = array();
			foreach ($condition as $key=>$value) {
				$conditions[] = "`" . $key . "`='" . $value . "'";
			}
			$condition = " WHERE " . implode(',', $conditions);
		}
			
		
		if (!empty($order_by)) {
			$order = " Order by `" . $order_by['column'] . "` " . $order_by['type'];
		} else {
			$order = "";
		}
		
		if (!empty($limit)) {
			$limit = " LIMIT " . $limit;
		}
	
        $result = $this->db->query("SELECT * FROM " . $table . $condition . $order . $limit);
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

}