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
        $this->loadModel('Roles');
        switch ($mode){
            case 'view': $users = $this->Users->find('all');
                $this->set(compact('users'));
                $this->render('users');
                break;
            case 'add': 
                $user = $this->Users->newEntity();
                if($this->request->is('post')){
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if($this->Users->save($user)){
                        $this->Flash->success(__('User successfully added'));
                        return $this->redirect(['action' => 'view']);
                    }  else {
                        $this->Flash->error(__('An Error occured'));
                    }
                }
                $roles = $this->Roles->find('list');
                $this->set(compact('user', 'roles'));
                $this->set('_serialize', ['user', 'roles']);
                $this->render('userAdd');
                break;
        }
        
        
    }
}