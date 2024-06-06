<?php

namespace app\services;

use app\models\Event;
use DateTime;
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
     * @param Event      $event
     * @param array|null $data
     *
     * @return bool
     *
     * @throws \yii\db\Exception
     */
    public function save(Event $event, ?array $data = []): bool
    {
        if (isset($data['date'])) {
            $data['date'] = (new DateTime($data['date']))->format('Y-m-d');
        }

        if ($data) {
            $event->setAttributes($data);
        }

        return $event->save();
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