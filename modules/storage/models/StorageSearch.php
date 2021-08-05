<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\storage\models;

use Yii;
use yii\data\ActiveDataProvider;

class StorageSearch extends Storage
{
    
    public $search;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'size', 'created_at', 'created_by', 'model_name', 'path', 'base_url', 'name', 'type', 'search'], 'safe'],
        ];
    }
    
    public function search($params)
    {
        $query = Storage::find();
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'OR',
            ['ilike', 'model_name', $this->search],
            ['ilike', 'name', $this->search],
            ['ilike', 'path', $this->search],
        ]);
        
        return $dataProvider;
    }
}
