<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\store\models;

use yii\helpers\Url;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;
use yz\shoppingcart\CartPositionTrait;
use app\modules\storage\models\Storage;
use yz\shoppingcart\CartPositionInterface;
use app\modules\warehouse\models\Warehouse;
use app\modules\admin\interfaces\Importable;
use app\modules\warehouse\models\ProductWarehouse;

/**
 * This is the model class for table "product".
 *
 * @property int         $id
 * @property int|null    $catalog_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 * @property int|null    $updated_by
 * @property string|null $keywords
 * @property string|null $slug
 * @property float|null  $price
 * @property bool|null   $active
 * @property bool|null   $new
 * @property bool|null   $popular
 *
 * @property Catalog     $catalog
 * @property string      $image
 */
class Product extends ActiveRecord implements CartPositionInterface
{
    
    use CartPositionTrait;
    
    const ACTIVE   = 1;
    const DISABLED = 0;
    
    public $files;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['catalog_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'price'], 'required'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['active', 'new', 'popular'], 'boolean'],
            [['title'], 'string', 'max' => 60],
            [['description', 'keywords', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['files'], 'safe'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            'slug' => [
                'class'        => 'yii\behaviors\SluggableBehavior',
                'attribute'    => 'title',
                'ensureUnique' => true,
            ],
            'file' => [
                'class'            => 'app\modules\storage\behaviors\UploadBehavior',
                'uploadRelation'   => 'attachments',
                'pathAttribute'    => 'path',
                'attribute'        => 'files',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute'    => 'type',
                'sizeAttribute'    => 'size',
                'nameAttribute'    => 'name',
                'orderAttribute'   => 'sort',
                'multiple'         => true,
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'catalog_id'  => 'Catalog',
            'title'       => 'Title',
            'description' => 'Description',
            'content'     => 'Content',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
            'created_by'  => 'Created By',
            'updated_by'  => 'Updated By',
            'keywords'    => 'Keywords',
            'slug'        => 'Slug',
            'price'       => 'Price',
            'active'      => 'Active',
            'new'         => 'New',
            'popular'     => 'Popular',
        ];
    }
    
    public function attributeHints()
    {
        return [
            'keywords' => 'SEO Keywords, comma separated',
        ];
    }
    
    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getAttachments() : ActiveQuery
    {
        return $this->hasMany(Storage::class, ['model_id' => 'id'])->where(['model_name' => $this->formName()]);
    }
    
    public function getImage()
    {
        if($this->attachments) {
            return $this->attachments[0]->src;
        }
        
        return Url::base(true) . '/images/no-image.webp';
    }
    
    /**
     * @return ActiveQuery
     */
    public function getCatalog() : ActiveQuery
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }
    
    public function getProductWarehouses()
    {
        return $this->hasMany(ProductWarehouse::class, ['product_id' => 'id']);
        
    }
    
    public function getWarehouses()
    {
        return $this->hasMany(Warehouse::class, ['id' => 'warehouse_id'])->via('productWarehouses');
    }
}
