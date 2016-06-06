<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    public $translation_ru;
    public $translation_en;
    public $translation_kz;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['message', 'translation_en', 'translation_ru', 'translation_kz'], 'string'],
            [['category'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('admin', 'ID'),
            'category'       => Yii::t('admin', 'Category'),
            'message'        => Yii::t('admin', 'Message'),
            'translation_ru' => Yii::t('admin', 'RU'),
            'translation_kz' => Yii::t('admin', 'KZ'),
            'translation_en' => Yii::t('admin', 'EN'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function prepareTranslation()
    {
        foreach ($this->messages as $item)
        {
            $this->{'translation_' . $item->language} = $item->translation;
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function addTranslation()
    {
        return Message::addTranslate($this->id, [
            'ru' => $this->translation_ru,
            'kz' => $this->translation_kz,
            'en' => $this->translation_en
        ]);
    }
}
