<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (DEBUG) : ?>
<!-- Debug Info -->
<div class="debug">
    <details>
        <summary>Отладочная информация</summary>
        <span class='btn test-open-modal'>Test Open Modal</span>
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
<!-- Modal -->
<div class="overlay">
    <div class="content-box modal" id="modal">
        <span class="btn-close-modal fas fa-times fa-2x"></span>
        <div class="modal-header"></div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
    </div>
</div>
<script>
    var controller = '<?=strtolower($this->router->class)?>';
</script>
