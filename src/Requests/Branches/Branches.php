<?php namespace TamkeenLMSAPI\Requests\Branches;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests
	 */
	class Branches extends Request{
		/**
		 */
		public function __construct(){
			parent::__construct('branches');
		}

		/**
		 * @return mixed
		 */
		public function get(){
			return $this->send();
		}
	}
