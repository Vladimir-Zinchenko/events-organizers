<?php

namespace app\models;

use Exception;
use voskobovich\linker\LinkerBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Event
 *
 * @property int $id
 * @property string $title
 * @property string $date
 * @property string|null $description
 *
 * @property Organizer[] $organizers
 *
 * @property int[] $organizer_ids
 */
class Event extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{event}}';
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
                    'organizer_ids' => 'organizers',
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
            [['title', 'date'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string', 'max' => 2000],
            [['title'], 'string', 'max' => 255],
            [['organizer_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'description' => 'Description',
            'organizers' => 'Organizers',
            'organizer_ids' => 'Organizers',
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

    /**
     * @param Organizer[] $organizers
     *
     * @return void
     */
    public function setOrganizers(array $organizers): void
    {
        $this->organizer_ids = ArrayHelper::getColumn($organizers, 'id');
    }
}
