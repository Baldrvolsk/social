<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?=(empty($header)?'':$header) ?>

<div class="container">
    <div class="main">
        <aside class="l-sidebar">
            <?=(empty($l_sidebar)?'':$l_sidebar) ?>
        </aside>
        <main class="main-content">
            <?=(empty($content)?'':$content) ?>
        </main>
        <aside class="r-sidebar">
            <?=(empty($r_sidebar)?'':$r_sidebar) ?>
        </aside>
    </div>
</div>
<?=(empty($footer)?'':$footer) ?>
