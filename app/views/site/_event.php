<?php

use app\models\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/** @var Event $model */
?>

<div class="event">
    <h2><?= Html::encode($model->title) ?></h2>

    <p><i><?= Yii::$app->formatter->asDate($model->date)?></i></p>

    <p>
        <?= HtmlPurifier::process($model->description) ?>
    </p>

    <?php if ($model->organizers) : ?>
    <p>
        <b>Organizers:</b> <?= implode(', ', ArrayHelper::getColumn($model->organizers, 'name'))?>
    </p>
    <?php endif;; ?>
</div>