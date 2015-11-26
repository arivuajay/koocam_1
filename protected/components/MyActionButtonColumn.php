<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('booster.widgets.TbButtonColumn');

/**
 * Description of MyActionButtonColumn
 *
 * @author Admin
 */
class MyActionButtonColumn extends TbButtonColumn {

    protected function initDefaultButtons() {
        $my_buttons = array(
            'view' => array(
                'options' => array('class' => 'btn btn-primary btn-xs')
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-default btn-xs')
            ),
            'delete' => array(
                'options' => array('class' => 'btn btn-danger btn-xs')
            ),
        );
        $this->buttons = array_merge($this->buttons, $my_buttons);
        parent::initDefaultButtons();
    }

}
