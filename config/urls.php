<?php

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

return [
    
    /**
     * Site
     */
    '/'                       => '/site/index',
    '/articles'               => '/article/front/index',
    '/products'               => '/store/front/index',
    '/products/<slug>'        => '/store/front/product',
    
    /**
     * AUTH
     */
    '/register'               => '/user/auth/register',
    '/login'                  => '/user/auth/login',
    '/logout'                 => '/user/auth/logout',
    '/reset'                  => '/user/auth/reset',
    '/password'               => '/user/auth/password',
    '/switch/<id>'            => '/user/auth/switch',
    
    /**
     * ADMIN
     */
    '/admin'                  => '/admin/default/index',
    '/admin/logs'             => '/admin/log/index',
    '/admin/logs/<id>'        => '/admin/log/view',
    
    /**
     * ADMIN - USERS
     */
    '/admin/users'            => '/user/default/index',
    '/admin/users/new'        => '/user/default/create',
    '/admin/users/<id>'       => '/user/default/update',
    
    /**
     * ADMIN - ACCOUNT
     */
    '/admin/account'          => '/user/default/account',
    '/admin/account/password' => '/user/default/password',
    
    /**
     * ADMIN - PAGES
     */
    
    '/admin/pages'                    => '/page/default/index',
    '/admin/pages/new'                => '/page/default/create',
    '/admin/pages/<id>'               => '/page/default/update',
    
    /**
     * ADMIN - ARTICLES
     */
    '/admin/articles'                 => '/article/default/index',
    '/admin/articles/new'             => '/article/default/create',
    '/admin/articles/<id>'            => '/article/default/update',
    
    /**
     * ADMIN - TOPICS
     */
    '/admin/topics'                   => '/article/topic/index',
    '/admin/topics/new'               => '/article/topic/create',
    '/admin/topics/<id>'              => '/article/topic/update',
    
    /**
     * ADMIN - PRODUCTS
     */
    '/admin/products'                 => '/store/product/index',
    '/admin/products/new'             => '/store/product/create',
    '/admin/products/<id>'            => '/store/product/update',
    
    /**
     * ADMIN - PRODUCTS
     */
    '/admin/catalogs'                 => '/store/catalog/index',
    '/admin/catalogs/new'             => '/store/catalog/create',
    '/admin/catalogs/<id>'            => '/store/catalog/update',
    
    /**
     * ADMIN - PRODUCTS
     */
    '/admin/warehouses'               => '/warehouse/default/index',
    '/admin/warehouses/new'           => '/warehouse/default/create',
    '/admin/warehouses/<id>/products' => '/warehouse/default/view',
    '/admin/warehouses/<id>'          => '/warehouse/default/update',
];
