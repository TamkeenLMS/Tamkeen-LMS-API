<?php namespace TamkeenLMSAPI\Requests\Courses;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests\Courses
	 */
	class SignUp extends Request{
		/**
		 * @param array $data
		 */
		public function __construct(array $data){
			parent::__construct('courses/signup', 'POST');

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
