<?php

namespace app\models;

use Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $date
 * @property string|null $description
 *
 * @property Organizer[] $organizers
 */
class Event extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'date'], 'required'],
            [['date'], 'safe'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'description' => 'Description',
        ];
    }

    /**
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function getOrganizers(): ActiveQuery
    {
        return $this->hasMany(Organizer::class, ['id' => 'organizer_id'])->viaTable('event_organizer', ['event_id' => 'id']);
    }
}
