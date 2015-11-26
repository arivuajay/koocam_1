<div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Edit Profile </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-profile-form',
                        'action' => $this->createUrl('/site/user/profileupdate'),
                        'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => 'multipart/form-data'),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <?php echo $form->labelEx($user_profile, 'prof_firstname'); ?>
                            <?php echo $form->textField($user_profile, 'prof_firstname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                            <?php echo $form->error($user_profile, 'prof_firstname'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <?php echo $form->labelEx($user_profile, 'prof_lastname'); ?>
                            <?php echo $form->textField($user_profile, 'prof_lastname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>

                            <?php echo $form->error($user_profile, 'prof_lastname'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <?php echo $form->labelEx($user_profile, 'prof_tag'); ?>
                            <?php echo $form->textField($user_profile, 'prof_tag', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                            <?php echo $form->error($user_profile, 'prof_tag'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($user_profile, 'prof_about'); ?>
                            <?php echo $form->textArea($user_profile, 'prof_about', array('class' => 'form-control', 'rows' => 3, 'cols' => 50)); ?>
                            <?php echo $form->error($user_profile, 'prof_about'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php
                            $lang_array = $model->getLanguages('array');

                            $selected = array();
                            foreach ($lang_array as $value) {
                                $selected[$value] = array('selected' => 'selected');
                            }
                            ?>
                            <?php echo $form->labelEx($user_profile, 'prof_languages'); ?>
                            <?php echo $form->dropDownList($user_profile, 'prof_languages', Language::getLanguagesList(), array('class' => 'selectpicker', 'prompt' => '', 'multiple' => true, 'options' => $selected)); ?> 
                            <?php echo $form->error($user_profile, 'prof_languages'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($user_profile, 'prof_interests'); ?>
                            <?php echo $form->textArea($user_profile, 'prof_interests', array('class' => 'form-control', 'rows' => 3, 'cols' => 50)); ?>
                            <?php echo $form->error($user_profile, 'prof_interests'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo $form->labelEx($user_profile, 'prof_picture'); ?>
                            <span class="btn btn-default btn-file">
                                <i class="fa fa-upload"></i>  <?php echo $form->labelEx($user_profile, 'prof_picture'); ?>
                                <?php echo $form->fileField($user_profile, 'prof_picture'); ?>
                            </span>
                            <?php echo $form->error($user_profile, 'prof_picture'); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo $form->labelEx($user_profile, 'country_id'); ?>
                            <?php echo $form->dropDownList($user_profile, 'country_id', Country::getCountryList(), array('class' => 'selectpicker', 'prompt' => '')); ?> 
                            <?php echo $form->error($user_profile, 'country_id'); ?>
                        </div>
                    </div>

                    <!-- Below Divs are Hidden-->
                    <div class = "form-group form-control-material static hide">
                        <?php echo $form->textField($user_profile, 'prof_cover_photo', array('class' => 'form-control', 'size' => 60, 'maxlength' => 500)); ?>
                        <?php echo $form->labelEx($user_profile, 'prof_cover_photo'); ?>
                        <?php echo $form->error($user_profile, 'prof_cover_photo'); ?>
                    </div>
                    <div class = "form-group form-control-material static hide">
                        <?php echo $form->labelEx($user_profile, 'prof_address'); ?>
                        <?php echo $form->textArea($user_profile, 'prof_address', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($user_profile, 'prof_address'); ?>
                    </div>
                    <div class = "form-group form-control-material static hide">
                        <?php echo $form->labelEx($user_profile, 'prof_phone'); ?>
                        <?php echo $form->textField($user_profile, 'prof_phone', array('class' => 'form-control', 'size' => 30, 'maxlength' => 30)); ?>
                        <?php echo $form->error($user_profile, 'prof_phone'); ?>
                    </div>
                    <div class = "form-group form-control-material static hide">
                        <?php echo $form->labelEx($user_profile, 'prof_skype'); ?>
                        <?php echo $form->textField($user_profile, 'prof_skype', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                        <?php echo $form->error($user_profile, 'prof_skype'); ?>
                    </div>
                    <div class = "form-group form-control-material static hide">
                        <?php echo $form->labelEx($user_profile, 'prof_website'); ?>
                        <?php echo $form->textField($user_profile, 'prof_website', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                        <?php echo $form->error($user_profile, 'prof_website'); ?>
                    </div>
                    <!-- Above Divs are Hidden-->

                    <div class="form-group">
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
                            <?php echo CHtml::submitButton($user_profile->isNewRecord ? 'Create' : 'Save', array('class' => $user_profile->isNewRecord ? 'btn btn-default btn-lg explorebtn form-btn' : 'btn btn-default btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>