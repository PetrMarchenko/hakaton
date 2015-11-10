<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

//use Users\Form\UsersForm;
use User\Model\User;

class IndexController extends AbstractActionController
{
    public function init()
    {
        $this->layout()->setVariable('rout', 'users/index');
    }

    protected $usersTable;

    public function indexAction()
    {
        /** @return \Auth\Model\AuthService\Auth */
        $auth = $this->getServiceLocator()->get('AuthService');
        return $this->redirect()->toRoute('home', array());

        return new ViewModel();
    }

    public function logoutAction()
    {
        /** @return \Auth\Model\AuthService\Auth */
        $auth = $this->getServiceLocator()->get('AuthService');
        $auth->logout();
        return $this->redirect()->toRoute('home', array());
    }

    public function loginAction()
    {
        /** @return \Auth\Model\AuthService\Auth */
        $auth = $this->getServiceLocator()->get('AuthService');
        $form = new LoginForm();
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $form->setData($request->getPost());

            if ($form->isValid()) {
            };
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function getAdapter() {
        $sm = $this->getServiceLocator();
        return $sm->get('ZendDbAdapterAdapter');
    }

    /** @return \User\Model\Table\UsersTable */
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('UsersTable');
        }
        return $this->usersTable;
    }

    public function getMailConfig() {
        $config = $this->getServiceLocator()->get('Config');
        return $config['mail'];
    }
}