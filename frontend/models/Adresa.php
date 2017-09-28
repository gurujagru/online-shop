<?php

namespace app\models;

use Yii;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\db\Query;

/**
 * This is the model class for table "adresa".
 *
 * @property integer $id
 * @property string $ulica
 * @property string $ulicni_broj
 * @property string $grad
 * @property integer $postanski_broj
 * @property string $zemlja
 *
 * @property User[] $users
 */
class Adresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ulica', 'ulicni_broj', 'grad', 'postanski_broj', 'zemlja'], 'required'],
            [['postanski_broj'], 'integer'],
            [['ulica', 'ulicni_broj', 'grad', 'zemlja'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ulica' => 'Ulica',
            'ulicni_broj' => 'Ulicni Broj',
            'grad' => 'Grad',
            'postanski_broj' => 'Postanski Broj',
            'zemlja' => 'Zemlja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['adresa_id' => 'id']);
    }
    public function getAdresaByUserId($userId)
    {
        $query = Adresa::find()
            ->innerJoin('user', 'user.adresa_id = adresa.id')
            ->where('user.id=:user_id', [':user_id' => $userId])
            ->one();
        return $query;
    }
    public function findAdresa($id){
        if (($model = Adresa::findOne($id))!==null){
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function postojiAdresa($model)
    {
        $query = Adresa::find()
            ->where('adresa.ulica = :ulica',[':ulica'=>$model->ulica])
            ->andWhere('adresa.ulicni_broj = :ulicni_broj',[':ulicni_broj'=>$model->ulicni_broj])
            ->andWhere('adresa.postanski_broj = :postanski_broj',[':postanski_broj'=>$model->postanski_broj])
            ->andWhere('adresa.grad = :grad',[':grad'=>$model->grad])
            ->andWhere('adresa.zemlja = :zemlja',[':zemlja'=>$model->zemlja])
            ->one();
        return $query;
    }
    public function dodajNovuAdresu($modelAdresa)
    {
        $query = new Query();
        return $query->createCommand()->insert('adresa',[
            'ulica' => $modelAdresa->ulica,
            'ulicni_broj' => $modelAdresa->ulicni_broj,
            'postanski_broj' => $modelAdresa->postanski_broj,
            'grad' => $modelAdresa->grad,
            'zemlja' => $modelAdresa->zemlja,
        ])->execute();
    }
    public function idPoslednjeAdreseBaza(){
        return $query = Adresa::find()->max('adresa.id');
    }

}
