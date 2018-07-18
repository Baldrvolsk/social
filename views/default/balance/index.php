<h1>Временная страничка пополнения баланса</h1>
<form id="add_balance" action="/balance/add/<?=$this->user->id?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="leptas" class="col-sm-4 control-label">Баланс для зачисления</label>
        <div class="col-sm-2">
            <input type="number" name="leptas" value="<?php echo set_value('leptas'); ?>" class="form-control"
                   id="leptas" aria-describedby="leptasHelp" minlength="1" maxlength="5" required>
            <?php if(form_error('leptas')) {echo form_error('leptas','<span class="text-danger">','</span>');} ?>
        </div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Пополнить баланс</button>
        </div>
    </div>
</form>