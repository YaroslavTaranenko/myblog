<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

if (!Configure::read('debug')):
    throw new NotFoundException();
endif;

$cakeDescription = 'My Blog Administrator';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title');?>
        </title>
        <?=$this->Html->css('admin');?>
        <?=$this->Html->css('font-awesome.css');?>
        <?=$this->Html->css('messages.css');?>
        
    </head>
    <body>
        <main>
            <header>
                <?php if(isset($current_user)):?>
                 <div class="user">
                    <div class="avatar"><?=$this->Html->image('/img/users/'.$current_user['id'].'/'.$current_user['foto']);?></div>
                    <div class="name"> <?=$current_user['first_name']. ' ' .$current_user['last_name']?></div>
                </div>                
                <?php endif;?>
            </header>
            <section id="panel">
               
                <ul class="admin-menu">
                    <li><a href="/admin/users/view">Users</a></li>
                    <li><a href="/admin/roles/view">Roles</a></li>
                    <li><a href="/admin/articles/view">Articles</a></li>
                </ul>
            </section>
            <section id="content">
                <?=$this->Flash->render();?>
                <?=$this->fetch('content');?>
            </section>
        </main>
    </body>
</html>
