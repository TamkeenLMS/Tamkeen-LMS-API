<?php namespace TamkeenLMSAPI;

	use GuzzleHttp\Client;
	use TamkeenLMSAPI\Exception\LimitReachedException;

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
		public function __construct($path, $method = null){
			$this->method = strtoupper($method ?: 'get');
			$this->path = $path;
		}

		/**
		 * @param $path
		 * @param $method
		 *
		 * @return static
		 */
		public static function make($path, $method){
			return (new static($path, $method));
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

			// If the limit was reached
			if($response->getStatusCode() == 429){
				throw new LimitReachedException(); }

			// Decode the response
			$response = \GuzzleHttp\json_decode((string) $response->getBody());

			return $response;
		}
	}