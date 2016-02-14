<?php
$this->assign('title', 'Users');
$this->layout = 'admin';
?>
<?=$this->Flash->render();?>
<table>
    <thead>
        <tr>
            <th>ID</td>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user):?>
        <tr>
            <td><?=$user->id?></td>
            <td><?=$user->first_name?></td>
            <td><?=$user->last_name?></td>
            <td><?=$user->email?></td>
            <td>
            <?=$this->Html->link('edit', ['action'=>'users', 'edit', $user->id]);?>
            <?=$this->Html->link('delete', ['action'=>'users', 'delete', $user->id]);?>
            <?=$this->Html->link('view', ['action'=>'users', 'view', $user->id]);?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?= $this->Html->link('Add', ['controller'=>'Admin', 'action'=>'users', 'add'], ['class'=>'btn']);?>