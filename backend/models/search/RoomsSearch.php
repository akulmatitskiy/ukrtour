<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Rooms;

/**
 * RoomsSearch represents the model behind the search form about `common\models\Rooms`.
 */
class RoomsSearch extends Rooms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotelId', 'servioId', 'beds', 'extBeds', 'visible'], 'integer'],
            [['name', 'photo'], 'safe'],
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
        $query = Rooms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'hotelId' => $this->hotelId,
            'servioId' => $this->servioId,
            'beds' => $this->beds,
            'extBeds' => $this->extBeds,
            'visible' => $this->visible,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
