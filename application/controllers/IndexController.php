<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "My Albums";
		$this->view->headTitle($this->view->title);
		$albums = new Application_Model_DbTable_Albums();
		$this->view->albums = $albums->fetchAll();
		
		$this->view->photos = new Application_Model_DbTable_Photos();

		// action body
    }

    public function addAction()
    {
        $this->view->title = "Add new album";
		$this->view->headTitle($this->view->title);
		$form = new Application_Form_Album();
		$form->submit->setLabel('Добавить');
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

}











