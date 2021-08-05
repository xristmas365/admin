<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
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
