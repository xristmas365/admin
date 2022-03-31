<?php

namespace app\modules\email\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Role;
use yii\web\NotFoundHttpException;
use app\modules\email\models\EmailTemplate;
use app\modules\email\models\search\TemplateSearch;
use app\modules\admin\controllers\BackendController;

/**
 * TemplateController implements the CRUD actions for EmailTemplate model.
 */
class TemplateController extends BackendController
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
     * Lists all EmailTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'userList' => User::getUserList([Role::USER, Role::CUSTOMER]),
        ]);
    }
    
    /**
     * Displays a single EmailTemplate model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    
    /**
     * Finds the EmailTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return EmailTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = EmailTemplate::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Creates a new EmailTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmailTemplate();
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing EmailTemplate model.
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
            return $this->redirect(['index']);
        }
        
        return $this->render('form', [
            'model' => $model,
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model'    => $this->findModel($id),
        ]);
        
    }
    /**
     * Deletes an existing EmailTemplate model.
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
    
    public function actionSendMail()
    {
        Yii::$app->response->format = 'json';
        $data = Yii::$app->request->post();
        $model = EmailTemplate::findOne($data['template_id']);
        $users = User::find()->select(['email'])->where(['id'=>$data['users']])->asArray()->column();
       
        try {
            return Yii::$app->mailer->compose()
                                    ->setTo($users)
                                    ->setFrom([getenv('MAIL_USER') => 'admin-ax.com'])
                                    ->setSubject($model->subject)
                                    ->setHtmlBody($this->parse($model->content))
                                    ->send();
           
        } catch(\Exception $e) {
        
        }
        
        return false;
    }
    
    protected function parse($text)
    {
        $model = EmailTemplate::findOne(2);
        $text = $model->content;
        
        $a = [
            '{{name}}'    => 'Ann',
            '{{company}}' => 'Apple',
            '{{date}}'    => date('Y-m-d'),
            '{{product}}' => 'Qaster',
        ];
        
        return str_replace(array_keys($a), array_values($a), $text);
    }
}
