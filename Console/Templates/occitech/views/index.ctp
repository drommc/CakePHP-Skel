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
<div class="<?php echo $pluralVar; ?> index">
	<div class="page-header">
		<h1><?php echo "<?= __('{$pluralHumanName}'); ?>"; ?></h1>
	</div>

	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
<?php foreach ($fields as $field): ?>
				<th><?php echo "<?= \$this->Paginator->sort('{$field}', __('" . Inflector::humanize($field) . "')); ?>"; ?></th>
<?php endforeach; ?>
				<th class="actions"><?php echo "<?= __('Actions'); ?>"; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t\t\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t\t\t<td>\n\t\t\t\t\t<?= \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t\t\t<td><?= h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t\t\t<td class=\"actions\">\n";
		echo "\t\t\t\t\t<?php \$this->Actions->setActionsOptions(\${$singularVar}['{$modelClass}']['{$primaryKey}'], true); ?>\n";
		echo "\t\t\t\t\t<?= \$this->Actions->view(); ?>\n";
	 	echo "\t\t\t\t\t<?= \$this->Actions->edit(); ?>\n";
	 	echo "\t\t\t\t\t<?= \$this->Actions->deletePost(null, __('Are you sure you want to delete the {$singularHumanName} #%s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t\t\t</td>\n";
	echo "\t\t\t</tr>\n";

	echo "\t\t<?php endforeach; ?>\n";
	?>
		</tbody>
	</table>
	<?php echo "<?= \$this->element('paging'); ?>\n" ?>
</div>
<div class="actions">
	<h3><?php echo "<?= __('Actions'); ?>"; ?></h3>
	<?php echo "<?php \$this->Actions->setActionsOptions(null); ?>\n"; ?>
	<ul>
		<li><?php echo "<?= \$this->Actions->add(); ?>"; ?></li>
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
