<?php

class PhotosController extends Zend_Controller_Action
{

    public function init()
    {
        $this->CheckAccess();
        $this->_redirector = $this->_helper->getHelper('Redirector');
		/* Initialize action controller here */
    }

    public function indexAction()
    {
        $album_id = $this->_getParam('album_id', 0);
		$albums = new Application_Model_DbTable_Albums();
		$album = $albums->fetchRow('id = ' . $album_id);
		$this->view->album_name = $album->name;
        $this->view->user_id = $album->owner_id;
		
		$this->view->title = $album->name;
		$this->view->headTitle($this->view->title);
		
		$photos = new Application_Model_DbTable_Photos();
		$this->view->photos = $photos->getPhotos($album_id);

		$path = $_SERVER['DOCUMENT_ROOT'].'/public/images/';
        foreach ($this->view->photos as $photo){
           Thumbnails::getThumbnail($path.'thumbnail_'.$photo->filename, $path.$photo->filename);
        }
		// action body
    }

    public function showAction()
    {
        $id = $this->_getParam('id', 0);
		$photos = new Application_Model_DbTable_Photos();
		$photo = $photos->getPhoto($id);
		$this->view->photo = $photo;
		// action body
    }

    public function deleteAction()
    {
        $photo_id	= $this->_getParam('id',0);
        Account::isPhotoOwner($photo_id);

        $this->view->title = "Delete this photo?";
		$this->view->headTitle($this->view->title);
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Да') {
				$id = $this->getRequest()->getPost('id');
				$photos = new Application_Model_DbTable_Photos();
				$photos->deletePhoto($id);
			}
			
			$album_id = $this->_getParam('album_id', 0);
			$this->_redirector->gotoUrl('/photos/index/album_id/'. $album_id);
			
		} else {
			$id = $this->_getParam('id', 0);
			$photos = new Application_Model_DbTable_Photos();
			$this->view->photo = $photos->getPhoto($id);
		}
		// action body
    }

    public function addAction()
    {
		$form = new Application_Form_Photo();

		$this->view->form = $form;
		$this->view->message='';
		
		$file = new Zend_Form_Element_File('file');
		$file->setLabel('Uploaded file*')
					->setRequired(true);
		$file->setDestination($_SERVER["DOCUMENT_ROOT"] . $this->view->baseUrl() . '/images');	
        
		
		//$file->addValidator('Count', false, 1);
		// limit to 21Mb
		$file->addValidator('Size', false, 21000000);
		// only JPEG, PNG, and GIFs
		$file->addValidator('Extension', false, 'jpg,png,gif');
		$form->addElement($file);
		
		$album_id = $this->_getParam('album_id', 0);
		//echo $album_id;
		
		if ($album_id != null) {
            Account::isAblumOwner($album_id);

			$albums = new Application_Model_DbTable_Albums();
			$album = $albums->fetchRow('id = ' . $album_id);
			$this->view->message = 'Photo will be place to album ' . $album->name;
			$h = new Zend_Form_Element_Hidden('album_id_form');
			$form->addElement($h);
			$form->album_id_form->setValue($album_id);
				
		} else {
			$albums = new Application_Model_DbTable_Albums();
			$this->view->albums = $albums->getAllAlbums($_SESSION['owner_id'])	;
			
			foreach ($this->view->albums as $album) {
				$options_array[$this->view->escape($album->id)] = $this->view->escape($album->name);
			}
					
			$form->addElement('select', 'album_id_form', array(
				'label'      => 'Choose the album to place photo:',
				'multiOptions'=> $options_array
				)
			);
			$album_id = $form->album_id;
		}

        $this->view->title = "Add new photo";
        $this->view->headTitle($this->view->title);

		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Send');
		$form->addElement($submit);
		
		if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
 
                // success - do something with the uploaded file
                $uploadedData = $form->getValues();
                $fullFilePath = $form->file->getFileName();
 
                /*Zend_Debug::dump($uploadedData, '$uploadedData');
                Zend_Debug::dump($fullFilePath, '$fullFilePath');
                echo "done";
                exit;*/
				
				$album_id = $uploadedData['album_id_form'];
				$title = $uploadedData['title'];
				$address_photo = $uploadedData['address_photo'];
				$filename = $uploadedData['file'];
			
				$photos = new Application_Model_DbTable_Photos();
				$photos->addPhoto($album_id, $title, $address_photo, $filename);
			
				$this->_redirector->gotoUrl('/photos/index/album_id/'. $album_id);

            } else {
				$form->populate($formData);
            }
        };
		// action body
    }

    public function editAction()
    {
        $photo_id	= $this->_getParam('id',0);
        Account::isPhotoOwner($photo_id);

        $this->view->title = "Edit description photo";
		$this->view->headTitle($this->view->title);
		
		$form = new Application_Form_Photo();
		$this->view->form = $form;
		
		$id	= $this->_getParam('id',0);
		$photos = new Application_Model_DbTable_Photos();
		$photo = $photos->getPhoto($id);	
		
		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('OK');
		$form->addElement($submit);
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
				$uploadedData = $form->getValues();
				$title = $uploadedData['title'];
				$address_photo = $uploadedData['address_photo'];
				
				$photos = new Application_Model_DbTable_Photos();
				$photos->editPhoto($id, $title, $address_photo);
				
				$album_id = $this->_getParam('album_id', 0);
				$this->_redirector->gotoUrl('/photos/index/album_id/'. $album_id);
			} else {
				$form->populate($formData);
			}
			
		} else {
			$form->populate(array('title' => $photo->title, 'address_photo' => $photo->address_photo));
		}
		// action body
    }

    public function CheckAccess()
    {
        Account::checkAccess();
    }
}









