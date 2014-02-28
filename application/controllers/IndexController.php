<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if(!Account::isAuthorizated()){
            $this->view->title = "Autorisation";
            $form = new Application_Form_Autorisation();
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {
                $formData = $this->_request->getPost();
                if ($form->isValid($formData)) {
                    $mapper = null;

                    $login = $formData['login'];
                    $password = $formData['password'];

                    $user = Account::authorize($login, $password);
                    if($user){
                        $this->_redirector->gotoUrl('/albums/index/id/' . $user->user_id);
                    }
                    $this->_redirector->gotoUrl('/');
                } else {
                    $form->populate($formData);
                }

            }
        }else{
            if(($this->_getParam('a')) == 'logout'){
                Account::logOut();
                $this->_redirector->gotoUrl('/');
                exit;
            }
            $this->_redirector->gotoUrl('/albums/index/id/' . $_SESSION['owner_id']);
        }
    }
}