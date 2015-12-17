<?php
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Auth\Model\Auth;
use Auth\Form\AuthForm;

class IndexController extends AbstractActionController
{
    public function indexAction()
    
	{
		
		 $viewModel = new ViewModel();
   		 
		$request = $this->getRequest();
		if (!$request->isPost()) {
			 $this->layout('layout/login');
			return  $viewModel ;
		}
		$user = $this->identity();
		$messages = null;
        $auth = new AuthenticationService();
    	if ($auth->hasIdentity()) {
			    return $this->redirect()->toRoute('home');
		}
		$request = $this->getRequest();
        if ($request->isPost()) {
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

				$authAdapter = new AuthAdapter($dbAdapter,
										   'users', // there is a method setTableName to do the same
										   'username', // there is a method setIdentityColumn to do the same
										   'password', // there is a method setCredentialColumn to do the same
										   'MD5(?) AND block = 1' // setCredentialTreatment(parametrized string) 'MD5(?)'
										  );
				$authAdapter
					->setIdentity($request->getPost('username'))
					->setCredential($request->getPost('password'));
				;
				if (trim($request->getPost('username'))=="" || trim($request->getPost('password')) =="" ) {
			      return $this->redirect()->toRoute('auth');
        	    }
			
				// or prepare in the globa.config.php and get it from there. Better to be in a module, so we can replace in another module.
				// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				// $sm->setService('Zend\Authentication\AuthenticationService', $auth); // You can set the service here but will be loaded only if this action called.
				$result = $auth->authenticate($authAdapter);			
				
				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// do stuff for nonexistent identity
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						// do stuff for invalid credential
						break;

					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));
						$time = 28800; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//						if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
						if ($request->getPost('username')) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe($time);
                            
						}
                        return $this->redirect()->toRoute('home');		
						break;

					default:
						// do stuff for other failure
						break;
				}				
				foreach ($result->getMessages() as $message) {
					$messages .= "$message\n"; 
				}			
			 
           
		}
		 $this->layout('layout/login');
		return  $viewModel ;
	}
	public function errorAction(){
	   	return new ViewModel();
	}
	public function logoutAction()
	{
	  $auth = new AuthenticationService();
		// or prepare in the globa.config.php and get it from there
		// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			
		
		$auth->clearIdentity();
//		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get the sessionmanager from storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
		return $this->redirect()->toRoute('auth');		
	}	
}