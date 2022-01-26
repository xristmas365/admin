<?php

namespace app\modules\file\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\file\models\File]].
 *
 * @see \app\modules\file\models\File
 */
class FileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\modules\file\models\File[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\file\models\File|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
