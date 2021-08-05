<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\data\ArrayDataProvider;
use app\modules\storage\models\StorageSearch;

class FileController extends BackendController
{
    
    public function actionIndex()
    {
        $files = FileHelper::findFiles(Yii::getAlias('@upload'), [
            'except' => [
                '.dirindex',
                '.gitignore',
            ],
        ]);
        
        $allModels = array_map(function($item)
        {
            return ['id' => $item];
        }, $files);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $allModels,
            'sort'      => false,
        ]);
        
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionStorage()
    {
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('storage', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDeleteSrc($id)
    {
        Yii::$app->response->format = 'json';
        
        return unlink($id);
        
    }
    
}
