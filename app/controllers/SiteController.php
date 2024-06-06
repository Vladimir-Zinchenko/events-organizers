<?php

namespace app\controllers;

use app\services\EventService;
use yii\base\Module;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Class SiteController
 */
class SiteController extends Controller
{
    private readonly EventService $eventService;

    /**
     * @param string       $id
     * @param Module       $module
     * @param array|null   $config
     * @param EventService $eventService
     */
    public function __construct(string $id, Module $module, ?array $config, EventService $eventService) {
        $this->eventService = $eventService;

        parent::__construct($id, $module, $config ?? []);
    }

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
        return $this->render('index', [
            'dataProvider' => $this->eventService->list(),
        ]);
    }
}
