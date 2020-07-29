<?php
/**
 * DefaultController.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\storage\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    
    public function actions()
    {
        return [
            'upload' => [
                'class'                  => 'trntv\filekit\actions\UploadAction',
                'responsePathParam'      => 'path',
                'responseBaseUrlParam'   => 'base_url',
                'responseUrlParam'       => 'url',
                'responseDeleteUrlParam' => 'delete_url',
                'responseMimeTypeParam'  => 'type',
                'responseNameParam'      => 'name',
                'responseSizeParam'      => 'size',
                'deleteRoute'            => 'delete',
                'fileStorage'            => 'fileStorage',
                'fileStorageParam'       => 'fileStorage',
                'sessionKey'             => '_uploadedFiles',
                'allowChangeFilestorage' => false,
                //'on afterSave'           => function($event)
                //{
                //    /**
                //     * @var $file \creocoder\flysystem\LocalFilesystem
                //     */
                //    $path = $event->filesystem->path . '/' . $event->path;
                //    $file = $event->filesystem->read($path);
                //    dd($file);
                //    //dd($event->filesystem);
                //    //$file = file_get_contents($event->filesystem->path . $event->path);
                //    //$path = $event->filesystem->path . '/' . $event->path;
                //    //$img = ImageManagerStatic::make($file)->fit(215, 215);
                //    //$file->put($img->encode());
                //},
            
            ],
            'delete' => [
                'class' => 'trntv\filekit\actions\DeleteAction',
            ],
            'view'   => [
                'class' => 'trntv\filekit\actions\ViewAction',
            ],
        ];
    }
}

/**
 * /Users/isteil/Sites/basic/web/upload/photo/1/zTrhjGyYzJ4A4mZW4HzaOhVkXhOVCuq-.jpg
 * /Users/isteil/Sites/basic/web/upload/photo/1/zTrhjGyYzJ4A4mZW4HzaOhVkXhOVCuq-.jpg
 */
