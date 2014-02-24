<?php

class Application_Form_Album extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }

	public function __construct($options = null)
	{
		parent::__construct($options);
		$this->setName('album');
		$id = new Zend_Form_Element_Hidden('id');
		$id->addFilter('Int');

		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Название альбома*')->setRequired(true)->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty');

		$description = new Zend_Form_Element_Text('description');
		$description->setLabel('Описание*')->setRequired(true)->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty');
		
		$photographer = new Zend_Form_Element_Text('photographer');
		$photographer->setLabel('Фотограф*')->setRequired(true)->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty');
		
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Адрес эл.почты')->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty')
			->addValidator(new Zend_Validate_EmailAddress());
		
		
		require_once("TelephoneValidator.php");
		$telValidator = new Telephone_Validator();
		
		
		$phone = new Zend_Form_Element_Text('phone');
		$phone->addValidator($telValidator, true);
		$phone->setLabel('Телефон')->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');

		$this->addElements(array($id, $name, $description, $photographer, $email, $phone, $submit));
	}
}

