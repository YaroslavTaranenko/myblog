<?php
$this->layout = null;
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
            My blog: Login
        </title>
        <?=$this->Html->css('admin');?>
        
    </head>
    <body>
        <main class="login">
            <?php
            echo $this->Form->create('Users', ['url'=>['controller' => 'Admin', 'action' => 'login']]);
            echo $this->Form->input('email', ['label'=>'Email']);
            echo $this->Form->input('password', ['label'=>'Password']);
            echo $this->Form->submit('Sign in', ['class'=>'form_submit_btn']);
            echo $this->Form->end();
            ?>
        </main>
    </body>
</html>