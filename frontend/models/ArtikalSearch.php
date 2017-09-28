<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArtikalSearch represents the model behind the search form about `frontend\models\Artikal`.
 */
class ArtikalSearch extends Artikal
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['naslov', 'opis', 'proizvodjac'], 'safe'],
            [['cena'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($query, $params)
    {
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $cena = null;
        if($this->cena!=null){
            if (!is_numeric($this->cena)){
                $cena = explode('-',$this->cena);
                $this->cena = null;
            }
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($cena!=null && isset($cena[1])){
            $query->andFilterWhere(['between', 'cena', $cena[0],$cena[1]])->orderBy('cena ASC');
        } else {
            // grid filtering conditions
                $query->andFilterWhere([
                    //'id' => $this->id,
                    'like','cena',$this->cena,
                ]);
        }

        $query->andFilterWhere(['like', 'naslov', $this->naslov])
            ->andFilterWhere(['like', 'slika', $this->slika])
            ->andFilterWhere(['like', 'opis', $this->opis])
            ->andFilterWhere(['like', 'proizvodjac', $this->proizvodjac]);

        return $dataProvider;
    }
}
