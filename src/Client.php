<?php namespace TamkeenLMSAPI;

	use TamkeenLMSAPI\Requests\Request;

	/**
	 * @package TamkeenLMSAPI
	 */
	class Client{
		/**
		 * The global setup
		 * @var array
		 */
		public static $setup = [
			'api_key' => null,
			'api_base_url' => null
		];

		/**
		 * The setup
		 * @param $baseUrl
		 * @param $apiKey
		 */
		public static function setup($baseUrl, $apiKey){
			static::$setup['api_base_url'] = $baseUrl;
			static::$setup['api_key'] = $apiKey;
		}

		/**
		 * Creates a new request
		 * @param $path
		 * @param array|NULL $query
		 * @param array|NULL $postData
		 * @param null $method
		 *
		 * @return Request
		 */
		public static function makeRequest($path, array $query = null, array $postData = null, $method = null){
			// Create the new request
			$request = new Request($path, $method);

			if(is_array($query)){
				$request->setQuerySegments($query);
			}

			if(is_array($postData)){
				$request->setPostData($postData);
			}

			return $request;
		}
	}