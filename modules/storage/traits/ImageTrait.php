<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

namespace app\modules\storage\traits;

use yii\helpers\Url;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;
use app\modules\storage\models\Storage;

/**
 * Trait ImageTrait
 *
 * @property Storage[] $attachments
 * @property string    $image
 *
 * @package app\modules\storage\traits
 */
trait ImageTrait
{
    
    public $files;
    
    public function init()
    {
        parent::init();
        
        $this->attachBehavior('file', [
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
        ]);
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
    
}
