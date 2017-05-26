<?php

namespace common\models;

use Yii;
use common\models\Languages;

/**
 * This is the model class for table "servio_cities".
 *
 * @property integer $id
 * @property string $alias
 */
class ServioCities extends \yii\db\ActiveRecord {

    /**
     * City name
     * @var string $name
     */
    public $name;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servio_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias'], 'string', 'max' => 50],
            [['alias', 'name'], 'required'],
            [['alias'], 'unique'],
            [['name'], 'each', 'rule' => ['string', 'max' => 50]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'name' => 'Название',
        ];
    }


    /**
     * Translates
     * @param type $code
     * @return type
     */
    public function getDescr($code = null)
    {
        $lang = Languages::getIsoCode($code);

        return $this->hasOne(ServioTranslates::className(), ['parentId' => 'id'])
                ->where([
                    '{{servio_translates}}.isoLang' => $lang,
                    '{{servio_translates}}.ParentType' => 'cities',
                    ]
        );
    }
    
    /**
     * Save city translates
     * @return boolean
     */
    public function saveDesrc() {
        // Get oll langs
        $langs = Languages::getLangs();
        
        // Save copy for each lang code
        foreach($langs as $code => $lang) {
            // search model
            $model = ServioTranslates::findOne([
                'isoLang' => $lang['iso'],
                'parentId' => $this->id,
                'parentType' => 'cities',
            ]);
            
            if(empty($model)) {
                // New
                $model = new ServioTranslates();
            } 
            
            // Assign properties
            $model->isoLang = $lang['iso'];
            $model->parentId = $this->id;
            $model->parentType = 'cities';
            $model->name = $this->name[$code];
            
            // Save
            if(!$model->save()) {
                Yii::warning($model->errors);
                return false;
            }
            
        }
        return true;
    }

}
