<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PerPersonal1]].
 *
 * @see PerPersonal1
 */
class PerPersonalQuery1 extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PerPersonal1[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PerPersonal1|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
