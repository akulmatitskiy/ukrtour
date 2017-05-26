<?php

namespace common\models;

/**
 * This is the model class for table "servio_translates".
 *
 * @property integer $parentId
 * @property string $parentType
 * @property string $isoLang
 * @property string $name
 * @property string $descr
 * @property string $sub1
 * @property string $sub2
 */
class ServioTranslates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servio_translates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId', 'parentType', 'isoLang'], 'required'],
            [['parentId'], 'integer'],
            [['parentType'], 'string'],
            [['isoLang'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 50],
            [['descr'], 'string', 'max' => 10000],
            [['sub1', 'sub2'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parentId' => 'Parent ID',
            'parentType' => 'Parent Type',
            'isoLang' => 'Iso Lang',
            'name' => 'Name',
            'descr' => 'Descr',
            'sub1' => 'Sub1',
            'sub2' => 'Sub2',
        ];
    }
}
