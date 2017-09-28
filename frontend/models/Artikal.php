<?php

namespace frontend\models;

use app\models\ArtikalNarudzbina;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "artikal".
 *
 * @property integer $id
 * @property string $naslov
 * @property resource $slika
 * @property string $opis
 * @property double $cena
 * @property string $proizvodjac
 *
 * @property KategorijaArtikal[] $kategorijaArtikals
 */
class Artikal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $upload_slika;

    public static function tableName()
    {
        return 'artikal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['naslov', 'opis', 'cena', 'proizvodjac'], 'required'],
            [['opis'], 'string'],
            [['cena'], 'number'],
            [['naslov'], 'string', 'max' => 20],
            [['proizvodjac'], 'string', 'max' => 55],
            [['upload_slika'], 'file', 'extensions' => 'png,jpg,gif'],
            [['slika'], 'required', 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'naslov' => 'Naslov',
            'slika' => 'Slika',
            'opis' => 'Opis',
            'cena' => 'Cena',
            'proizvodjac' => 'Proizvodjac',
            'kategorija' => 'Kategorija',
            'upload_slika' => 'Dodaj sliku'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategorijaArtikals()
    {
        return $this->hasMany(KategorijaArtikal::className(), ['id_aritkal' => 'id']);
    }

    public function getArtikalNarudzbinas()
    {
        return $this->hasMany(ArtikalNarudzbina::className(), ['artikal_id' => 'id']);
    }

    ########################################################################################


    public function getAllArtikal()
    {
        return $query = Artikal::find();
    }

    public function getArtikalByKategorijaNaziv($nazivKategorije)
    {
        return $query = Artikal::find()->innerJoin('kategorija_artikal', 'artikal.id = id_aritkal')
            ->innerJoin('kategorija', 'id_kategorija = kategorija.id')->andWhere(['naziv' => $nazivKategorije]);
    }

    public function  getArtikalByPorudzbina($userId)
    {
        $query1 = new Query();
        $poslednjaNarudzbina = $query1->select('narudzbina.id')->from('narudzbina')
            ->innerJoin('user','user.id = narudzbina.user_id')->where('user.id = :userId',[':userId'=>$userId])
            ->max("narudzbina.id");
        $query2 = new Query();
        return $query2->select('n.id,u.username,n.vreme_kreiranja,a.naslov')
            ->from('user u')
            ->innerJoin('narudzbina n', 'n.user_id = u.id')
            ->innerJoin('artikal_narudzbina an', 'an.narudzbina_id = n.id')
            ->innerJoin('artikal a', 'an.artikal_id = a.id')
            ->where('u.id = :userId', [':userId' => $userId])
            ->andWhere('n.id = :posednjaNarudzbina',[':posednjaNarudzbina'=>$poslednjaNarudzbina])
            ->all();
    }
}