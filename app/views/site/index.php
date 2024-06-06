<?php

use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Events Application';

$dataProvider->pagination->pageSize = 5;
?>
<div class="site-index">
    <div class="body-content">

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_event',
        ])?>

    </div>
</div>
