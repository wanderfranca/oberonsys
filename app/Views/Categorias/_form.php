<div class="form-group">
    <label class="form-control-label">Categoria</label>
    <input type="text" name="nome" placeholder="Insira o nome completo" maxlength="30" class="form-control"value="<?php echo esc($categoria->nome) ?>">
</div>
<div class="form-group">
    <label for="exampleFormControlTextarea1">Descrição</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" name="descricao" rows="3"><?php echo $categoria->descricao?></textarea>
  </div>

<div class="custom-control custom-checkbox">

    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" name="ativo" value="1" class="custom-control-input" id="ativo" <?php if($categoria->ativo == true): ?> checked <?php endif; ?> >

    <label class="custom-control-label" for="ativo">Categoria Ativa</label>
</div>