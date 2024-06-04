<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Class SiteController
 */
class SiteController extends Controller
{

    /**
     * @return array[]
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
