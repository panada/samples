<?php
namespace Controllers;
use
    Resources,
    Models;

class Users extends Resources\Controller {
    
    public function __construct(){
        
        parent::__construct();
        
	$this->session	    = new Resources\Session;
        $this->users	    = new Models\Users;
	$this->posts	    = new Models\Posts;
        $this->pagination   = new Resources\Pagination;
    }
    
    public function index($page = 1){
        
        if( $page < 1)
            $page = 1;
            
        $args['page'] = $page;
        $args['limit'] = 10;
        
        $this->pagination->limit    = $args['limit'];
        $this->pagination->base     = $this->location('users/index/%#%');
	$this->pagination->total    = $this->users->getTotal();
	$this->pagination->current  = $page;
        $data['users']              = $this->users->getAll( $args );
        $data['pageLinks']          = $this->pagination->getUrl();
	$data['totalPost']	    = $this->posts->getTotal();
	$data['totalUser']	    = $this->users->getTotal();
	$data['signature']	    = $this->libraries->requestSignature()->generate();
        
        $this->output('users', $data);
    }
}