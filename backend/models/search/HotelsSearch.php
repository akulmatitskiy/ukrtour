<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Hotels;

/**
 * HotelsSearch represents the model behind the search form about `backend\models\Hotels`.
 */
class HotelsSearch extends Hotels
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cityId', 'serverId', 'servioId', 'tourTax', 'visible', 'rating'], 'integer'],
            [['alias', 'manager_emails'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            //[['slug'], 'string', 'max' => 255],
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
    public function search($params)
    {
        $query = Hotels::find();
            //->joinWith('descr');

        // add conditions that should always apply here
//        echo '<pre>';
//        print_r($query);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
//        var_dump($this);
//        exit;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            //'cityId' => $this->cityId,
            //'serverId' => $this->serverId,
            //'servioId' => $this->servioId,
            //'tourTax' => $this->tourTax,
            //'latitude' => $this->latitude,
            //'longitude' => $this->longitude,
            'visible' => $this->visible,
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
