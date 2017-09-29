<?php

namespace frontend\models;

use Yii;


/**
 * This is the model class for table "kategorija_artikal".
 *
 * @property integer $id
 * @property integer $id_aritkal
 * @property integer $id_kategorija
 *
 * @property Artikal $idAritkal
 * @property Kategorija $idKategorija
 */
class KategorijaArtikal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategorija_artikal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_aritkal', 'id_kategorija'], 'integer'],
            [['id_aritkal'], 'exist', 'skipOnError' => true, 'targetClass' => Artikal::className(), 'targetAttribute' => ['id_aritkal' => 'id']],
            [['id_kategorija'], 'exist', 'skipOnError' => true, 'targetClass' => Kategorija::className(), 'targetAttribute' => ['id_kategorija' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_aritkal' => 'Id Aritkal',
            'id_kategorija' => 'Id Kategorija',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAritkal()
    {
        return $this->hasOne(Artikal::className(), ['id' => 'id_aritkal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKategorija()
    {
        return $this->hasOne(Kategorija::className(), ['id' => 'id_kategorija']);
    }
    public function upisiKategorijuArtikla($idArtikla,$nazivKategorije)
    {
        $query = Yii::$app->db->createCommand('SELECT id_aritkal,id_kategorija
        FROM kategorija_artikal WHERE id_aritkal = :id_aritkal AND id_kategorija = :id_kategorija')
            ->bindValue(':id_aritkal',$idArtikla)
            ->bindValue(':id_kategorija',$nazivKategorije)
            ->queryOne();
        if ($query === false) {
            $this->id_kategorija = $nazivKategorije;
            $this->id_aritkal = $idArtikla;
            $this->save();
        } else {
                Yii::$app->session->setFlash('danger', 'Kategorija artikla vec postoji!');
        }
    }
    public function obrisiKategorijuArtikla($idArtikal,$idKategorija)
    {
        if ($this->validate()) {
            Yii::$app->db->createCommand("delete from kategorija_artikal
              where kategorija_artikal.id_aritkal = :idArtikal and kategorija_artikal.id_kategorija = :idKategorija")
                ->bindValue('idArtikal', $idArtikal)
                ->bindValue(':idKategorija', $idKategorija)
                ->execute();
        }
    }
    public function ArtikalImaBarJednuKategoriju($idArtikal)
    {
        return Yii::$app->db->createCommand('SELECT COUNT(ka.id_kategorija) = 1 FROM kategorija_artikal ka WHERE id_aritkal = :idArtikal')
            ->bindValue('idArtikal', $idArtikal)->queryScalar();
    }
}
