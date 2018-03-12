<?php namespace TamkeenLMSAPI\Requests\Courses;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests\Courses
	 */
	class Categories extends Request{
		/**
		 * @param null $branchId
		 */
		public function __construct($branchId){
			parent::__construct('courses/categories');

			// Set the branch of the request
			$this->setBranch($branchId);
		}

		/**
		 * @return mixed
		 */
		public function get(){
			return $this->send();
		}
	}
