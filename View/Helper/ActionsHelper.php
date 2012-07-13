<?php
/**
 * Action Helper
 * Allows to generate simple CRUD links for a given object and customize its rendering
 * It only works for default baked urls
 *
 * Usage:
 * <code>
 * 		$this->Actions->setActionsOptions($order['Order']['id'], true);
 * 		echo $this->Actions->view();
 * 		echo $this->Actions->edit();
 * 		echo $this->Actions->deletePost(
 * 			null,
 * 			__('Are you sure you want to delete the Order #%s?', $order['Order']['id'])
 * 		);
 * </code>
 *
 * Note: For now it is really specific to Twitter Bootstrap
 *
 * @todo  Reduce code duplication: it might be possible to create a generic data structure to represent each action
 *        and remove the "setActionsOptions" with something else to be stateless
 * @todo  Make me more and more generic by adding options to each method when needed
 * @todo  Allow to define different url schemes, using Configure for instance
 */
class ActionsHelper extends AppHelper {
/**
 * Helpers used in the class
 *
 * @var array
 */
	public $helpers = array('Form', 'Html');

/**
 * Id of the current object to generate links for
 *
 * @var string
 */
	protected $_id = null;

/**
 * Whether a tooltip must be displayed instead of the text
 *
 * @var boolean
 */
	protected $_tooltip = false;

/**
 * Set options to use in future calls
 *
 * @param string $id  Object id
 * @param boolean $tooltip Set to true to use icon + tooltips instead of icon + text
 */
	public function setActionsOptions($id, $tooltip = false) {
		$this->_id = $id;
		$this->_tooltip = $tooltip;
	}

	public function add($title = null, $controller = null, $options = array()) {
		if (is_null($title)) {
			$title = __('Ajouter');
		}
		return $this->action($title, 'add', 'icon-plus-sign', false, $controller, $options);
	}

	public function index($title = null, $controller = null, $options = array()) {
		if (is_null($title)) {
			$title = __('Lister');
		}
		return $this->action($title, 'index', 'icon-th-list', false, $controller, $options);
	}

	public function view($title = null, $controller = null, $options = array()) {
		if (is_null($title)) {
			$title = __('Voir');
		}
		return $this->action($title, 'view', 'icon-screenshot', true, $controller, $options);
	}

	public function edit($title = null, $controller = null, $options = array()) {
		if (is_null($title)) {
			$title = __('Modifier');
		}
		return $this->action($title, 'edit', 'icon-edit', true, $controller, $options);
	}

/**
 * Link to the delete action for an object, using a Post form
 *
 * @param string $title Link title, optional
 * @param mixed $confirmMessage Confirmation message, false if no confirmation is needed
 * @param string $controller Controller related. If not set, use the current controller.
 * @return string Html link to this action
 */
	public function deletePost($title = null, $confirmMessage = false, $controller = null, $options = array()) {
		$this->_requireId();
		if (is_null($title)) {
			$title = __('Supprimer');
		}
		$options = array_merge(
			array('escape' => false, 'class' => 'delete', 'title' => $title, 'rel' => 'tooltip'),
			$options
		);

		$url = $this->_makeUrl(array('action' => 'delete', $this->_id), $controller);
		return $this->Form->postLink(
			$this->_linkTitle('icon-remove-circle', $title),
			$url,
			$options,
			$confirmMessage
		);
	}

/**
 * Link to an action for an object.
 *
 * @param string $title Link title.
 * @param string $action The action.
 * @param string $withId Do the action need the object id.
 * @param string $controller Controller related. If not set, use the current controller.
 * @return string Html link to this action.
 */
	public function action($title, $action, $icon, $withId = false, $controller = null, $options = array()){
		$url = array('action' => $action);
		if ($withId) {
			$this->_requireId();
			$url[] = $this->_id;
		}
		$options = array_merge(
			array('escape' => false, 'class' => $action, 'title' => $title, 'rel' => 'tooltip'),
			$options
		);

		$url = $this->_makeUrl($url, $controller);
		return $this->Html->link($this->_linkTitle($icon, $title), $url, $options);
	}

/**
 * Generate a link title
 *
 * @param  string  $icon      Icon to use
 * @param  string  $title     Title of the link
 * @param  boolean $isTooltip True if this is a title for a tooltip, optional [default: $this->_tooltip]
 * @return string             Title to use: if tooltip, just the icon
 */
	protected function _linkTitle($icon, $title, $isTooltip = null) {
		if (is_null($isTooltip)) {
			$isTooltip = $this->_tooltip;
		}

		$linkTitle = '<i class="' . $icon . '"></i>';
		if (!$isTooltip) {
			$linkTitle .= $title;
		}
		return $linkTitle;
	}

/**
 * Checks if an object id has been set and trigger an error if it is not the case
 *
 * @return void
 */
	protected function _requireId() {
		if (is_null($this->_id)) {
			trigger_error('No object has been defined. Have you forgotten to call $this->Actions->setActionsOptions()?');
		}
	}

/**
 * Allows to generate an url with a mandatory part, and optionnaly a customized base
 *
 * @param  array $url        Parts of the url that are mandatory
 * @param  mixed $customBase Custom url base (array elements) to change from the router defaults
 *                           As a shorthand, if this is a string it will be considered as a custom controller
 * @return array Url
 */
	protected function _makeUrl($url, $customBase) {
		if (!empty($customBase)) {
			if (!is_array($customBase)) {
				$customBase = array('controller' => $customBase);
			}
			$url = array_merge($customBase, $url);
		}
		return $url;
	}
}