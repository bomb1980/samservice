<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mas_ssobranch".
 *
 * @property int $id
 * @property string $ssobranch_code
 * @property string|null $name
 * @property string|null $shortname
 * @property int|null $ssobranch_type_id 1=ส่วนกลาง, 2=จังหวัด
 * @property string|null $status 1=active, 2=inactive, 0=delete
 * @property string|null $create_by
 * @property string|null $create_date
 * @property string|null $update_by
 * @property string|null $update_date
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int|null $service 0=ไม่ใช่ศูนย์บริการ, 1=ศูนย์บริการ
 */
class MasSsobranch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mas_ssobranch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ssobranch_code'], 'required'],
            [['ssobranch_type_id', 'service'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['ssobranch_code', 'shortname', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 2],
            [['latitude', 'longitude'], 'string', 'max' => 50],
            [['ssobranch_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ssobranch_code' => 'Ssobranch Code',
            'name' => 'Name',
            'shortname' => 'Shortname',
            'ssobranch_type_id' => '1=ส่วนกลาง, 2=จังหวัด',
            'status' => '1=active, 2=inactive, 0=delete',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'service' => '0=ไม่ใช่ศูนย์บริการ, 1=ศูนย์บริการ',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MasSsobranchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasSsobranchQuery(get_called_class());
    }
}
