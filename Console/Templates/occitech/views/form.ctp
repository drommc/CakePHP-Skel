<?php
/**
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
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="<?php echo $pluralVar; ?> form">
	<div class="page-header">
		<h1><?php printf("<?= __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h1>
	</div>

	<?php echo "<?= \$this->Form->create('{$modelClass}'); ?>\n"; ?>
	<fieldset>
		<legend><?php echo "<?= __('{$singularHumanName}'); ?>" ?></legend>
<?php
		echo "\t\t<?=";
		$fieldsString = '';
		if (strpos($action, 'edit') !== false) {
			$fieldsString .= "\n\t\t\t\$this->Form->input('{$primaryKey}') .";
		}
		$fieldsString .= "\n\t\t\t\$this->Partial->render('form');";
		echo $fieldsString . "\n\t\t?>\n";
?>
	</fieldset>
	<?php
	echo "<?= \$this->Form->end(__('Submit')); ?>\n";
?>
</div>
<div class="actions">
	<h3><?php echo "<?= __('Actions'); ?>"; ?></h3>
	<ul>
<?php if (strpos($action, 'add') === false): ?>
		<?php echo "<?= \$this->Actions->setActionsOptions(\$this->Form->value('{$modelClass}.{$primaryKey}')) ?>\n" ?>
		<li>
			<?php echo "<?= \$this->Actions->deletePost(
				null,
				__('Are you sure you want to delete the {$singularHumanName} #%s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))
			); ?>\n"; ?>
		</li>
<?php endif; ?>
		<li><?php echo "<?= \$this->Actions->index(); ?>"; ?></li>
<?php
		$done = array();
		foreach ($associations as $type => $data) {
			foreach ($data as $alias => $details) {
				if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
					echo "\t\t<li><?= \$this->Actions->index(__('List " . Inflector::humanize($details['controller']) . "'), '{$details['controller']}'); ?></li>\n";
					echo "\t\t<li><?= \$this->Actions->add(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), '{$details['controller']}'); ?></li>\n";
					$done[] = $details['controller'];
				}
			}
		}
?>
	</ul>
</div>
