<?php namespace TamkeenLMSAPI\Requests\Programs;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests\Programs
	 */
	class SignUp extends Request{
		/**
		 * @param array $data
		 */
		public function __construct(array $data){
			parent::__construct('programs/signup', 'POST');

			// The form data to submit
			$this->setPostData($data);
		}

		/**
		 * Submit the request
		 * @return mixed
		 */
		public function submit(){
			return $this->send();
		}
	}
