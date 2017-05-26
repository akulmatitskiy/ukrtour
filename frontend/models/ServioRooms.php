<?php

namespace frontend\models;

use Yii;
use common\models\Languages;
use common\models\ServioTranslates;

/**
 * This is the model class for table "servio_rooms".
 *
 * @property integer $id
 * @property integer $hotelId
 * @property integer $servioId
 * @property string $name
 * @property integer $beds
 * @property integer $extBeds
 * @property integer $visible
 * @property string $photo
 */
class ServioRooms extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servio_rooms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotelId', 'servioId', 'beds', 'extBeds', 'visible'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hotelId' => Yii::t('app', 'Hotel ID'),
            'servioId' => Yii::t('app', 'Servio ID'),
            'name' => Yii::t('app', 'Name'),
            'beds' => Yii::t('app', 'Beds'),
            'extBeds' => Yii::t('app', 'Ext Beds'),
            'visible' => Yii::t('app', 'Visible'),
            'photo' => Yii::t('app', 'Photo'),
        ];
    }

    /**
     * Servio hotel name relation
     * @param type $code the lang code
     * @return mixed hotel name
     */
    public function getServioName($code = null)
    {

        $langIso = Languages::getIsoCode($code);

        return $this->hasOne(ServioTranslates::className(), ['parentId' => 'id'])
                ->where([
                    'isoLang' => $langIso,
                    'parentType' => 'rooms',
        ]);
    }

    public function hotelRooms($hotelId)
    {
        $model = ServioRooms::find()
            ->select([
                '{{servio_rooms}}.id',
                '{{servio_rooms}}.photo',
                '{{servio_translates}}.name',
            ])
            ->joinWith('servioName')
            ->where([
                '{{servio_rooms}}.hotelId' => $hotelId,
                '{{servio_rooms}}.visible' => 1,
            ])
            ->all();

        return $model;
    }

}
