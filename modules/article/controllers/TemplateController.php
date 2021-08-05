<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\article\controllers;

use app\modules\admin\controllers\BackendController;

/**
 * DefaultController implements the CRUD actions for Article model.
 */
class TemplateController extends BackendController
{
    
    /**
     * @param $file
     *
     * @return string
     */
    public function actionView($file)
    {
        return $this->renderAjax($file);
    }
    
    
}
