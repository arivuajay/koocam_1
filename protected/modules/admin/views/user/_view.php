
<?php

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'htmlOptions' => array('class' => 'table table-striped table-bordered'),
    'nullDisplay' => '-',
    'attributes' => array(
        'username',
        'email',
        array(
            'name' => 'Profile Picture',
            'type' => 'raw',
            'value' => $model->getProfilethumb(array('class' => '', 'style' => 'height: 80px;'))
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => $model->status == 1 ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
        ),
        'userProf.prof_firstname',
        'userProf.prof_lastname',
        'userProf.prof_tag',
        'userProf.prof_address',
        'userProf.prof_phone',
        'userProf.prof_skype',
        'userProf.prof_website',
        'userProf.prof_about',
        array(
            'name' => 'Expenses ($)',
            'type' => 'raw',
            'value' => (float) Transaction::myTotalExpense($model->user_id)
        ),
        array(
            'name' => 'Revenues ($)',
            'type' => 'raw',
            'value' => (float) Transaction::myTotalRevenue($model->user_id)
        ),
        array(
            'name' => 'Balance ($)',
            'type' => 'raw',
            'value' => (float) Transaction::myCurrentBalance($model->user_id)
        ),
        'created_at',
    ),
));
?>