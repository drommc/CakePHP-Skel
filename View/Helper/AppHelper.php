<?php
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 */
class AppHelper extends Helper {

/**
* Overrides the Html->link method to allow you to generate a "TODO" link for
* links which does not have an url yet
*
* A "TODO" class is added to the link, and a js confirm box is displayed allowing
* you to be redirected to the ticket if wanted
*
* @param string $text Link text
* @param string $ticket Ticket number
* @param array $options
*/
	public function todo($text, $ticket = null, $options = array()) {
		if (Configure::read('debug') == 0) {
			$this->log('***** HtmlHelper::todo called');
			return $text;
		} else {
			if (!is_a($this, 'HtmlHelper')) {
				trigger_error('The "todo" helper method must be used for the Html helper only', E_USER_NOTICE);
				return '';
			}
			$url = is_null($ticket) ? '#' : 'http://projets.occi-tech.com/issues/' . $ticket;
			$message = "Cette fonctionnalité n\'a pas encore été implementée.";
			if (!is_null($ticket)) {
				$message .= '\nElle est liée au ticket #' . $ticket . '\n\nVoulez vous être redirigé vers le ticket ?';
				$options['target'] = 'ticket';
			}
			$options['onclick'] = 'return confirm(\'' . $message . '\');';
			$options['class'] = empty($options['class']) ? 'todo' : $options['class'] . ' todo';
			return $this->link($text, $url, $options);
		}
	}

}
