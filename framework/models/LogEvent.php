<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_event".
 *
 * @property int $log_id
 * @property string $log_user
 * @property string $log_action
 * @property string $log_page
 * @property string $log_date
 * @property string $log_ip
 * @property string|null $log_description
 * @property int $log_status
 */
class LogEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_event';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('logdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_user', 'log_action', 'log_page', 'log_ip'], 'required'],
            [['log_date'], 'safe'],
            [['log_description'], 'string'],
            [['log_status'], 'integer'],
            [['log_user'], 'integer', 'max' => 100],
            [['log_action', 'log_page', 'log_ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'log_user' => 'Log User',
            'log_action' => 'Log Action',
            'log_page' => 'Log Page',
            'log_date' => 'Log Date',
            'log_ip' => 'Log Ip',
            'log_description' => 'Log Description',
            'log_status' => 'Log Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LogEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogEventQuery(get_called_class());
    }
}
