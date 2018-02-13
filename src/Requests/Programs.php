<?php namespace TamkeenLMSAPI\Requests;

	use TamkeenLMSAPI\Request;

	/**
	 * @package TamkeenLMSAPI\Requests
	 */
	class Programs{
		/**
		 * @param $branchId
		 * @param string $categoryId
		 */
		public function get($branchId, $categoryId, $page){
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
	}