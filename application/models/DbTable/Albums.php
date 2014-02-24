<?php
class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{
	protected $_name = 'albums';
	
	public function getAlbum($id) 
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		return $row->toArray();
	}
	
	public function addAlbum($name, $description, $photographer, $email, $phone)
	{
		$data = array(
			'name'      => $name,
			'description' => $description,
			'photographer' => $photographer,
			'email' => $email,
			'phone' => $phone,
			'creation_date' => time()
		);
		$this->insert($data);
	}
	
	public function updateAlbum($id, $name, $description, $photographer, $email, $phone)
	{
		$data = array(
			'name'      => $name,
			'description' => $description,
			'photographer' => $photographer,
			'email' => $email,
			'phone' => $phone,
			'modification_date' => time()
		);
		$this->update($data, 'id = '. (int)$id);
	}
	
	public function deleteAlbum($id)
	{
		$this->delete('id =' . (int)$id);
	}
}