<?php namespace iblank\GovSearch;

require_once __DIR__ . '/../vendor/autoload.php';

use iblank\GovSearch\GovSearch;

class GovSearchTest extends \PHPUnit_Framework_TestCase {
	/**
	 *
	 *
	 * @var GovSearch
	 */
	var $govsearch;

	public function setUp() {
		$TEST_API_KEY = 'weioevinweoih4oi4n24lrn4'; // jibberish
		$TEST_API_AFFILIATE = 'www.anything.com';
		$this->govsearch = new GovSearch( $TEST_API_KEY, $TEST_API_AFFILIATE );
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
		$response = $this->govsearch->search( 'medal', 0, $opts );
		$this->assertEquals( $opts['limit'], count( $response->results ) );
	}
}