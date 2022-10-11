<div class="form-group">
    <label class="form-control-label">Despesa</label>
    <input type="text" name="despesa_nome" placeholder="Insira o nome completo" maxlength="30" class="form-control"value="<?php echo esc($despesa->despesa_nome) ?>">
</div>
<div class="form-group">
    <label for="exampleFormControlTextarea1">Descrição</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" name="despesa_descricao" rows="3"><?php echo $despesa->despesa_descricao?></textarea>
</div>
