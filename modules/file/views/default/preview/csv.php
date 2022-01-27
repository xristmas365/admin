<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

/**
 * @var array $data
 */

use yii\helpers\Html;
use richardfan\widget\JSRegister;

?>
<div class="row">
    <div class="col-3">
        <form id="preview-form-import-form">
            <?= Html::hiddenInput('file', $data['file']) ?>
            <?= Html::a('Import Data from File', '#', ['class' => 'btn btn-primary btn-block mb-4', 'id' => 'preview-form-import-btn']) ?>
            <?php foreach($data['attributes'] as $attribute => $label) : ?>
                <div class="form-group row field-product-title">
                    <label class="col-form-label has-star col-md-4" for="<?= $label ?>"><?= $label ?></label>
                    <div class="col-md-8">
                        <?= Html::dropDownList($attribute, null, $data['headers'], ['class' => 'form-control', 'prompt' => 'Skip']) ?>
                    </div>
                </div>
            <?php endforeach ?>
        </form>
    </div>
    <div class="col-9">
        <table class="table table-sm table-hover table-responsive table-bordered">
            <thead>
            <tr>
                <?php foreach($data['headers'] as $i => $header) : ?>
                    <th><?= $i . '. ' . $header ?></th>
                <?php endforeach ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data['content'] as $content) : ?>
                <tr>
                    <?php foreach($content as $cell) : ?>
                        <td>
                            <?= $cell ?>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php JSRegister::begin() ?>
<script>
</script>
<?php JSRegister::end() ?>

