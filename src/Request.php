<?php namespace TamkeenLMSAPI;

	use GuzzleHttp\Client;

	/**
	 * @package TamkeenLMSAPI
	 */
	class Request{
		/**
		 * @var string
		 */
		public $path;
		/**
		 * @var string
		 */
		public $method;
		/**
		 * @var array
		 */
		public $query;
		/**
		 * @var array
		 */
		public $formParams;
		/**
		 * The global setup
		 * @var array
		 */
		public static $setup = [
			'api_key' => null,
			'api_base_url' => null
		];

		/**
		 * @param $path
		 * @param string $method
		 */
		public function __construct($path, $method = 'GET'){
			$this->method = strtoupper($method);
			$this->path = $path;
		}

		/**
		 * @return mixed
		 */
		public function send(){
			// The client
			$requestClient = new Client(static::$setup['api_base_url']);

			// Add the API Key to the request
			$this->query['key'] = static::$setup['api_key'];

			// The request
			$response = $requestClient->request($this->method, $this->path, [
				'verify' => false,
				'query' => $this->query,
				'form_params' => $this->formParams
			]);

			// Decode the response
			return \GuzzleHttp\json_decode((string) $response->getBody());
		}
	}