<?php
/**
 * Catalog.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\store\models;

use kartik\tree\models\Tree;

/**
 * This is the model class for table "catalog".
 *
 * @property int         $id
 * @property int|null    $root
 * @property int         $lft
 * @property int         $rgt
 * @property int         $lvl
 * @property string      $name
 * @property string      $slug
 * @property string|null $icon
 * @property int         $icon_type
 * @property bool        $child_allowed
 * @property bool        $active
 * @property bool        $selected
 * @property bool        $disabled
 * @property bool        $readonly
 * @property bool        $visible
 * @property bool        $collapsed
 * @property bool        $movable_u
 * @property bool        $movable_d
 * @property bool        $movable_l
 * @property bool        $movable_r
 * @property bool        $removable
 * @property bool        $removable_all
 */
class Catalog extends Tree
{
    
    public $search;
    
    public $slug;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog';
    }
    
    public static function getList()
    {
        $nestedSets = Catalog::find()->select(['id', 'lvl', 'name'])->orderBy('root, lft')->asArray()->all();
        
        $list = [];
        
        foreach($nestedSets as $node) {
            $list[$node['id']] = str_repeat('»', $node['lvl']) . " " . $node['name'];
        }
        
        return $list;
    }
    
    public static function getNestedSets()
    {
        $collection = Catalog::find()->orderBy('root, lft')->asArray()->all();
        
        $trees = [];
        $l = 0;
        
        if($collection) {
            $stack = [];
            
            foreach($collection as $node) {
                $item = ['id' => $node['id'], 'lvl' => $node['lvl'], 'name' => $node['name']];
                $item['items'] = [];
                
                $l = count($stack);
                
                while($l > 0 && $stack[$l - 1]['lvl'] >= $item['lvl']) {
                    array_pop($stack);
                    $l--;
                }
                
                if($l == 0) {
                    $i = count($trees);
                    $trees[$i] = $item;
                    $stack[] = &$trees[$i];
                } else {
                    $i = count($stack[$l - 1]['items']);
                    $stack[$l - 1]['items'][$i] = $item;
                    $stack[] = &$stack[$l - 1]['items'][$i];
                }
            }
        }
        
        return $trees;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['search'], 'safe'],
            [['slug'], 'string'],
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class'        => 'yii\behaviors\SluggableBehavior',
                'attribute'    => 'name',
                'ensureUnique' => true,
            ],
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'root'          => 'Root',
            'lft'           => 'Lft',
            'rgt'           => 'Rgt',
            'lvl'           => 'Lvl',
            'name'          => 'Name',
            'slug'          => 'Slug',
            'icon'          => 'Icon',
            'icon_type'     => 'Icon Type',
            'child_allowed' => 'Child Allowed',
            'active'        => 'Active',
            'selected'      => 'Selected',
            'disabled'      => 'Disabled',
            'readonly'      => 'Readonly',
            'visible'       => 'Visible',
            'collapsed'     => 'Collapsed',
            'movable_u'     => 'Movable U',
            'movable_d'     => 'Movable D',
            'movable_l'     => 'Movable L',
            'movable_r'     => 'Movable R',
            'removable'     => 'Removable',
            'removable_all' => 'Removable All',
        ];
    }
    
    public function attributeHints()
    {
        return [
            'name' => 'Save after editing',
        ];
    }
    
    public function beforeSave($insert)
    {
        $this->icon_type = 1;
        $this->removable_all = true;
        $this->collapsed = true;
        
        return parent::beforeSave($insert);
    }
}
