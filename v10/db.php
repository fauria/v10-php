<?php

class Db
{
	var $conn;
	var $db;
	var $collection;
	var $grid;
	
	public function __construct($collection = default_collection, $database = default_database)
	{
		try 
		{
			$this->conn = new Mongo(mongodb_host);
			$this->db = $this->conn->$database;
			$this->collection = $this->db->$collection;
	  		$this->grid = $this->db->getGridFS();
		}
		catch (MongoConnectionException $e)
		{
			trigger_error("Can not connect to MongoDB on host ".mongodb_host, E_USER_ERROR);
		}
		catch (MongoException $e)
		{
			trigger_error("MongoDB error: $e->getMessage()", E_USER_ERROR);
		}
	}

	public function timeToId($ts)
	{
	    $hexTs = dechex($ts);
	    $hexTs = str_pad($hexTs, 8, "0", STR_PAD_LEFT);
	    return new MongoId($hexTs."0000000000000000");
	}
	
	public function all($sort = array()) 
	{
		return $this->get_all($sort);
	}

	public function get_all($sort = array()) 
	{
		if(array_mode)
		{
			return iterator_to_array($this->collection->find()->sort($sort));
		}
		else
		{
			return $this->collection->find()->sort($sort);
		}
	
	}
	
	public function get_one($id)
	{
		if(gettype($id) != 'object')
		{
			$id = new MongoId($id);
		}
		return $this->collection->findOne(array('_id' => $id));
	}

	public function max_attr($attr)
	{
		$item = $this->collection->find()->sort(array($attr => -1))->limit(1);		
		if(count($item) > 0)
		{
			$temp = iterator_to_array($item);
			$values = array_pop($temp);
			return $values[$attr];
		}
		else
		{
			return FALSE;
		}
	}

	public function get_last($sort = array('_id' => -1))
	{
		$item = $this->collection->find()->sort($sort)->limit(1);
		if(count($item) > 0)
		{
			$temp = iterator_to_array($item);
			$values = array_pop($temp);
			return $values;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_item($criteria = array())
	{
		$item = $this->collection->findOne($criteria);
		if(count($item) > 0)
		{
			return $item;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_items($criteria = array(), $limit = false, $skip = 0, $sort = array('_id' => -1))
	{				
		$cursor = $this->collection->find($criteria)->skip($skip)->limit($limit);
		$cursor->sort($sort);
		if(array_mode)
		{
			return iterator_to_array($cursor);
		}
		else
		{
			return $cursor;
		}
	}
	
	public function get_count($criteria = array())
	{
		$cursor = $this->collection->find($criteria);
		return $cursor->count();
	}
	
	/*
	public function run_query($criteria = array(), $skip = 0, $limit = false)
	{
		$cursor = $this->collection->find($criteria)->skip($skip)->limit($limit);
		$cursor->sort(array('_id' => 1));
		if(array_mode)
		{
			return iterator_to_array($cursor);
		}
		else
		{
			return $cursor;
		}
	}
	*/
	
	public function get_binary($id)
	{
		if(gettype($id) != 'object')
		{
			$id = new MongoId($id);
		}
		$finfo = new finfo;
		if(@$data = $this->grid->findOne(array("_id" => $id))->getBytes())
		{
			$fileinfo = $finfo->buffer($data, FILEINFO_MIME);
			return array('data' => $data, 'metadata' => array('mime_type' => $fileinfo));
		}
		else
		{
			return FALSE;			
		}
	}
	
	public function get_attribute($attr, $id)
	{
		if(gettype($id) != 'object')
		{
			$id = new MongoId($id);
		}
		$data = $this->collection->find(array("_id" => $id))->getNext();
		if(isset($data[$attr]))
		{
			return $data[$attr];
		}
		else
		{
			return FALSE;
		}		
	}
	
	public function add($item)
	{
		if(count($item) > 0)
		{		
			$this->collection->insert($item);	
			return $item['_id'];
		}
		else
		{
			return FALSE;
		}		
	}
	
	public function update($id, $data)
	{
		$updates = array('$set' => $data);
		if(gettype($id) == 'object')
		{
			return $this->collection->update(array("_id" => $id), $updates);	
		}
		else
		{
			return $this->collection->update(array("_id" => new MongoId($id)), $updates);	
		}
	}

	public function clear()
	{		
		return $this->collection->remove(array(), array('w' => 1));
	}
	
	public function delete($id)
	{
		if(gettype($id) == 'object')
		{
			return $this->collection->remove(array("_id" => $id),  array('safe' => true));	
		}
		else
		{
			return $this->collection->remove(array("_id" => new MongoId($id)), array('safe' => true));
		}
		
	}
	
	public function upload_file($file, $metadata = array('metadata' => array()))
	{
		return $this->grid->storeFile($file, $metadata);
	}

	public function __destruct()
	{
		$this->conn->close();
	}
}

?>