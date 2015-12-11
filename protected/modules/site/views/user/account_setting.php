<?php
/* @var $this DefaultController */
/* @var $model User */
/* @var $user_profile UserProfile */
/* @var $user_security_question SecurityQuestion */

$this->title = 'Account Setting';
$themeUrl = $this->themeUrl;
$user_profile = $model->userProf;
$user_security_question = $model->security_question;
$user_paypals = $model->userPaypals;
?>
<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div class="forms-cont account-settingform">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> Personal information  
                        <span>
                            <a href="#" data-target="#edit_personal_information" data-toggle="modal" data-dismiss="#edit_personal_information"> 
                                <i class="fa fa-pencil"></i> edit 
                            </a>
                        </span>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <label> First Name </label>
                            <p> <?php echo ($user_profile->prof_firstname) ? $user_profile->prof_firstname : '-'; ?> </p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <label> Last Name </label>
                            <p>  <?php echo ($user_profile->prof_lastname) ? $user_profile->prof_lastname : '-'; ?> </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 age-verify ">
                            <?php
                            $cancel_email = "";
                            if ($user_profile->receive_email_notify)
                                $cancel_email = 'checked';
                            ?>
                            <input name="" type="checkbox" value="" <?php echo $cancel_email; ?> disabled>  
                            Receive notifications to email
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <label>  Address </label>
                            <p> <?php echo ($user_profile->prof_address) ? $user_profile->prof_address : '-'; ?> </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <label>  Phone Number </label>
                            <p> <?php echo ($user_profile->prof_phone) ? $user_profile->prof_phone : '-'; ?> </p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <label>  Website Link </label>
                            <p> <?php echo ($user_profile->prof_website) ? $user_profile->prof_website : '-'; ?> </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <label>  Default Country </label>
                            <p> <?php echo $model->userCountry->country_name; ?> </p>
                        </div>
                    </div>

                    <div class="form-group">  
                        <!--Email Address Section-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> Email Address
                            <span>
                                <a href="#" data-target="#edit_email_address" data-toggle="modal" data-dismiss="#edit_email_address"> 
                                    <i class="fa fa-pencil"></i> edit 
                                </a>
                            </span>
                        </div>
                        <div class="form-group">  
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 age-verify ">
                                <?php echo $model->email; ?>
                            </div>
                        </div>
                        <p>&nbsp;</p>

                        <!--Change Password Section-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading">
                            Change password  
                            <span>
                                <a href="#" data-target="#edit_change_password" data-toggle="modal" data-dismiss="#edit_change_password"> 
                                    <i class="fa fa-pencil"></i> edit 
                                </a>
                            </span>
                        </div>
                        <p>&nbsp;</p>

                        <!--Security Question Section-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading">
                            Security Question  
                            <span>
                                <a href="#" data-target="#edit_security_question" data-toggle="modal" data-dismiss="#edit_security_question"> 
                                    <i class="fa fa-pencil"></i> edit 
                                </a>
                            </span>
                        </div>
                        <?php if (!empty($user_security_question)) { ?>
                            <div class="form-group">  
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 age-verify ">
                                    <b> Question : </b> 
                                    <?php echo $user_security_question->question ?>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 age-verify ">
                                    <b> Answer : </b> <?php echo $model->answer; ?>
                                </div>
                            </div>
                        <?php } ?>
                        <p>&nbsp;</p>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading">
                            Paypal Setting 
                        </div>

                        
                        <div class="form-group">  
                            <?php if(!empty($user_paypals)){ ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 age-verify ">
                                <?php foreach($user_paypals as $user_paypal){ ?>
                                <p>  
                                    <?php echo $user_paypal->paypal_address; ?>  
                                    <?php echo CHtml::link('<i class="fa fa-trash"></i>', array('/site/user/paypaldelete', 'paypal_id' => $user_paypal->paypal_id), array('confirm' => 'Are you sure?'))?>
                                </p>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <p>&nbsp;</p>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> 
                                <?php echo CHtml::link('<i class="fa fa-user-times"></i> Deactivate My Account', array('/site/user/accountdeactivate'), array('confirm' => 'Are you sure to deactivate your account?')); ?>
                            </div>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(empty($user_profile))
    $user_profile = new UserProfile;

$this->renderPartial('_personal_information_form', compact('model', 'user_profile'));
$this->renderPartial('_email_address_form', compact('model'));
$this->renderPartial('_change_password_form', compact('model'));
$this->renderPartial('_security_question_form', compact('model'));
?>