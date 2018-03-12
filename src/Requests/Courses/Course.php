<?php namespace TamkeenLMSAPI\Requests\Courses;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI\Requests\Courses
	 */
	class Course extends Request{
		/**
		 * @param $courseId
		 */
		public function __construct($courseId){
			parent::__construct("courses/{$courseId}");
		}

		/**
		 * @return mixed
		 * @throws \Exception
		 * @throws \TamkeenLMSAPI\Exception\LimitReachedException
		 */
		public function get(){
			return $this->send();
		}
	}