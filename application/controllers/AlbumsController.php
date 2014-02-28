<?php

class AlbumsController extends Zend_Controller_Action
{
    protected $_user_id;

    public function init()
    {
        $this->CheckAccess();
        $user_id = $this->_getParam('id', $_SESSION['owner_id']);
        if(isset($user_id)){
            $this->setUserId($user_id);
            $this->view->user_id = $this->getUserId();
        }else{
            throw new Exception('Page not found', 404);
        }
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if($this->getUserId() == $_SESSION['owner_id']) {
            $this->view->title = "My Albums";
        }else{
            $users = new Application_Model_DbTable_Users();
            $user = $users->getUserById($this->getUserId());
            $this->view->title = "Albums of " . $user->login;
        }
		$this->view->headTitle($this->view->title);
		$albums = new Application_Model_DbTable_Albums();
		$this->view->albums = $albums->getAllAlbums($this->getUserId());
		
		$this->view->photos = new Application_Model_DbTable_Photos();

		// action body
    }

    public function addAction()
    {
        $this->view->title = "Add new album";
		$this->view->headTitle($this->view->title);
		$form = new Application_Form_Album();
		$form->submit->setLabel('Add');
		$this->view->form = $form;

		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$name = $form->getValue('name');
				$description = $form->getValue('description');
				$photographer = $form->getValue('photographer');
				$email = $form->getValue('email');
				$phone = $form->getValue('phone');
				
				$albums = new Application_Model_DbTable_Albums();
				$albums->addAlbum($name, $description, $photographer, $email, $phone);

				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		}
		// action body
    }

    public function editAction()
    {
        $album_id = $this->_getParam('id', 0);
        Account::isAblumOwner($album_id);

        $this->view->title = "Edit album";
		$this->view->headTitle($this->view->title);
		$form = new Application_Form_Album();
		$form->submit->setLabel('Save');
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$id = (int)$form->getValue('id');
				$name = $form->getValue('name');
				$description = $form->getValue('description');
				$photographer = $form->getValue('photographer');
				$email = $form->getValue('email');
				$phone = $form->getValue('phone');
				
				$albums = new Application_Model_DbTable_Albums();
				$albums->updateAlbum($id, $name, $description, $photographer, $email, $phone);

				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$albums = new Application_Model_DbTable_Albums();
				$form->populate($albums->getAlbum($id));
			}
		}
		
		// action body
    }

    public function deleteAction()
    {
        $album_id = $this->_getParam('id', 0);
        Account::isAblumOwner($album_id);

        $this->view->title = "Delete album";
		$this->view->headTitle($this->view->title);
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Да') {
				$id = $this->getRequest()->getPost('id');
				$albums = new Application_Model_DbTable_Albums();
				$albums->deleteAlbum($id);
			}
			$this->_helper->redirector('index');
		} else {
			$id = $this->_getParam('id', 0);
			$albums = new Application_Model_DbTable_Albums();
			$this->view->album = $albums->getAlbum($id);
		}
		// action body
    }

    public function CheckAccess()
    {
        Account::checkAccess();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }
}











