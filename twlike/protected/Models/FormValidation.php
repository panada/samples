<?php
namespace Models;
use
    Resources;

class FormValidation extends Resources\Validation {
    
    private $rule = array();
    
    public function __construct()
    {
        parent::__construct();
        
        $this->session      = new Resources\Session;
        $this->request      = new Resources\Request;
        $this->user         = new Users;
        $this->connections  = new Connections;
    }
    
    public function setRules()
    {
        return $this->rule;
    }
    
    public function validateValues($rule)
    {
        $this->rule = $this->myRules($rule);
        
        $validate = $this->validate();
        
        if($rule == 'signin'){
            
            if($validate) {
                return $this->validateSignin();
            }
        }
        
        if($rule == 'signup'){
            
            if($validate) {
                return $this->addUserAndSignin();
            }
        }
        
        return $validate;
    }
    
    private function myRules($key)
    {
        $rules = array(
            'signin' => array(
                'username' => array(
                    'rules' => array(
                        'required',
                        'min' => 3,
                        'regex' => '/^([-a-z0-9_-])+$/i',
                    ),
                    'label' => 'Username',
                    'filter' => array('trim', 'strtolower')
                ),
                'password' => array(
                    'rules' => array(
                        'required',
                        'min' => 3
                    ),
                    'label' => 'Password',
                )
            ),
            'post' => array(
                'post' => array(
                    'rules' => array(
                        'required',
                        'min' => 140,
                    ),
                    'label' => 'Post',
                    'filter' => array('trim', array($this, 'sanitizeString') )
                )
            )
        );
        
        $rules['signup']['rUsername'] = $rules['signin']['username'];
        $rules['signup']['rPassword'] = $rules['signin']['password'];
        $rules['signup']['rUsername']['rules'] = array_merge($rules['signup']['rUsername']['rules'], array('callback' => 'isUsernameExists'));
        
        return $rules[$key];
    }
    
    private function validateSignin()
    {
        $value = $this->value();
        
        $user = $this->user->getOne( array('username' => $value['username']) );
        
        if( $user && md5($value['password']) == $user->password ){
            
            $this->session->setValue(
                array(
                    'userId' => $user->userId,
                    'username' => $user->username
                )
            );
            
            if( ! $next = $this->request->get('next') )
                $next = 'home';
            
            return $next;
        }
        else {
            
            $this->setErrorMessage('username', 'Wrong username/password.');
            
            return false;
        }
    }
    
    public function isUsernameExists($field, $value, $label)
    {
        
        if( ! $user = $this->user->getOne( array('username' => $value) ) )
            return true;
        
        $this->setErrorMessage($field, 'Username already exists.');
            
        return false;
    }
    
    public function addUserAndSignin()
    {
        
        $value = $this->value();
        
        $userId = $this->user->insert( array('username' => $value['rUsername'], 'password' => md5($value['rPassword']) ) );
        
        $this->connections->addFollowing($userId, $userId);
        
        $this->session->setValue(
            array(
                'userId' => $userId,
                'username' => $value['rUsername']
            )
        );
        
        return 'home';
    }
    
    public function sanitizeString($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
}