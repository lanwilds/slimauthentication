<?php 
namespace App\Validation;

use Respect\Validation\Validator as Respect;

use Respect\Validation\Exceptions\NestedValidationException;


class Validator
{

	protected $errors;
	protected $apperrors;
	
	public function validate($request, array $rules)
	{
		foreach ($rules as $field => $rule) {
			try {
				
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			
			} catch (NestedValidationException $e) {
				$this->errors[$field] = $e->getMessages();
			}
		}

		$_SESSION['errors'] = $this->errors;


		return $this;
	}

	public function failed()
	{
		return !empty($this->errors);
	}	


	public function Appvalidate($request, array $rules)
	{
		foreach ($rules as $field => $rule) {
			try {
				
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			
			} catch (NestedValidationException $e) {
				$this->apperrors[$field] = $e->getMessages();
			}
		}

		$_SESSION['apperrors'] = $this->apperrors;


		return $this;
	}

	public function Appfailed()
	{
		return !empty($this->apperrors);
	}	

	public function Pagevalidate($request, array $rules)
	{
		foreach ($rules as $field => $rule) {
			try {
				
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			
			} catch (NestedValidationException $e) {
				$this->pageerrors[$field] = $e->getMessages();
			}
		}

		$_SESSION['pageerrors'] = $this->pageerrors;


		return $this;
	}

	public function Pagefailed()
	{
		return !empty($this->pageerrors);
	}	

	/*public function Staffvalidate($request, array $rules)
	{
		foreach ($rules as $field => $rule) {
			try {
				
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			
			} catch (NestedValidationException $e) {
				$this->errors[$field] = $e->getMessages();
			}
		}

		$_SESSION['errors'] = $this->errors;


		return $this;
	}

	public function Stafffailed()
	{
		return !empty($this->errors);
	}	*/
}