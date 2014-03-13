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
        $login->removeDecorator('HtmlTag', 'tag')->removeDecorator('Label','tag');
        $login->addDecorator('HtmlTag', array('tag' => 'div'))->addDecorator('Label', array('tag' => 'div'));
        $login->setLabel('login')->setRequired(true)->addValidator('NotEmpty');

        $password = new Zend_Form_Element_Password('password');
        $password->removeDecorator('HtmlTag', 'tag')->removeDecorator('Label','tag');
        $password->addDecorator('HtmlTag', array('tag' => 'div'))->addDecorator('Label', array('tag' => 'div'));
        $password->setLabel('password')->setRequired(true)->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');

        $this->addElements(array($login, $password, $submit));
    }
}