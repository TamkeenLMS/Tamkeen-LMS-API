<?php namespace TamkeenLMSAPI\Requests\Branches;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests
	 */
	class Branch extends Request{
		/**
		 * @param $branchId
		 */
		public function __construct($branchId){
			parent::__construct("branches/{$branchId}");
		}

		/**
		 * @return mixed
		 */
		public function get(){
			return $this->send();
		}
	}
