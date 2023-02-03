<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MasSsobranch]].
 *
 * @see MasSsobranch
 */
class MasSsobranchQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasSsobranch[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasSsobranch|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
