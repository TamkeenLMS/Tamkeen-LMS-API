<?php namespace TamkeenLMSAPI\Requests\Programs;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests\Programs
	 */
	class Programs extends Request{
		/**
		 * @param $branchId
		 * @param $categoryId
		 */
		public function __construct($branchId, $categoryId){
			parent::__construct('programs');

			// Set the branch
			$this->setBranch($branchId);

			// Set the category
			$this->setCategory($categoryId);
		}

		/**
		 * Passes the id of the programs category from which the programs should be retrieved
		 * @param $categoryId
		 *
		 * @return $this
		 */
		public function setCategory($categoryId){
			$this->setQuerySegment('category', $categoryId);

			return $this;
		}

		/**
		 * Passes the page number for the pagination
		 * @param $page
		 *
		 * @return $this
		 */
		public function setPage($page){
			$this->setQuerySegment('page', $page);

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function get(){
			return $this->send();
		}
	}