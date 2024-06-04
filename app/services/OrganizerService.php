<?php

namespace app\services;

use app\models\Organizer;
use Exception;
use Throwable;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class OrganizerService
 */
class OrganizerService
{
    /**
     * @return ActiveDataProvider
     */
    public function list(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Organizer::find(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Organizer|null
     */
    public function findById(int $id): ?Organizer
    {
        return Organizer::findOne(['id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return Organizer
     *
     * @throws NotFoundHttpException
     */
    public function findOrFail(int $id): Organizer
    {
        $Organizer = $this->findById($id);

        if ($Organizer === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $Organizer;
    }

    /**
     * @param Organizer $Organizer
     * @param array $data
     *
     * @return bool
     *
     * @throws Exception
     */
    public function saveOrUpdate(Organizer $Organizer, array $data): bool
    {
        return $Organizer->load($data) && $Organizer->save();
    }

    /**
     * @param int $id
     *
     * @return false|int
     *
     * @throws Exception|Throwable
     */
    public function deleteById(int $id): false|int
    {
        $Organizer = $this->findOrFail($id);

        return $Organizer->delete();
    }
}