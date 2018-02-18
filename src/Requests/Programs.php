<?php namespace TamkeenLMSAPI\Requests;

	use TamkeenLMSAPI\Request;

	/**
	 * @package TamkeenLMSAPI\Requests
	 */
	class Programs{
		/**
		 * @param $branchId
		 * @param $categoryId
		 * @param $page
		 */
		public function get($branchId, $categoryId, $page = 1){
			$request = new Request('programs');

			// Attach the branch and the category ids
			$request->query['branch'] = $branchId;
			$request->query['category'] = $categoryId;

			// Ad the page
			$request->query['page'] = $page;

			return $request->send();
		}

		/**
		 * @param $branchId
		 *
		 * @return mixed
		 */
		public function getCategories($branchId){
			$request = new Request('programs/categories');

			// Attach the branch id
			$request->query['branch'] = $branchId;

			return $request->send();
		}

		/**
		 * @param array $data
		 *
		 * @return mixed
		 * @throws \TamkeenLMSAPI\Exception\LimitReachedException
		 */
		public function signup(array $data){
			$request = new Request('programs/signup', 'POST');
			$request->formParams =  $data;

			return $request->send();
		}
	}