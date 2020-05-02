<?php
/**
 * Class FormException
 * Exception raised when a form was wrong. Ex : when adding a web site as an admin
 * His specific feature is to store the errors, so the controller can get them
 */
class FormException extends Exception{
  private $formErrors;

  public function __construct($message = null, $code = 0, Exception $previous = null, $formErrors){
    $this->formErrors = $formErrors;
    parent::__construct($message, $code, $previous);
  }

	/** 
	 * Get the errors of this exception
	 * @return array[string]
	*/ 
  public function getFormErrors(){
    return $this->formErrors;
  }
}