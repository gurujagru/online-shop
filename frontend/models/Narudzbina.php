<?php

namespace app\models;

use Yii;
use common\models\User;
use yii\db\Query;

/**
 * This is the model class for table "narudzbina".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $vreme_kreiranja
 *
 * @property ArtikalNarudzbina[] $artikalNarudzbinas
 * @property User $user
 */
class Narudzbina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'narudzbina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['vreme_kreiranja'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'vreme_kreiranja' => 'Vreme Kreiranja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtikalNarudzbinas()
    {
        return $this->hasMany(ArtikalNarudzbina::className(), ['narudzbina_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getAllNarudzbinaId()
    {
        $query = new Query();
        return $query->select('id')
            ->from('narudzbina')
            ->all();
    }
    public function getPoslednjaNarudzbinaUser($userId)
    {
        $poslednjaNarudzbinaId = Narudzbina::find()->max('id');

        return $query = Narudzbina::find()
            ->innerJoin('user','user.id = narudzbina.user_id')->where('user.id = :userId',[':userId'=>$userId])
            ->andwhere('narudzbina.id = :poslednjaNarudzbinaId',[':poslednjaNarudzbinaId'=>$poslednjaNarudzbinaId])->one();
    }
}
