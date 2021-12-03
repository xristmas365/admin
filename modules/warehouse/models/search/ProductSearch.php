<?php
/**
 * @author    Ann Kononovich <anna.kononovich@gmail.com>
 * @package   Admin AX project
 * @version   2.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\warehouse\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\ProductWarehouse;

class ProductSearch extends ProductWarehouse
{
    
    public function behaviors()
    {
        return [];
    }
    
    public function rules()
    {
        return [
            [['product_id', 'price', 'qty', 'total'], 'safe'],
        ];
    }
    
    public function search($id, $params)
    {
        $sum = <<<SQL
SUM(CASE pw.status
            WHEN 1 THEN pw.quantity
            WHEN 2 THEN -pw.quantity
            WHEN 3 THEN pw.quantity
            WHEN 4 THEN -pw.quantity
         END
    )
SQL;
        
        $query = ProductWarehouse::find()
                                 ->joinWith(['product p'])
                                 ->where(['pw.warehouse_id' => $id])
                                 ->alias('pw')
                                 ->groupBy([
                                     'pw.product_id',
                                     'p.id',
                                     'p.title',
                                     'pw.price',
                                     'p.created_by',
                                 ])
                                 ->select([
                                     'pw.product_id',
                                     'p.id',
                                     'p.title',
                                     'pw.price',
                                     'p.created_by',
                                     "$sum as qty",
                                     "pw.price * $sum as total",
                                     
                                 ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        ]);
        
        $dataProvider->sort->attributes['qty'] = [
            'asc'          => [$sum=>SORT_ASC],
            'desc'         => [$sum=>SORT_DESC],
            'defaultOrder' => SORT_ASC,
        ];
        
        $this->load($params);
        
        $query->andFilterWhere(['ilike', 'p.title', $this->product_id]);
        $query->andFilterHaving([$sum => $this->qty]);
        $query->andFilterWhere(['total' => $this->total]);
        
        return $dataProvider;
    }
}
