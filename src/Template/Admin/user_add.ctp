<?php
$this->assign('title', 'Add user');
$this->layout = 'admin';

echo $this->Form->create($user, ['enctype' => 'multipart/form-data', 'url'=>['controller' => 'Admin', 'action' => 'users', 'add']]);
echo $this->Form->input('first_name', ['label'=>'First name']);
echo $this->Form->input('last_name', ['label'=>'Last name']);
echo $this->Form->input('email', ['label'=>'Email']);
echo $this->Form->input('password', ['label'=>'Password']);
echo $this->Form->input('phone', ['label'=>'Phone']);
echo $this->Form->input('skype', ['label'=>'Skype']);
echo $this->Form->input('facebook', ['label'=>'Facebook']);
//echo $this->Form->input('foto', ['label'=>'Foto']);
echo $this->Form->input('foto', ['type'=>'file', 'label'=>'Foto', 'class'=>'upload_btn']);
echo $this->Form->input('roles_id', ['label'=>'Role']);
echo $this->Form->submit('Add', ['class' => 'form_submit_btn']);
echo $this->Form->end();
?>
