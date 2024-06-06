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
        $organizer = $this->findById($id);

        if ($organizer === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $organizer;
    }

    /**
     * @param Organizer  $organizer
     * @param array|null $data
     *
     * @return bool
     *
     * @throws \yii\db\Exception
     */
    public function save(Organizer $organizer, ?array $data = []): bool
    {
        if ($data) {
            $organizer->setAttributes($data);
        }

        return $organizer->save();
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
        $organizer = $this->findOrFail($id);

        return $organizer->delete();
    }
}