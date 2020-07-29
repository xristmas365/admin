<?php
/**
 * CatalogSearch.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\store\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\store\models\Catalog;

/**
 * CatalogSearch represents the model behind the search form of `app\modules\store\models\Catalog`.
 */
class CatalogSearch extends Catalog
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'root', 'lft', 'rgt', 'lvl', 'icon_type'], 'integer'],
            [['name', 'icon'], 'safe'],
            [['child_allowed', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all'], 'boolean'],
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
        $query = Catalog::find();
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id'            => $this->id,
            'root'          => $this->root,
            'lft'           => $this->lft,
            'rgt'           => $this->rgt,
            'lvl'           => $this->lvl,
            'icon_type'     => $this->icon_type,
            'child_allowed' => $this->child_allowed,
            'active'        => $this->active,
            'selected'      => $this->selected,
            'disabled'      => $this->disabled,
            'readonly'      => $this->readonly,
            'visible'       => $this->visible,
            'collapsed'     => $this->collapsed,
            'movable_u'     => $this->movable_u,
            'movable_d'     => $this->movable_d,
            'movable_l'     => $this->movable_l,
            'movable_r'     => $this->movable_r,
            'removable'     => $this->removable,
            'removable_all' => $this->removable_all,
        ]);
        
        $query->andFilterWhere(['ilike', 'name', $this->name])
              ->andFilterWhere(['ilike', 'icon', $this->icon]);
        
        return $dataProvider;
    }
}
