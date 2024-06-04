<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Organizer $model */

$this->title = 'Create Organizer';
$this->params['breadcrumbs'][] = ['label' => 'Organizers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organizer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
