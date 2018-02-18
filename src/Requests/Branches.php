<?php namespace TamkeenLMSAPI\Requests;

	use TamkeenLMSAPI\Request;

	/**
	 * @package TamkeenLMSAPI\Requests
	 */
	class Programs{
		/**
		 * @return mixed
		 * @throws \TamkeenLMSAPI\Exception\LimitReachedException
		 */
		public function get(){
			$request = new Request('branches');

			return $request->send();
		}
	}
