<?php if ($this->ion_auth->logged_in()) : ?>
<!-- закрываем контейнер контента -->
    </div>
    <!-- RSS -->
    <div class="col-md-2" id="rss"></div>
</div></div>
<?php else: ?>
    <!-- закрываем контейнер контента -->
    </div>
</div></div>
<?php endif; ?>
<!-- модалка -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content"></div>
    </div>
</div>
<!--
<footer class="container">
    <div class="row">
        <div class="col-sm-12">
            &copy; Rus Imperia 2018<?=(date('Y') > 2018)?'-'.date('Y'):'';?>
        </div>
    </div>

</footer>
-->

<!-- Включают все скомпилированные плагины (ниже), или включать отдельные файлы по мере необходимости -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.message.min.js"></script>
<script src="/js/cropper.js"></script>
<link href="/css/jquery.message.css" rel="stylesheet">
<link href="/css/cropper.css" rel="stylesheet">
<script src="/js/main.js"></script>


</body>
</html>