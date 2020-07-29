<?php
/**
 * ProductSearch.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\store\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\store\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\store\models\Product`.
 */
class ProductSearch extends Product
{
    
    public $search;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catalog_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description', 'content', 'keywords', 'slug', 'search'], 'safe'],
            [['price'], 'number'],
            [['active', 'new', 'popular'], 'boolean'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Product::find()->with(['catalog', 'attachments']);
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id'         => $this->id,
            'catalog_id' => $this->catalog_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'price'      => $this->price,
            'active'     => $this->active,
            'new'        => $this->new,
            'popular'    => $this->popular,
        ]);
        
        $query
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'title', $this->search])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'content', $this->content])
            ->andFilterWhere(['ilike', 'keywords', $this->keywords])
            ->andFilterWhere(['ilike', 'slug', $this->slug]);
        
        return $dataProvider;
    }
}
