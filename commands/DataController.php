<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\ExitCode;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class DataController extends Controller
{
    
    /**
     * This command echoes what you have entered as the message.
     *
     * @param string $message the message to be echoed.
     *
     * @return int Exit code
     */
    public function actionIndex()
    {
        echo 'Available Commands:' . "\n";
        echo '1) ./yii data/insert-zip' . "\n";
        
        return ExitCode::OK;
    }
    
    public function actionInsertZip()
    {
        $zips = [];
        
        if(($handle = fopen(Yii::getAlias('@app/data/zip.csv'), "r")) !== false) {
            while(($data = fgetcsv($handle, 100000, ",")) !== false) {
                $zips[] = [$data[1], $data[2], $data[4]];
            }
            fclose($handle);
        }
        
        Yii::$app->db->createCommand()->batchInsert('zip', ['zip', 'state', 'city'], $zips)->execute();
    }
}
