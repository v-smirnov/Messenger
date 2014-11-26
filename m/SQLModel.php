<?php

namespace VS\Models;

//
// простой CRUD - класс для MySQL
//
class SQLModel
{

	private static $instance;
    private $connection;

	public  static function instance($host_name, $user_name, $password, $db_name)
	{
		if (self::$instance == null)
			self::$instance = new SQLModel($host_name, $user_name, $password, $db_name);
		
		return self::$instance;
	}
	
	private function __construct($host_name, $user_name, $password, $db_name)
	{
        $this->connection = mysqli_connect($host_name, $user_name, $password, $db_name);
        if ($this->connection){
            mysqli_set_charset($this->connection, 'utf8');
        } else {
            die('Could not connect to DB');
        }
    }
	
	//
	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	//
    public function select($query)
	{
		$result = mysqli_query($this->connection, $query);
		
		if (!$result){
			die(mysqli_error($this->connection));
        }
		
		$n = mysqli_num_rows($result);
		$arr = array();
	
		for($i = 0; $i < $n; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			$arr[] = $row;
		}

		return $arr;				
	}
	
	//
	// Вставка строки
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// результат	- идентификатор новой строки
	//
    public function insert($table, $object)
	{			
		$columns = array(); 
		$values = array(); 
	
		foreach ($object as $key => $value) {
            $key = strip_tags($key);
			$key = mysqli_real_escape_string($this->connection, $key);
			$columns[] = $key;
			
			if ($value === null) {
				$values[] = 'NULL';
			} else {
                $value = strip_tags($value);
				$value = mysqli_real_escape_string($this->connection, $value);
				$values[] = "'$value'";
			}
		}

		$columns_s = implode(',', $columns); 
		$values_s = implode(',', $values);  
			
		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysqli_query($this->connection, $query);
								
		if (!$result){
			die(mysqli_error($this->connection));
        }

		return mysqli_insert_id($this->connection);
	}
	
	//
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	//	
    public function update($table, $object, $where)
	{
		$sets = array();
	
		foreach ($object as $key => $value)
		{
            $key = strip_tags($key);
			$key = mysqli_real_escape_string($this->connection, $key);
			
			if ($value === null)
			{
				$sets[] = "$value=NULL";			
			}
			else
			{
                $value = strip_tags($value);
				$value = mysqli_real_escape_string($this->connection, $value);
				$sets[] = "$key='$value'";			
			}			
		}

		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = mysqli_query($this->connection, $query);
		
		if (!$result){
			die(mysqli_error($this->connection));
        }
		return mysqli_affected_rows($this->connection);
	}
	
	//
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)	
	// результат	- число удаленных строк
	//		
    public function delete($table, $where)
	{
        $where = mysqli_real_escape_string($this->connection, $where);
		$query = "DELETE FROM $table WHERE $where";
		$result = mysqli_query($this->connection, $query);
						
		if (!$result){
			die(mysqli_error($this->connection));
        }

		return mysqli_affected_rows($this->connection);
	}

}
