<?php
/**
 * Test Case bake template
 *
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.classes
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo "<?php\n";
?>
<?php foreach ($uses as $dependency): ?>
App::import('Vendor', 'OccitechCakeTestCase');
App::uses('<?php echo $dependency[0]; ?>', '<?php echo $dependency[1]; ?>');
<?php endforeach; ?>

<?php if ($mock and strtolower($type) == 'controller'): ?>
/**
 * Test<?php echo $fullClassName; ?>
 *
 */
class Test<?php echo $fullClassName; ?> extends <?php echo $fullClassName; ?> {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

<?php endif; ?>
/**
 * <?php echo $fullClassName; ?> Test Case
 *
 */
class <?php echo $fullClassName; ?>TestCase extends OccitechCakeTestCase {
<?php if (!empty($fixtures)): ?>
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('<?php echo join("', '", $fixtures); ?>');

/**
 * Model being tested
 *
 * @var <?php echo $className; ?>

 */
	public $<?php echo $className; ?>;


<?php endif; ?>
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
<?php echo $preConstruct ? "\t\t" . $preConstruct : ''; ?>
		$this-><?php echo $className . ' = ' . $construction; ?>
<?php
	$_recordId = str_replace('_', '-', mb_strtolower(Inflector::underscore($className))) . '-1';
?>
		$this->_record = $this-><?php echo $className; ?>->findById('<?php echo $_recordId ?>');
<?php echo $postConstruct ? "\t\t" . $postConstruct : ''; ?>
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this-><?php echo $className;?>);
		parent::tearDown();
	}

/**
 * Test the validation Rules
 *
 */
	public function testRecordIsValid() {
		$this->assertValid($this-><?php echo $className; ?>, $this->_record);
	}

	public function testMandatoryFields () {
		$data = array('<?php echo $className; ?>' => array('id' => 'new-id'));
		$expected = array(/*Add mandatory fields here*/);
		$this->assertValidationErrors($this-><?php echo $className; ?>, $data, $expected);
	}

<?php foreach ($methods as $method): ?>
/**
 * test<?php echo Inflector::camelize($method); ?> method
 *
 * @return void
 */
	public function test<?php echo Inflector::camelize($method); ?>() {

	}
<?php endforeach;?>
}
