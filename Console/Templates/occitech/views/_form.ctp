<?php
	echo "<?=";
	$fieldsString = '';
	foreach ($fields as $field) {
		if (!in_array($field, array('created', 'modified', 'updated', $primaryKey))) {
			$fieldsString .= "\n\t\$this->Form->input('{$field}', array('label' => __('" . Inflector::humanize($field) . "'))) .";
		}
	}
	if (!empty($associations['hasAndBelongsToMany'])) {
		foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
			$fieldsString .= "\n\t\$this->Form->input('{$assocName}', array('label' => __('" . Inflector::humanize($assocName) . "'))) .";
		}
	}
	echo trim($fieldsString, '.') . "\n?>\n";
?>