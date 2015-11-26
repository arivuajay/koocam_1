<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import('booster.widgets.TbExtendedGridView');

/**
 * Description of MyActionButtonColumn
 *
 * @author Admin
 */
class MyExtendedGridView extends TbExtendedGridView {

    /**
     * ### .initColumns()
     *
     * Creates column objects and initializes them.
     */
    protected function initColumns() {
        foreach ($this->columns as $i => $column) {
            if (is_array($column) && isset($column['name']) && $column['name'] == 'status') {
                $this->columns[$i]['filter'] = CHtml::activeDropDownList($this->dataProvider->model, "status", array("1" => "Active", "0" => "In-Active"), array('class' => 'form-control', 'prompt' => 'All'));
            }
        }
        parent::initColumns();
    }

}
