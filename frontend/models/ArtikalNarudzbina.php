<?php

namespace app\models;

use Yii;
use frontend\models\Artikal;

/**
 * This is the model class for table "artikal_narudzbina".
 *
 * @property integer $id
 * @property integer $artikal_id
 * @property integer $narudzbina_id
 *
 * @property Narudzbina $narudzbina
 * @property Artikal $artikal
 */
class ArtikalNarudzbina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artikal_narudzbina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['artikal_id', 'narudzbina_id'], 'integer'],
            [['narudzbina_id'], 'required'],
            [['narudzbina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Narudzbina::className(), 'targetAttribute' => ['narudzbina_id' => 'id']],
            [['artikal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artikal::className(), 'targetAttribute' => ['artikal_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'artikal_id' => 'Artikal ID',
            'narudzbina_id' => 'Narudzbina ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNarudzbina()
    {
        return $this->hasOne(Narudzbina::className(), ['id' => 'narudzbina_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtikal()
    {
        return $this->hasOne(Artikal::className(), ['id' => 'artikal_id']);
    }
}
