<?php

class FormException extends Exception{
  private $formErrors;

  public function __construct($message = null, $code = 0, Exception $previous = null, $formErrors){
    $this->formErrors = $formErrors;
    parent::__construct($message, $code, $previous);
  }

  public function getFormErrors(){
    return $this->formErrors;
  }
}