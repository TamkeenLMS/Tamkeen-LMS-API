<?php namespace TamkeenLMSAPI\Requests;

	use TamkeenLMSAPI\Client;
	use TamkeenLMSAPI\Exceptions\LimitReachedException;

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
		 * @param $path
		 * @param string $method
		 */
		public function __construct($path, $method = null){
			$this->method = strtoupper($method ?: 'get');
			$this->path = $path;

			if(
				empty(Client::$setup['api_key']) || empty(Client::$setup['api_base_url'])
			){
				throw new \Exception('You need provide the setup information required for this client to work!');
			}
		}

		/**
		 * Sets the POST data
		 * @param array $data
		 *
		 * @return $this
		 */
		public function setPostData(array $data){
			$this->formParams = $data;

			return $this;
		}

		/**
		 * Passes a URI query segment
		 * @param $key
		 * @param $value
		 *
		 * @return $this
		 */
		public function setQuerySegment($key, $value){
			$this->query[$key] = $value;

			return $this;
		}

		/**
		 * @param array $segments
		 *
		 * @return $this
		 */
		public function setQuerySegments(array $segments){
			$this->query = $segments;

			return $this;
		}

		/**
		 * Sets the locale of the response
		 * @param $locale
		 *
		 * @return $this
		 */
		public function setLocale($locale){
			$this->setQuerySegment('locale', $locale);

			return $this;
		}

		/**
		 * Passes the id of the branch meant to be sent along with the request
		 * @param $branchId
		 *
		 * @return $this
		 */
		public function setBranch($branchId){
			$this->setQuerySegment('branch', $branchId);

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function send(){
			try{
				// The client
				$requestClient = new \GuzzleHttp\Client(['base_uri' => Client::$setup['api_base_url']]);

				// Add the API Key to the request
				$this->query['key'] = Client::$setup['api_key'];

				// Send the request
				$response = $requestClient->request($this->method, $this->path, [
					'verify'        => false,
					'query'         => $this->query,
					'form_params'   => $this->formParams
				]);

				// Decode the response
				$response = \GuzzleHttp\json_decode((string) $response->getBody());

				return $response;

			}catch (\GuzzleHttp\Exception\ClientException $exception){
				// Get the response code
				$responseCode = $exception->getResponse()->getStatusCode();

				switch($responseCode){
					case 429:
						// If the limit was reached
						throw new LimitReachedException();
						break;

					case 404:
						// Path not found
						throw new \Exception("Wrong path! /{$this->path} does not exist!");
						break;

					case 500:
						// Error on the application side!
						throw new \Exception('Tamkeen LMS error');
						break;
				}
			}
		}
	}