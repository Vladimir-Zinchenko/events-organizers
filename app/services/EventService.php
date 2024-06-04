<?php

namespace app\services;

use app\models\Event;
use Exception;
use Throwable;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class EventService
 */
class EventService
{
    /**
     * @return ActiveDataProvider
     */
    public function list(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Event::find(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Event|null
     */
    public function findById(int $id): ?Event
    {
        return Event::findOne(['id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return Event
     *
     * @throws NotFoundHttpException
     */
    public function findOrFail(int $id): Event
    {
        $event = $this->findById($id);

        if ($event === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $event;
    }

    /**
     * @param Event $event
     * @param array $data
     *
     * @return bool
     *
     * @throws Exception
     */
    public function saveOrUpdate(Event $event, array $data): bool
    {
        return $event->load($data) && $event->save();
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
        $event = $this->findOrFail($id);

        return $event->delete();
    }
}