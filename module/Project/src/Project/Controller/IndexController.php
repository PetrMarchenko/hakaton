<?php

namespace Project\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class IndexController extends AbstractActionController
{
    public function init()
    {
        $this->layout()->setVariable('rout', 'project/index');
    }

    protected $projectsTable;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        return new ViewModel();
    }

    public function getAdapter() {
        $sm = $this->getServiceLocator();
        return $sm->get('ZendDbAdapterAdapter');
    }

    /** @return \Project\Model\Table\ProjectsTable */
    public function getProjectsTable()
    {
        if (!$this->projectsTable) {
            $sm = $this->getServiceLocator();
            $this->projectsTable = $sm->get('ProjectsTable');
        }
        return $this->projectsTable;
    }

    public function getMailConfig() {
        $config = $this->getServiceLocator()->get('Config');
        return $config['mail'];
    }
}