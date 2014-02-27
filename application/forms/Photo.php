<?php

class Application_Form_Photo extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
	
	public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setMethod('post'); 
		$this->setName('upload');
        $this->setAttrib('enctype', 'multipart/form-data');
 
        
		
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title photo*')
					->setRequired(true)
					->addValidator('NotEmpty');
					
		$address_photo = new Zend_Form_Element_Text('address_photo');
		$address_photo->setLabel('Place')
					->addValidator('NotEmpty');
		
        
		
		$this->addElements(array($title, $address_photo));
 
    }

}

