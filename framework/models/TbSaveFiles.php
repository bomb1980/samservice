<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_save_files".
 *
 * @property int $id
 * @property string $tb_name
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 */
class TbSaveFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_save_files';
    }

   
    public function rules()
    {
        return [
            [['tb_name', 'path'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['tb_name', 'path'], 'string', 'max' => 255],
            [['path'], 'unique'],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tb_name' => 'Tb Name',
            'path' => 'Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    
    public static function find()
    {
        return new TbSaveFilesQuery(get_called_class());
    }
}
