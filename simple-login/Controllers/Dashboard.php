<?php
namespace Controllers;
use Resources;

class Dashboard extends Resources\Controller {
    
    public function __construct(){
        
        parent::__construct();
        
        $this->session = new Resources\Session;
    }
    
    public function index(){
        
        if( ! $this->session->getValue('isLogin') )
            $this->redirect('home');
        
        $this->output('protected_page', array('username' => $this->session->getValue('username')) );
    }
    
    public function logout(){
        
        $this->session->destroy();
        $this->redirect();
    }
}