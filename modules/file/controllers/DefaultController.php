<?php

namespace app\modules\file\controllers;

use Yii;
use yii\web\UploadedFile;
use app\modules\file\models\File;
use yii\web\NotFoundHttpException;
use app\modules\file\components\CsvParser;
use app\modules\file\models\search\FileSearch;
use app\modules\admin\controllers\BackendController;

/**
 * DefaultController implements the CRUD actions for File model.
 */
class DefaultController extends BackendController
{
    
    /**
     * {@inheritdoc}
     */
    //public function behaviors()
    //{
    //    return [
    //        'verbs' => [
    //            'class' => VerbFilter::class,
    //            'actions' => [
    //                'delete' => ['POST'],
    //            ],
    //        ],
    //    ];
    //}
    
    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new File;
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'model'        => $model,
        ]);
    }
    
    /**
     * @return string|\yii\web\Response
     */
    //public function actionCreate()
    //{
    //    $model = new File;
    //
    //    if($model->load(Yii::$app->request->post()) && $model->save()) {
    //        return $this->redirect(['index']);
    //    }
    //
    //    return $this->render('create', ['model' => $model]);
    //}
    
    /**
     * Displays a single File model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $link = Yii::getAlias('@app/web/upload/' . $model->name . '.' . $model->ext);
        $fp = fopen($link, 'r');
        
        $lines = [];
        while(($line = fgetcsv($fp)) !== false) {
            $lines[] = $line;
            
        }
        
        fclose($fp);
        
        return $this->render('view', ['model' => $model, 'line' => $lines]);
        
    }
    
    
    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = File::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate()
    {
        Yii::$app->response->format = 'json';
        
        $model = new File;
        $model->model = Yii::$app->request->post('model');
        $model->file = UploadedFile::getInstanceByName('file');
        
        return $model->save() ? $model->id : null;
    }
    
    public function actionDeleteFile()
    {
        return unlink(Yii::getAlias('@app/web/upload/csv/list.csv'));
        
    }
    
    
    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }
    
    public function actionShow($id)
    {
        $model = File::findOne($id);
        
        if($model->ext === 'csv') {
            $parser = new CsvParser;
            $parser->loadFile($model);
            $data = $parser->preview();
            
            return $this->renderAjax('preview/csv', ['data' => $data]);
            
        }
        
        return $this->renderAjax('preview/default');
        
    }
    
    public function actionImport()
    {
        Yii::$app->response->format = 'json';
        
        return Yii::$app->request->post();
    }
}
