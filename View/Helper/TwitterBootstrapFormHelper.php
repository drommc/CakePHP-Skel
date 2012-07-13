<?php
/**
 * Twitter Bootstrap Form Helper
 * Allows to generate the very minimum markup for each type of form
 *
 * Note: it is a WIP. For now it only works for horizontal forms by default, and must be coupled
 * 		 with the SASS stylesheet
 */
App::uses('FormHelper', 'View/Helper');
class TwitterBootstrapFormHelper extends FormHelper {

/**
 * Default options for Twitter Bootstrap inputs
 *
 * @var arrays
 */
	private $__inputDefaults = array(
		'none' => array(),
		'horizontal' => array(
			'div' => array('class' => 'control-group'),
			'between' => '<div class="controls">',
			'after' => '</div>',
			'format' => array('before', 'label', 'between', 'input', 'error', 'after')
		),
		'search' => array(
			'div' => false
		)
	);

/**
 * Returns an HTML FORM element.
 * Uses correct inputDefaults
 *
 * @todo Unit test me
 * @param string $model Model to generate the form for
 * @param array $options Form options. Same than the FormHelper, with the following differences
 *                       about the inputDefaults key:
 *                       - can be an array for the same behavior than Form::helper
 *                       - can be a string to use one of the preset available
 *                       	(see TwitterBootstrapFormHelper::__inputDefaults)
 *                       - can be an array, with the "preset" key to a valid preset. In this case
 *                       	the preset will be used as base and overriden by the passed keys
 * @return string
 */
	public function create($model = null, $options = array()) {
		$presetType = '';

		if (!empty($options['inputDefaults'])) {
			if (is_string($options['inputDefaults'])) {
				$presetType = $options['inputDefaults'];
				$options['inputDefaults'] = array();
			} elseif (array_key_exists('preset', $options['inputDefaults'])) {
				$presetType = $options['inputDefaults']['preset'];
				unset($options['inputDefaults']['preset']);
			}
		} else {
			$options['inputDefaults'] = array();
		}
		$presetType = array_key_exists($presetType, $this->__inputDefaults) ? $presetType : 'horizontal';

		$options['inputDefaults'] = array_merge($this->__inputDefaults[$presetType], $options['inputDefaults']);
		return parent::create($model, $options);
	}

/**
 * Overrides the parent input to wrap it with "prepended" and/or "appended" icons
 *
 * @param  string $fieldName Field name
 * @param  array  $options   Input options. Same than FormHelper::input, with 2 additional keys:
 *                           	- prepend: text to prepend
 *                           	- append: text to append
 *                           	- wrappindDivClass: array of classes for the wrapping div used "in between"
 * @return string            Html markup
 */
	public function iconizedInput($fieldName, $options = array()) {
		$prepend = empty($options['prepend']) ? false : $options['prepend'];
		$append = empty($options['append']) ? false : $options['append'];
		unset($options['prepend'], $options['append']);

		if ($prepend || $append) {
			foreach(array('between', 'after') as $key) {
				if (empty($options[$key])) {
					$options[$key] = '';
				}
			}

			$wrappingDivClasses = empty($options['wrappingDivClasses']) ? array() : (array) $options['wrappingDivClasses'];
			unset($options['wrappingDivClasses']);
			if ($prepend) {
				$wrappingDivClasses[] = 'input-prepend';
				$options['between'] .= $this->Html->tag('span', $prepend, array('class' => 'add-on'));
			}
			if ($append) {
				$wrappingDivClasses[] = 'input-append';
				$options['after'] = $this->Html->tag('span', $append, array('class' => 'add-on')) . $options['after'];
			}
			$options['between'] = '<div class="' . implode(' ', $wrappingDivClasses) . '">' . $options['between'];
			$options['after'] .= '</div>';
		}

		return parent::input($fieldName, $options);
	}

	public function input($fieldName, $options = array()) {
		if (is_string($options)) {
			$options = array('label' => $options);
		}

		if (isset($options['type']) && $options['type'] === 'radio') {
			$options['after'] = '';
		} else {
			if (isset($options['between']) && !isset($options['after'])) {
				$options['after'] = '';
			}
			if (isset($options['after']) && !isset($options['between'])) {
				$options['after'] .= '</div>';
			}
		}
		return parent::input($fieldName, $options);
	}

/**
 * Creates a set of radio widgets. Will create a legend and fieldset
 * by default.  Use $options to control this
 *
 * ### Attributes:
 * - `controls` - class to use for the wrapper div, default "controls"
 * - `separator` - define the string in between the radio buttons
 * - `between` - the string between legend and input set
 * - `legend` - control whether or not the widget set has a fieldset & legend
 * - `value` - indicate a value that is should be checked
 * - `label` - boolean to indicate whether or not labels for widgets show be displayed
 * - `hiddenField` - boolean to indicate if you want the results of radio() to include
 *    a hidden input with a value of ''. This is useful for creating radio sets that non-continuous
 * - `disabled` - Set to `true` or `disabled` to disable all the radio buttons.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Radio button options array.
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function radio($fieldName, $options = array(), $attributes = array()) {
		$_defaultAttributes = array('controls' => 'controls');
		$attributes = array_merge($_defaultAttributes, $attributes);

		$label = '';
		if (!empty($attributes['legend'])) {
			$label = $attributes['legend'];
		} elseif(!isset($attributes['legend'])) {
			if (count($options) > 1) {
				$label = __(Inflector::humanize($this->field()));
			}
		}

		$globalLabel = empty($label) ? '' : $this->Html->tag('label', $label, array('class' => 'control-label'));
		$attributes['legend'] = false;

		$radio = parent::radio($fieldName, $options, $attributes);

		return $globalLabel . $this->Html->div($attributes['controls'], $radio);
	}

/**
 * Add an or cancel link after the submit button
 *
 * @see FormHelper::submit
 */
	public function submitOrCancel($caption = null, $options = array()) {
		if (!isset($options['after'])) {
			$options['after'] = '';
		}
		$options['after'] = $this->Html->tag(
			'span',
			String::insert(__(' or :cancel', true), array(
				'cancel' => $this->Html->link(__('Cancel', true), array('action' => 'index'))
			)),
			array('class' => 'cancel')
		);
		return parent::submit($caption, $options);
	}

	public function dateInput($fieldName, $options = array()) {
		if (!isset($options['append'])) {
			$options['append'] = '<i class="icon-calendar"></i>';
		}
		if (!isset($options['class'])) {
			$options['class'] = '';
		}
		$options['class'] .= ' date';
		$options['type'] = 'text';

		return $this->iconizedInput($fieldName, $options);
	}
}