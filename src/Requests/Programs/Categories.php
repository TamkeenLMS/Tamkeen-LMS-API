<?php namespace TamkeenLMSAPI\Requests\Programs;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests\Programs
	 */
	class Categories extends Request{
		/**
		 * @param null $branchId
		 */
		public function __construct($branchId){
			parent::__construct('programs/categories');

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
