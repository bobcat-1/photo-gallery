<?php
class Application_Model_DbTable_Photos extends Zend_Db_Table_Abstract
{
	protected $_name = 'photos';
	
	public function getPhotos($album_id) 
	{
		$album_id = (int)$album_id;
		$rows = $this->fetchAll('album_id = ' . $album_id);
		return $rows;
	}
	
	public function getPhoto($id) 
	{
		$id = (int)$id;
		$photo = $this->fetchRow('id = ' . $id);
		if (!$photo) {
			throw new Exception("Count not find row $id");
		}
		return $photo;
	}
	
	public function deletePhoto($id)
	{
		$this->delete('id =' . (int)$id);
	}
	
	public function addPhoto($album_id, $title, $address_photo, $filename)
	{
		$data = array(
			'album_id'      => $album_id,
			'title' => $title,
			'address_photo' => $address_photo,
			'filename' => $filename,
			'creation_date' => time()
		);
		$this->insert($data);
	}
	
	public function editPhoto($id, $title, $address_photo) {
		$data = array(
			'title' => $title,
			'address_photo' => $address_photo
		);
		$this->update($data, 'id = '. (int)$id);
	}
	
	public function getLastPhoto($album_id) {
		/*maxID = $this->fetchAll(
            $this->select()
                ->from($this, array(new Zend_Db_Expr('max(id) as maxId')))
        );*/
		$rows = $this->fetchAll('album_id = ' . $album_id);
		$max = 0;
		foreach ($rows as $row) {
			if ($row->id > $max) {
				$max = $row->id;
			}
		}
		$row = $this->fetchRow('id = ' . $max);
		return $row;
	}
}