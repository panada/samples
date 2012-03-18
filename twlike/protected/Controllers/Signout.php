<?php
namespace Controllers;
use Resources;

class Signout extends Resources\Controller {
    
    public function __construct(){
        
        parent::__construct();
        
        $this->session = new Resources\Session;
    }
    
    public function index(){
        
        $this->session->destroy();
        $this->redirect();
    }
}