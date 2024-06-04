<?php

namespace app\controllers\admin;

use app\models\Organizer;
use app\services\OrganizerService;
use Exception;
use Throwable;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Class OrganizerController
 */
class OrganizerController extends Controller
{
    private readonly OrganizerService $organizerService;

    /**
     * @param string       $id
     * @param Module       $module
     * @param array|null   $config
     * @param OrganizerService $organizerService
     */
    public function __construct(string $id, Module $module, ?array $config, OrganizerService $organizerService) {
        $this->organizerService = $organizerService;

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
            'dataProvider' => $this->organizerService->list(),
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
            'model' => $this->organizerService->findOrFail($id),
        ]);
    }

    /**
     * @return Response|string
     *
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Organizer();

        if ($this->request->isPost && $this->organizerService->saveOrUpdate($model, $this->request->post())) {
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
        $model = $this->organizerService->findOrFail($id);

        if ($this->request->isPost && $this->organizerService->saveOrUpdate($model, $this->request->post())) {
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
        $this->organizerService->deleteById($id);

        return $this->redirect(['index']);
    }
}
