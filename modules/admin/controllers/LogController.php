<?php
/**
 * LogController.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Log;
use yii\web\NotFoundHttpException;
use app\modules\admin\models\LogSearch;

class LogController extends BackendController
{
    
    /**
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Log model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Log::findOne(['id' => $id]);
        
        if($model) {
            return $this->render('view', ['model' => $model]);
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
        
    }
    
    
}
