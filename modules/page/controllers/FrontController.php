<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\page\controllers;

use yii\web\Controller;
use app\modules\page\models\Page;

class FrontController extends Controller
{
    
    
    public function actionView($slug)
    {
        $page = Page::findOne(['slug' => $slug]);
        
        return $this->render('view', [
            'page' => $page,
        ]);
    }
    
}
