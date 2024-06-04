<?php

namespace app\controllers\admin;

use app\models\Event;
use app\services\EventService;
use Exception;
use Throwable;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
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

    /**
     * @param int $id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->eventService->findOrFail($id),
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $model = new Event();

        if ($this->request->isPost && $this->eventService->saveOrUpdate($model, $this->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response|string
     *
     * @throws Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->eventService->findOrFail($id);

        if ($this->request->isPost && $this->eventService->saveOrUpdate($model, $this->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $this->eventService->deleteById($id);

        return $this->redirect(['index']);
    }
}
