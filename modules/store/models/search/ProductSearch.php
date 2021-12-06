<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\store\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\store\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\store\models\Product`.
 */
class ProductSearch extends Product
{
    
    public $priceMin;
    
    public $priceMax;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'catalog_id'], 'integer'],
            [['title', 'description', 'content', 'keywords', 'slug'], 'safe'],
            [['price'], 'number'],
            [['active', 'new', 'popular'], 'boolean'],
            [['priceMin', 'priceMax'], 'safe'],
        ];
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $sum = <<<SQL
SUM(CASE product_warehouse.status
            WHEN 1 THEN product_warehouse.quantity
            WHEN 2 THEN -product_warehouse.quantity
            WHEN 3 THEN product_warehouse.quantity
            WHEN 4 THEN -product_warehouse.quantity
         END
    )
SQL;
        $query = Product::find()
                        ->select(['product.*', "$sum as quantity"])
                        ->distinct()
                        ->with('attachments')
                        ->joinWith(['warehouses', 'catalog'])
                        ->groupBy([
                            'product_warehouse.product_id',
                            'product.id',
                        ]);
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'product.id'         => $this->id,
            'product.catalog_id' => $this->catalog_id,
            'product.created_at' => $this->created_at,
            'product.price'      => $this->price,
            'product.active'     => $this->active,
        ]);
    
        $dataProvider->sort->attributes['quantity'] = [
            'asc'          => [$sum=>SORT_ASC],
            'desc'         => [$sum=>SORT_DESC],
            'defaultOrder' => SORT_ASC,
        ];
        
        $query
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'slug', $this->slug]);
        
        return $dataProvider;
    }
    
    public function frontSearch($params)
    {
        $query = Product::find()->where(['active' => true])->with(['catalog']);
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => 20],
        
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        if($this->catalog_id != 0) {
            $query->andFilterWhere(['catalog_id' => $this->catalog_id]);
        }
        
        $query->andFilterWhere(['<', 'price', $this->priceMin]);
        $query->andFilterWhere(['>', 'price', $this->priceMax]);
        
        return $dataProvider;
    }
}
