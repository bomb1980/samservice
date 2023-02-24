<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TbSaveFiles]].
 *
 * @see TbSaveFiles
 */
class TbSaveFilesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TbSaveFiles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbSaveFiles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
