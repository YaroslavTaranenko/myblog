<?php
$this->assign('title', 'Edit user');
$this->layout = 'admin';

echo $this->Form->create($user, ['enctype' => 'multipart/form-data', 'url'=>['controller' => 'Admin', 'action' => 'users', 'edit', $user->id], 'class'=>'edit-form']);
?>
<div class="avatar">
    <img src="/img/users/<?=$user->id?>/<?=$user->foto?>">
</div>
<?php
echo $this->Form->input('foto', ['type'=>'file', 'label'=>'Upload file', 'class'=>'upload_btn']);
echo $this->Form->hidden('id', ['value'=>$user->id]);
echo $this->Form->input('first_name', ['label'=>'First name']);
echo $this->Form->input('last_name', ['label'=>'Last name']);
echo $this->Form->input('email', ['label'=>'Email']);
echo $this->Form->input('change_password', ['label'=>'Password', 'type'=>'password']);
echo $this->Form->input('repeat_password', ['label'=>'Repeat password', 'type'=>'password']);
echo $this->Form->input('phone', ['label'=>'Phone']);
echo $this->Form->input('skype', ['label'=>'Skype']);
echo $this->Form->input('facebook', ['label'=>'Facebook']);
//echo $this->Form->input('foto', ['label'=>'Foto']);

echo $this->Form->input('roles_id', ['label'=>'Role']);
echo $this->Form->submit('Edit', ['class' => 'btn']);
echo $this->Form->end();
?>
