<?php 
use Cake\Core\Configure;
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Reset your password</h1>
            <div class="account-wall">
                <?= $this->Html->link(
                    'GintonicCMS.logo.png', 
                    [
                        "class" => "img-responsive profile-img site-logo",
                        "alt" => 'GintonicCMS'
                    ]), 
                    '/', 
                    ['escape'=>false]
                );?>
                <?= $this->Form->create('Users', [
                    'class' => 'form-signin',
                    'url'=>[
                        'controller'=>'Users',
                        'action'=>'reset_password',
                        $userId,
                        $token
                    ], 
                    'id' => 'UserLoginForm',
                    'novalidate' => 'novalidate'
                ]);?>
                <?= $this->Flash->render();
                <?= $this->Form->input('new_password', [
                    'label' => false,
                    'type'=>'password',
                    'class' => 'form-control',
                    'placeholder' => 'New Password',
                    'required',
                    'autofocus',
                    'style'=>['margin-bottom:0px;']
                ]);?>
                <?= $this->Form->input('confirm_password', [
                    'label' => false,
                    'type'=>'password',
                    'class' => 'form-control',
                    'placeholder' => 'Confirm Password',
                    'required',
                    'autofocus',
                    'style'=>['margin-bottom:0px;','oninput'=>'checkPassword(this)']
                ]);?>
                <?= $this->Form->submit(
                    __('Reset Password'),
                    ['class' => 'btn btn-lg btn-primary btn-block']
                ); ?>
                <span class="clearfix"></span>
                <?= $this->Form->end();?>
            </div>
            <?= $this->Html->link(
                __('Already have an account?'),
                ['controller' => 'Users', 'action' => 'signin'], 
                ['escape' => false,'class'=>'text-center new-account']
            ); ?>
        </div>
    </div>
</div>
<script language='javascript' type='text/javascript'>
function checkPassword(input) {
	if (input.value != document.getElementById('new_password').value) {
		input.setCustomValidity('New Password and Confirm Password must be same');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
   }
}
</script>
