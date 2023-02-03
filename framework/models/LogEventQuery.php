<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LogEvent]].
 *
 * @see LogEvent
 */
class LogEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LogEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LogEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
