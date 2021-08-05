<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

/**
 * @var $user User
 */

use app\modules\user\models\User;

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
</head>
<body>
<style>
    body {
        text-align: center;
        height: 100%;
        -webkit-box-align: center;
        -webkit-box-pack: center;
        background-color: #f5f5f5;
    }

    header {
        font-size: 24px;
        font-weight: bold;
        color: #1b3f5f
    }


    section {
        display: block;
        padding: 5px;
        width: 400px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    span {
        color: #6c757d !important;
        margin-bottom: 100px;
    }

    a {
        text-decoration: none;
        height: 24px;
        background-color: #007bff;
        border-color: #007bff;
        vertical-align: middle;
        display: block;
        width: 97%;
        font-weight: 400;
        color: #fff;
        text-align: center;
        font-size: 1rem;
        border-radius: 5px;
        padding: 5px;
    }
</style>
<section>
    <header>Hello, <?= $user->name ?></header>
    <br>
    <span>Verify Your Account</span>
    <br>
    <a href="<?= $user->generateVerifyLink() ?>" style="margin-top: 5px">Verify</a>
</section>
</body>
</html>



