<?php
/**
 * Twitter Bootstrap Html Helper
 * Provides shorthand methods to generate Twitter bootstrap ompatible markup
 *
 */
App::uses('HtmlHelper', 'View/Helper');
class TwitterBootstrapHtmlHelper extends HtmlHelper {

/**
 * Constructor
 * Overrides the parent one to add some specific Twitter tags to the list
 *
 * @param View  $View
 * @param array $settings
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		$this->_tags += array(
			'help-inline' => '<span class="help-inline">%s</span>',
			'help-block' => '<p class="help-block">%s</p>',
		);
	}

/**
 * Overrides the parent link to allow prepending / appending an icon or a text
 *
 * @param string $title The content to be wrapped by <a> tags.
 * @param mixed $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
 * @param array $options Array of HTML attributes. Same than HtmlHelper::link, with 2 additional keys:
 *                       - prepend: class of the icon to prepend
 *                       - append:  class of the icon to append
 *                       - before: text to prepend
 *                       - after: text to append
 * @param string $confirmMessage JavaScript confirmation message.
 * @return string An `<a />` element.
 */
	public function link($title, $url = null, $options = array(), $confirmMessage = false) {
		$_defaults = array('prepend' => false, 'append' => false, 'before' => '', 'after' => '');
		$selfOptions = array_intersect_key(
			array_merge($_defaults, $options),
			$_defaults
		);
		$options = array_diff_key($options, $selfOptions);
		extract($selfOptions);

		if ($prepend) {
			$title = $this->tag('i', '', array('class' => $prepend)) . ' ' . $title;
		}
		if ($append) {
			$title .= ' ' . $this->tag('i', '', array('class' => $append));
		}
		if ($prepend || $append) {
			$options['escape'] = false;
		}

		return $before . parent::link($title, $url, $options, $confirmMessage) . $after;
	}

/**
 * Generates a dropdown trigger link element
 *
 * @param string $title The content to be wrapped by <a> tags.
 * @return string An `<a />` element.
 */
	public function dropdownTrigger($title) {
		return $this->link(
			$title . ' <b class="caret"></b>',
			'#',
			array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)
		);
	}

/**
 * Include Wysihtml5 necessary scripts
 * Scripts will be included only once even if called multiple times (if $force = false)
 *
 * @see https://github.com/jhollingworth/bootstrap-wysihtml5/
 * @param  array  $options Options for the scripts
 *                         - inline: boolean (similar to Html::css / Html::script)
 *                         - path: path to the root directory WITH a trailing slash
 * @param boolean $force Whether the include must be forced or not, if false only the first call will do something
 * @return mixed
 */
	public function wysihtml5Scripts($options = array(), $force = false) {
		static $initialized = false;
		if ($initialized && !$force) {
			return;
		}
		$initialized = true;

		$_defaults = array(
			'inline' => false,
			'path' => '/js/Vendor/bootstrap-wysihtml5/'
		);
		$options = array_merge($_defaults, $options);
		$path = $options['path'];
		unset($options['path']);

		$files = array(
			'css' => array('bootstrap-wysihtml5-0.0.2.css'),
			'js' => array('wysihtml5-0.3.0_rc2.min.js', 'bootstrap-wysihtml5-0.0.2.min.js')
		);
		foreach ($files['css'] as &$file) {
			$file = $path . $file;
		}
		foreach ($files['js'] as &$file) {
			$file = $path . $file;
		}

		$out = $this->css($files['css'], null, $options) . $this->script($files['js'], $options);

		return $out;
	}

/**
 * Adds a link to the breadcrumbs array.
 * Overrides the method to return the Helper object allowing for chained calls
 *
 * @param string $name Text for link
 * @param string $link URL for link (if empty it won't be a link)
 * @param mixed $options Link attributes e.g. array('id' => 'selected')
 * @return TwitterBootstrapHtmlHelper
 */
	public function addCrumb($name, $link = null, $options = null) {
		parent::addCrumb($name, $link, $options);
		return $this;
	}

	public function hasCrumbs() {
		return !empty($this->_crumbs);
	}

/**
 * Prepends startText to crumbs array if set
 * and appends a Twitter bootstrap compatible divider to each crumb
 *
 * @param $startText
 * @return array Crumb list including startText (if provided)
 */
	protected function _prepareCrumbs($startText) {
		$separator = $this->tag('span', '/', array('class' => 'divider'));

		$crumbs = parent::_prepareCrumbs($startText);
		$last = array_pop($crumbs);
		foreach ($crumbs as &$crumb) {
			$crumb[2]['after'] = $separator;
		}
		array_push($crumbs, $last);

		return $crumbs;
	}

}