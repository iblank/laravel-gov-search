<?php namespace iblank\GovSearch;

require_once __DIR__ . '/../vendor/autoload.php';

use iblank\GovSearch\GovSearch;

class MockGovSearch {
	public function search($search, $offset = 0, $opts = array()) {
		$limit = (isset($opts['limit'])) ? $opts['limit'] : 20;
		$results = array();
		for($i = 0; $i < $limit; $i++){
			$tempObj = (object) array(
				"title" => "title #".$i
			);
			array_push($results, $tempObj);
		}
		$fakeReturn = (object) array(
			"total" => 234,
			"next_offset" => $limit,
			"results" => $results
		);

		return $fakeReturn;
	}

}

class GovSearchTest extends \PHPUnit_Framework_TestCase {
	/**
	 *
	 *
	 * @var GovSearch
	 */
	var $govsearch;

	public function setUp() {
		$TEST_API_KEY = 'weioevinweoih4oi4n24lrn4567'; // jibberish
		$TEST_API_AFFILIATE = 'www.anything.com';
		$this->govsearch = new GovSearch( $TEST_API_KEY, $TEST_API_AFFILIATE );
		$this->mocksearch = new MockGovSearch();
	}

	public function tearDown() {
		$this->govsearch = null;
	}

	/**
	 *
	 *
	 * @expectedException \Exception
	 */
	public function testConstructorFail() {
		$this->govsearch = new GovSearch( array(), '' );
	}

	/**
	 *
	 *
	 * @expectedException \Exception
	 */
	public function testConstructorFail2() {
		$this->govsearch = new GovSearch( 'FAKE API KEY', '' );
	}

	// search($search, $offset = 0, $opts = array(highlight = true, limit = 20, sort = 'relevance'))
	public function testSearch() {
		$opts = array(
			'limit' => rand( 3, 10 )
		);
		$response = $this->mocksearch->search( 'medal', 0, $opts );
		$this->assertEquals( $opts['limit'], count( $response->results ) );
	}
}
