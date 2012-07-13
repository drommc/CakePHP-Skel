<?php
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 */
class AppController extends Controller {

	public $components = array(
		// TODO Configure Auth with the correct app settings
		// 'Auth' => array(
		// 	'loginAction' => array('plugin' => null, 'controller' => 'users', 'action' => 'login', 'admin' => false),
		// 	'authorize' => array('Controller')
		// ),
		'DebugKit.Toolbar',
		'RequestHandler',
		'Session',
		'Paginator'
	);

/**
 * App wide helpers
 * The aliasing is checked in thre beforeRender too
 *
 * @see AppController::_checkHelperAliasing
 * @var array
 */
	public $helpers = array(
		'Actions',
		'Decorator',
		'Form' => array('className' => 'TwitterBootstrapForm'),
		'Html' => array('className' => 'TwitterBootstrapHtml'),
		'Js' => array('Jquery'),
		'Partials.Partial',
		'Session',
	);

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function beforeRender() {
		parent::beforeRender();
		// TODO Uncomment these lines when the Auth stack will be implemented. These variables are convenient in views
		// $this->loadModel('User');
		// $this->set('userData', $this->Auth->user());
		// $this->set('isAdminUser', $this->User->isAdmin($this->Auth->user()));
		$this->set('isAdminArea', $this->_isAdminArea());

		$this->_checkHelperAliasing();
	}

	public function isAuthorized() {
		$authorized = true;
		if ($this->_isAdminArea()) {
			// TODO Checks if the user is an admin or not
			// $this->loadModel('User');
			// $authorized = $this->User->isAdmin($this->Auth->user());
		}
		return $authorized;
	}

	protected function _isAdminArea() {
		return !empty($this->request->params['prefix']) && $this->request->params['prefix'] === 'admin';
	}

/**
 * Checks that all aliased helpers are aliased properly
 * It allows to fix issues with plugin defining their own helper aliasing (frequent for Html / Form)
 *
 * @return void
 */
	protected function _checkHelperAliasing() {
		$aliases = array(
			'Html' => 'TwitterBootstrapHtml',
			'Form' => 'TwitterBootstrapForm',
		);
		foreach ($aliases as $alias => $helper) {
			if (false !== ($helperIndex = array_search($alias, $this->helpers))) {
				unset($this->helpers[$helperIndex]);
			}
			$this->helpers[$alias]['className'] = $helper;
		}
	}

}