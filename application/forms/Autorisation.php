<?php

class Application_Form_Autorisation extends Zend_Form
{
    public function init()
    {

    }

    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('autorisation');

        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('login')->setRequired(true)->addValidator('NotEmpty');

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('password')->setRequired(true)->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');

        $this->addElements(array($login, $password, $submit));
    }
}