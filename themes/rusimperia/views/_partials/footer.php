<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (DEBUG) : ?>
    <div class="debug">
        <details>
            <summary>Отладочная информация</summary>
            <div class="debug-info">
                <?php if (!empty($debug)) :
                foreach ($debug as $var) :?>
                <details>
                    <summary><?=$var['t']?></summary>
                    <pre><?=$var['c']?></pre>
                </details>
                <?php endforeach;
                endif; ?>
            </div>
        </details>
    </div>
<?php endif; ?>