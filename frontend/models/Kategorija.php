<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kategorija".
 *
 * @property integer $id
 * @property string $naziv
 *
 * @property KategorijaArtikal[] $kategorijaArtikals
 */
class Kategorija extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategorija';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['naziv','safe'],
            [['naziv'], 'string', 'max' => 55],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'naziv' => 'Kategorija',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategorijaArtikals()
    {
        return $this->hasMany(KategorijaArtikal::className(), ['id_kategorija' => 'id']);
    }
    public function getKategorijaByArtikal($idArtikla)
    {
        return $query = Yii::$app->db->createCommand(
            'SELECT k.naziv,k.id FROM kategorija k, kategorija_artikal ka, artikal a
              WHERE k.id = ka.id_kategorija AND a.id = ka.id_aritkal and a.id = :idArtikla')
            ->bindValue(':idArtikla', $idArtikla)
            ->queryAll();
    }
}
