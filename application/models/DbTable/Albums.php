<?php
class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{
    protected $_name = 'albums';
    protected $_owner_id;

    function __construct(){
        parent::__construct();
        $this->setOwnerId($_SESSION['owner_id']);
    }

	public function getAlbum($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow(array(
            'id = ' . $id,
            'owner_id = ' . $this->getOwnerId()
        ));
        if(!$row) return null;
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
			'creation_date' => time(),
            'owner_id' => $this->getOwnerId(),
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


    public function getAllAlbums($user_id){
        return $this->fetchAll('owner_id = ' . $user_id);
    }

    public function getOwnerId()
    {
        return $this->_owner_id;
    }


    public function setOwnerId($owner_id)
    {
        $this->_owner_id = $owner_id;
    }
}