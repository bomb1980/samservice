<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mas_user".
 *
 * @property int $id
 * @property string|null $uid
 * @property string|null $password
 * @property string|null $passwordcheck
 * @property string|null $displayname
 * @property string|null $ssobranch_code
 * @property string|null $ssomail
 * @property string|null $lasted_login_date
 * @property string|null $status 1=active, 2=inactive, 0=delete
 * @property string|null $create_by
 * @property string|null $create_date
 * @property string|null $update_by
 * @property string|null $update_date
 */
class MasUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mas_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['lasted_login_date', 'create_date', 'update_date'], 'safe'],

            [['uid', 'update_by', 'create_by'], 'string', 'max' => 255],
            [['uid', 'displayname', 'ssobranch_code'], 'required'],
            [['uid'],'unique'],
            [['displayname'], 'string', 'max' => 255],
            [['ssobranch_code'], 'string', 'max' => 6],
            [['ssomail'], 'string', 'max' => 255],
            [  ['status'], 'integer'],
            // ['password', 'compare', 'compareAttribute'=>'passwordcheck'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'password' => 'Password',
            'displayname' => 'Displayname',
            'ssobranch_code' => 'Ssobranch Code',
            'ssomail' => 'Ssomail',
            'lasted_login_date' => 'Lasted Login Date',
            'status' => '1=active, 2=inactive, 0=delete',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MasUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasUserQuery(get_called_class());
    }
}
