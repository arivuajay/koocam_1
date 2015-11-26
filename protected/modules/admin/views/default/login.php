<?php
$this->title = 'Sign In';
$this->breadcrumbs = array(
    $this->title
);
?>
<div id="content">
    <div class="container-fluid">
        <div class="lock-container">
            <div class="panel panel-default text-center paper-shadow" data-z="0.5">
                <h1 class="text-display-1 text-center margin-bottom-none"><?php echo CHtml::encode($this->title) ?></h1>
                <?php echo CHtml::image("{$this->themeUrl}/img/people/110/avatar5.png", 'Image', array('class' => 'img-circle width-80')) ?>
                <?php if (isset($this->flashMessages)): ?>
                        <?php foreach ($this->flashMessages as $key => $message) { ?>
                            <div class="alert alert-<?php echo $key; ?> fade in">
                                <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                    <?php endif ?>
                <div class="panel-body">
                    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form')); ?>
                    
                    <div class="form-group">
                        <div class="form-control-material static required">
                            <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control', 'placeholder' => "Username")); ?>
                            <?php echo $form->labelEx($model, 'username') ?>
                        </div>
                            <?php echo $form->error($model, 'username') ?>
                    </div>
                    <div class="form-group">
                        <div class="form-control-material static required">
                            <?php echo $form->passwordField($model, 'password', array('autofocus', 'class' => 'form-control', 'placeholder' => "Enter Password")); ?>
                            <?php echo $form->labelEx($model, 'password') ?>
                        </div>
                            <?php echo $form->error($model, 'password') ?>
                    </div>
                    <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check', 'checked' => 'checked')); ?>
                    <?php echo ' Remember Me'; ?><br /><br />
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary', 'name' => 'sign_in')) ?><br /><br />
                    <!--<a href="website-student-dashboard.html" class="btn btn-primary">Login <i class="fa fa-fw fa-unlock-alt"></i></a>-->
                    <p><?php // echo CHtml::link('I forgot my password', array('/site/user/forgot')) ?></p>
                    <!--<a href="sign-up.html" class="link-text-color">Create account</a>-->
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>