<?php

namespace app\modules\email\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Role;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
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
            'userList'     => User::getUserList([Role::USER, Role::CUSTOMER]),
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
    
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
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
        
        $response = [
            'status' => true,
            'emails' => 0,
        ];
        
        /**
         * @var $template EmailTemplate|null
         */
        $template = EmailTemplate::findOne(Yii::$app->request->post('template_id'));
        
        if(!$template) {
            throw new NotFoundHttpException('Template not Found');
        }
        
        /**
         * @var $users User[]|[]
         */
        $users = User::find()->select(['email', 'name', 'company'])->where(['id' => Yii::$app->request->post('users')])->all();
        
        $mailer = Yii::$app->mailer;
        
        $messages = [];
        
        foreach($users as $user) {
            $content = strtr($template->content, [
                '{{name}}'    => $user->name,
                '{{company}}' => $user->company,
                '{{date}}'    => date('Y-m-d'),
                '{{product}}' => 'Apple',
            ]);
            
            $messages[] = $mailer->compose()
                                 ->setTo($user->email)
                                 ->setFrom([getenv('MAIL_USER') => 'admin-ax.com'])
                                 ->setSubject($template->subject)
                                 ->setHtmlBody($content);
        }
        
        if(!$messages) {
            throw new InvalidConfigException('Messages are empty');
        }
        
        try {
            $response['emails'] =  $mailer->sendMultiple($messages);
        } catch(\Exception $e) {
            $response['status'] = false;
        }
        
        return $response;
        
        //$replaces = [
        //    '{{name}}'    => '',
        //    '{{company}}' => '',
        //    '{{date}}'    => date('Y-m-d'),
        //    '{{product}}' => '',
        //];
        //
        //$messages = [];
        //$content = [];
        
        //foreach($users as $user) {
        //
        //    $content[] = [
        //        '{{name}}'    => $user->name,
        //        '{{company}}' => 'Apple',
        //        '{{date}}'    => date('Y-m-d'),
        //        '{{product}}' => '',
        //    ];
        //
        //    $contentReplace = [];
        //    foreach($content as $item) {
        //        $contentReplace = str_replace(array_keys($item), array_values($item), $text);
        //    }
        //
        //    $messages[] = Yii::$app->mailer->compose()
        //                                   ->setTo($user->email)
        //                                   ->setFrom([getenv('MAIL_USER') => 'admin-ax.com'])
        //                                   ->setSubject($model->subject)
        //                                   ->setHtmlBody($contentReplace);
        //}
        //
        //try {
        //    return Yii::$app->mailer->sendMultiple($messages);
        //
        //} catch(\Exception $e) {
        //}
        //
        //return false;
    }
    
}
