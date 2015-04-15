<?php namespace iblank\GovSearch;

class GovSearch {

	/**
	 * @var string
	 */
	protected $govsearch_key;// from the config file

	/**
	 * @var array
	 */
	var $APIs = array(
    	'search' => 'https://search.usa.gov/api/v2/search'
	);

	/**
	 * Constructor
	 * $govsearch = new GovSearch(array('key' => 'KEY HERE', 'affiliate' => 'AFFILIATE HERE', 'defaults' => optionsArray))
	 *
	 * @param array $key
	 * @param array $affiliate
	 * @param array $defaults
	 * @throws \Exception
	 */
	public function __construct($key, $affiliate, $defaults = null) {
		if (is_string($key) && !empty($key)) {
			$this->govsearch_key = $key;
		} else {
			throw new \Exception('API access key is Required, please visit http://search.digitalgov.gov/');
		}
		if (is_string($affiliate) && !empty($affiliate)) {
			$this->govsearch_affiliate = $affiliate;
		} else {
			throw new \Exception('An affiliate site string is Required, please visit http://search.digitalgov.gov/');
		}

		if (is_array($defaults)) {
			$this->limit = $defaults['limit'];
			$this->highlight = $defaults['highlight'];
			$this->sort = $defaults['sort'];
		} else {
			$this->limit = 20;
			$this->highlight = true;
			$this->sort = 'relevance';
		}
	}

	/**
	 * @param $search
	 * @return \StdClass
	 * @throws \Exception
	 */
	public function search($search, $offset = 0, $opts = array()) {
		$API_URL = $this->getApi('search');
		
		$params = array(
			'query' => $search,
			'enable_highlighting' => (isset($opts['highlight'])) ? $opts['highlight'] : $this->highlight,
			'limit' => (isset($opts['limit'])) ? $opts['limit'] : $this->limit,
			'offset' => $offset,
			'sort_by' => (isset($opts['sort'])) ? $opts['sort'] : $this->sort,
		);

		// convert boolean value to string...
		$params['enable_highlighting'] = ($params['enable_highlighting'])? "true" : "false";

		$apiData = $this->api_get($API_URL, $params);
		
		return $this->decodeResponse($apiData);
	}

	/**
	 * Decode the response from govsearch, extract the results array.
	 *
	 * @param  string $apiData the api response from govsearch
	 * @throws \Exception
	 * @return \StdClass  an GovSearch resource object
	 */
	public function decodeResponse(&$apiData) {
		$resObj = json_decode($apiData);
		if (isset($resObj->error)) {
			$msg = "Error " . $resObj->error->code . " " . $resObj->error->message;
			if (isset($resObj->error->errors[0])) {
				$msg .= " : " . $resObj->error->errors[0]->reason;
			}
			throw new \Exception($msg);
		} else {
			return $resObj->web;
		}
	}

	/**
	 * Using CURL to issue a GET request
	 *
	 * @param $url
	 * @param $params
	 * @return mixed
	 * @throws \Exception
	 */
	public function api_get($url, $params) {
		//set the govsearch key / affiliate
		$params['access_key'] = $this->govsearch_key;
		$params['affiliate'] = $this->govsearch_affiliate;

		//boilerplates for CURL
		$tuCurl = curl_init();
		curl_setopt($tuCurl, CURLOPT_URL, $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params));
		if (strpos($url, 'https') === false) {
			curl_setopt($tuCurl, CURLOPT_PORT, 80);
		} else {
			curl_setopt($tuCurl, CURLOPT_PORT, 443);
		}
		curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
		$tuData = curl_exec($tuCurl);
		if (curl_errno($tuCurl)) {
			throw new \Exception('Curl Error : ' . curl_error($tuCurl));
		}
		return $tuData;
	}

	/*
	 *  Internally used Methods, set visibility to public to enable more flexibility
	 */

	/**
	 * @param $name
	 * @return mixed
	 */
	public function getApi($name) {
		return $this->APIs[$name];
	}

}
