<?php
/**
 * Fixture Template file
 *
 * Fixture Template used when baking fixtures with bake
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
?>
<?php echo '<?php' . "\n"; ?>
/**
 * <?php echo $model; ?>Fixture
 *
 */
class <?php echo $model; ?>Fixture extends CakeTestFixture {
<?php if ($table): ?>
/**
 * Table name
 *
 * @var string
 */
	public $table = '<?php echo $table; ?>';
<?php endif; ?>
<?php if ($import): ?>
/**
 * Import
 *
 * @var array
 */
	public $import = <?php echo $import; ?>;
<?php endif; ?>

<?php if ($schema): ?>
/**
 * Fields
 *
 * @var array
 */
	public $fields = <?php echo $schema; ?>;
<?php endif;?>

<?php if ($records): ?>
	<?php
		$i = 1;
		$idBase = str_replace('_', '-', mb_strtolower(Inflector::underscore($model))) . '-';
		while (preg_match("/'id' => '[a-z0-9-]{36,36}'/", $records)) {
			$records = preg_replace(
				"/'id' => '[a-z0-9-]{36,36}'/",
				"'id' => '" . $idBase . $i++ . "'",
				$records,
				1
			);
		}
		while (preg_match("/'([\w]+)_id' => 'Lorem ipsum dolor sit amet'/", $records)) {
			$records = preg_replace(
				"/'([\w]+)_id' => 'Lorem ipsum dolor sit amet'/",
				"'$1_id' => '$1-1'",
				$records,
				1
			);
		}
		while (preg_match("/id' => '[\w]+_[\w]+-1'/", $records)) {
			$records = preg_replace(
				"/id' => '([\w]+)_([\w]+)-1'/",
				"id' => '$1-$2-1'",
				$records,
				1
			);
		}
	?>
/**
 * Records
 *
 * @var array
 */
	public $records = <?php echo $records; ?>;
<?php endif;?>
}
