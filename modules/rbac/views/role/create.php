<?php

use yii\helpers\Html;
use app\themes\adminlte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var app\modules\rbac\models\AuthItemModel $model
 */

$this->title = Yii::t('app', 'Create record');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Roles'),
    'url'   => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="auth-item-create">

    <p>
        <?php echo Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-info']); ?>
    </p>

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'bodyOptions' => [
                        'class' => 'table-responsive'
                    ],
                ]
            ); ?>
            <?php echo $this->render('_form', [
                'model' => $model,
            ]);
            ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
