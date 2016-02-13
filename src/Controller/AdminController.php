<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AdminController extends AppController{
    public function display(){
        
    }
    
    public function users($mode = 'view', $id = null){
        $this->loadModel('Users');
        switch ($mode){
            case 'view': $users = $this->Users->find('all');
                $this->set(compact('users'));
                $this->render('users');
                break;
        }
        
        
    }
}