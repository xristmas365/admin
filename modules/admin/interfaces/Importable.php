<?php

namespace app\modules\admin\interfaces;

/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */
interface Importable
{
    
    /**
     * Array of attributes that can be imported
     *
     * return [
     *      'name'  => 'Name',
     *      'price' => 'Price',
     * ]
     *
     * @return array
     */
    public function importAttributes() : array;
}
