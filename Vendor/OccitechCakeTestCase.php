<?php
/**
 * Test Librairy.
 * Extends core librairy to add convenience methods.
 */
class OccitechCakeTestCase extends CakeTestCase {
/**
 * First record from fixtures
 *
 * @var array
 */
	protected $_record = array();

/**
 * Asserts that data are valid given Model validation rules
 * Calls the Model::validate() method and asserts the result
 *
 * @param Model $Model Model being tested
 * @param array $data Data to validate
 * @return void
 */
	public function assertValid(Model $Model, $data) {
		$this->assertTrue($this->_validData($Model, $data));
	}

/**
 * Asserts that data are validation errors match an expected value when
 * validation given data for the Model
 * Calls the Model::validate() method and asserts validationErrors
 *
 * @param Model $Model Model being tested
 * @param array $data Data to validate
 * @param array $expectedErrors Expected errors keys
 * @return void
 */
	public function assertValidationErrors($Model, $data, $expectedErrors) {
		$this->_validData($Model, $data, $validationErrors);
		sort($expectedErrors);
		$this->assertEqual(array_keys($validationErrors), $expectedErrors);
	}

/**
 * Convenience method allowing to validate data and return the result
 *
 * @param Model $Model Model being tested
 * @param array $data Profile data
 * @param array $validationErrors Validation errors: this variable will be updated with validationErrors (sorted by key) in case of validation fail
 * @return boolean Return value of Model::validate()
 */
	protected function _validData(Model $Model, $data, &$validationErrors = array()) {
		$valid = true;
		$Model->create($data);
		if (!$Model->validates()) {
			$validationErrors = $Model->validationErrors;
			ksort($validationErrors);
			$valid = false;
		} else {
			$validationErrors = array();
		}
		return $valid;
	}

/**
 * Execute a search, return the result ids and generated conditions
 *
 * @param Model $Model Model being tested
 * @param array $criteria Search criteria
 * @param array $conditions (Out) search conditions used
 * @return array List of result ids in the returned order
 */
	protected function _searchResults(Model $Model, $criteria, &$conditions = array()) {
		$conditions = $Model->parseCriteria($criteria);
		$results = $Model->find('all', compact('conditions'));
		return Hash::extract($results, '{n}.' . $Model->alias . '.id');
	}

/**
 * Assert results of a search with criteria
 *
 * @param Model $Model Model being tested
 * @param array $criteria Search criteria
 * @param array $expected Expected id
 */
	protected function _assertSearchResults(Model $Model, $criteria, $expected) {
		$results = $this->_searchResults($Model, $criteria, $conditions);
		sort($expected);
		sort($results);
		$this->assertEqual($results, $expected);
	}

//Function avoiding error when using in a group
	public function test() {

	}
}