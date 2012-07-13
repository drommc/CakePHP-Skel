<?php
/**
 * The View Tasks handles creating and updating view files.
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
 * @since         CakePHP(tm) v 1.2
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ViewTask', 'Console/Command/Task');

/**
 * Task class for creating and updating view files.
 *
 * @package       Cake.Console.Command.Task
 */
class OcciviewTask extends ViewTask {
/**
 * Actions to use for partials 
 *	Associativ array where keys are partial name and values are action for which create the partial
 *
 * @var array
 */
	public $partialActions = array('_form' => array('add', 'edit'));

/**
 * Assembles and writes bakes the view file.
 *
 * @param string $action Action to bake
 * @param string $content Content to write
 * @return boolean Success
 */
	public function bake($action, $content = '') {
		$partialCreated = true;
		$fileCreated = parent::bake($action, $content);
		foreach ($this->partialActions as $partialName => $partialActions) {
			if ($this->shouldBakePartial($partialActions, $action)) {
				$path = $this->getPath();
				$filename = $path . $this->controllerName . DS . Inflector::underscore($partialName) . '.ctp';
				if (!file_exists($filename)) {
					$partialCreated = $this->createFile($filename, $this->getContent($partialName));
				}
			}
		}
		return $fileCreated && $partialCreated;
	}

	protected function shouldBakePartial($partialActions, $action) {
		$shouldBakePartial = false;
		$shouldBakePartial = $shouldBakePartial || in_array($action, $partialActions);
		foreach ($partialActions as $partialAction) {
			$shouldBakePartial = $shouldBakePartial || preg_match('/_' . $partialAction . '$/', $action);
		}
		return $shouldBakePartial;
	}
}
