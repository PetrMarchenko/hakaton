<?php
/**
 *
 */

namespace Auth\Model\AuthService;

use User\Model\User;

class Auth
{
    protected $authenticationService;

    public function __construct($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    public function login($login, $password, $re = 0){

        if ($this->authenticationService->hasIdentity()){
            return true;
        }

        if (null == $login) {
            return false;
        }

        $authAdapter = $this->authenticationService->getAdapter();
        $authAdapter->setIdentity($login);
        $authAdapter->setCredential($password);
        $result = $this->authenticationService->authenticate();

        if (!$result->isValid()) {
            return false;
        }
        $storage = $this->authenticationService->getStorage();
        $storage->setRememberMe($re);
        $storage->write($this->authenticationService->getAdapter()->getResultRowObject());
        return true;

    }

    public function checkRememberMe($name = null) {
        if (!$this->getAuthenticationService()->hasIdentity()){
            if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
                $this->login($_COOKIE['login'], $_COOKIE['password']);
            }
        }
    }

    public function logout(){
        if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
            setcookie("login", null);
            setcookie("password", null);
        }
        $this->authenticationService->clearIdentity();
    }

    public function getAuthenticationService(){
        return $this->authenticationService;
    }

    public function getStorage(){
        $this->checkRememberMe('getStorage');
        return $this->authenticationService->getStorage()->read();
    }

    public function setStorage($users){
        return $this->authenticationService->getStorage()->write($users);
    }


    public function getUserRole(){
        $this->checkRememberMe('getUserRole');
        if ($this->getAuthenticationService()->hasIdentity()){
            return $this->getStorage()->role_id;
        } else {
            return User::VISITOR;
        }

    }

    public function getUserName(){
        $this->checkRememberMe('getUserName');
        if ($this->getAuthenticationService()->hasIdentity()){
            return $this->getStorage()->name;
        } else {
            return null;
        }

    }

    public function getUserId(){
        $this->checkRememberMe('getUserId');
        if ($this->getAuthenticationService()->hasIdentity()){
            return $this->getStorage()->id;
        } else {
            return false;
        }

    }
}