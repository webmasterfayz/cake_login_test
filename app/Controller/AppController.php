<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	// Components
	public $components = array(
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login',
				),
			'authError' => 'Welcome, please login',
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'email', 'password' => 'password')
					)
				),
			'loginRedirect' => array(
				'controller' => 'users',
				'action' => 'index'
			)
			),
		'RequestHandler',
		'Session'
	);

	/**
		Default filter method.
	 */
	public function beforeFilter() {

		// Setup the details about currunt controller
		$this->currentControllerName = $this->name;
		$this->currentActionName = $this->params['action'];

		// Current user details
		// null, if not logged in.
		$this->currentUserId = $this->Auth->user('id');
		$this->currentUserRoleId = $this->Auth->user('role_id');
		$this->currentUserName = $this->Auth->user('name');
		$this->currentUserEmail = $this->Auth->user('email');

		// Log every request
		$logLine = 'IP: '.$this->request->clientIp();
		$logLine .= ', User ID: '.$this->currentUserId;
		$logLine .= ', User: '.$this->currentUserName;
		$logLine .= ', Controller: '.strtoupper($this->currentControllerName);
		$logLine .= ', Action: '.strtoupper($this->currentActionName);
		$logLine .= ', URL: '.Router::url( $this->here, true );
		$this->log($logLine, 'activity');


		// Set these for all the views
		$this->set('currentUserId', $this->currentUserId);
		$this->set('currentUserRoleId', $this->currentUserRoleId);
		$this->set('currentUserName', $this->currentUserName);
		$this->set('currentUserEmail', $this->currentUserEmail);
	}


}
