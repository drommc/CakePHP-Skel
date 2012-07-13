<?php
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 */
class AppModel extends Model {

	public $recursive = -1;
	public $actsAs = array('Containable');

}
