<?php

namespace app\modules\file\components;

use yii\base\Component;
use League\Flysystem\FileNotFoundException;

/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */
class CsvParser extends Component
{
    
    protected $file;
    
    public function preview($rows = 10) : array
    {
        $content = [];
        $row = 1;
        if(($handle = fopen($this->file, "r")) !== false) {
            while(($data = fgetcsv($handle, 1000, ',')) !== false) {
                if($row === $rows) {
                    break;
                }
                $content[] = $data;
                ++$row;
            }
            fclose($handle);
        }
        
        $headers = array_shift($content);
        
        return ['content' => $content, 'headers' => $headers];
    }
    
    public function loadFile($src)
    {
        if(!file_exists($src)) {
            throw new FileNotFoundException('File Not Found');
        }
        $this->file = $src;
        
    }
}
