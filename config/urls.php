<?php

/**
 *  PHP version 7.3
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.net/license
 * @version    1.0
 * @link       https://github.com/xristmas365/basic
 * @since      File available since v1.0
 */

return [
    /**
     * Project
     */
    
    '/'        => '/site/index',
    '/privacy' => '/site/privacy',
    '/terms'   => '/site/terms',
    
    /**
     * FRONT PAGES
     */
    
    '/sections'       => '/article/front/sections',
    '/section/<slug>' => '/article/front/section',
    '/article/<slug>' => '/article/front/article',
    
    /**
     * AUTH
     */
    
    '/login'    => '/user/auth/login',
    '/logout'   => '/user/auth/logout',
    '/reset'    => '/user/auth/reset',
    '/password' => '/user/auth/password',
    
    /**
     * ADMIN
     */
    
    '/admin'           => '/admin/default/index',
    '/admin/logs'      => '/admin/log/index',
    '/admin/logs/<id>' => '/admin/log/view',
    '/admin/settings' => '/admin/default/settings',
    
    /**
     * USERS
     */
    
    '/admin/users'            => '/user/default/index',
    '/admin/account'          => '/user/default/account',
    '/admin/account/password' => '/user/default/password',
    '/admin/users/create'     => '/user/default/create',
    '/admin/users/<id>'       => '/user/default/update',
    
    /**
     * PAGE
     */
    
    '/admin/pages'     => '/page/default/index',
    '/admin/pages/new' => '/page/default/create',
    '/admin/pages/<id>' => '/page/default/update',
    
    /**
     * ARTICLE
     */
    
    '/admin/articles'          => '/article/default/index',
    '/admin/articles/new'      => '/article/default/create',
    '/admin/articles/sections' => '/article/section/index',
    
    /**
     * STORE
     */
    
    '/admin/products'      => '/store/product/index',
    '/admin/products/new'  => '/store/product/create',
    '/admin/products/<id>' => '/store/product/update',
    
    '/p/<slug>' => '/store/front/product',
    
    '/admin/catalogs' => '/store/catalog/index',
];
