<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MasUser]].
 *
 * @see MasUser
 */
class MasUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
