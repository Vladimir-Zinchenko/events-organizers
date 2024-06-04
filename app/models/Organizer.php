<?php

namespace app\models;

use Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 *
 * @property Event[] $events
 */
class Organizer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'organizer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
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
}
