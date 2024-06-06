<?php

namespace app\models;

use Exception;
use voskobovich\linker\LinkerBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Organizer
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 *
 * @property Event[] $events
 *
 * @property int[] $event_ids
 */
class Organizer extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{organizer}}';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'event_ids' => 'events',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['event_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'events' => 'Events',
            'event_ids' => 'Events',
        ];
    }

    /**
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function getEvents(): ActiveQuery
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])->viaTable('event_organizer', ['organizer_id' => 'id']);
    }

    /**
     * @param Event[] $events
     *
     * @return void
     */
    public function setEvents(array $events): void
    {
        $this->event_ids = ArrayHelper::getColumn($events, 'id');
    }
}
