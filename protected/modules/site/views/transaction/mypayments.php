<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo CHtml::link('Withdraw', 'javascript:void(0)', array('class' => '', 'data-toggle' => "modal", 'data-target' => "#withdraw-modal"));
$this->renderPartial('_cash_withdraw', compact('model'));
?>