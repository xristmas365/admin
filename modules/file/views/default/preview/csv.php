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

?>
<table class="table table-sm table-hover">
    <thead>
    <tr>
        <?php foreach($data['headers'] as $header) : ?>
            <th><?= $header ?></th>
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
