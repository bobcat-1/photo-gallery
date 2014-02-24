<?php

class Telephone_Validator extends Zend_Validate_Abstract
{
 const INVALID = 'This field is required';
 protected $_messageTemplates = array(
        self::INVALID => "Incorrect telephone number. Please, input the number in format +7 (xxx) xxx-xx-xx"
 );
 public function __construct()
 {
 }
 public function isValid($value) 
 {
  if(preg_match("/^(\+)7\s(\([0-9][0-9][0-9]\))\s([0-9][0-9][0-9])\-([0-9][0-9])\-([0-9][0-9])$/", trim($value))) 
  {
   return true;
  }  
  else
  {
   $this->_error(self::INVALID);
   return false;
  }
 }
}