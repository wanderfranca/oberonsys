<div class="form-group">
    <label class="form-control-label">Nome Completo</label>
    <input type="text" name="nome" placeholder="Insira o nome completo" class="form-control"value="<?php echo esc($usuario->nome) ?>">
</div>
<div class="form-group">
    <label class="form-control-label">E-mail</label>
    <input type="text" name="email" placeholder="Insira o E-mail de acesso" class="form-control"
        value="<?php echo esc($usuario->email) ?>">
</div>
<div class="form-group">
    <label class="form-control-label">Senha</label>
    <input name="password" type="password" placeholder="Senha de acesso" class="form-control">
</div>
<div class="form-group">
    <label class="form-control-label">Confirmação de senha</label>
    <input name="password_confirmation" type="password" placeholder="Confirme a senha de acesso" class="form-control">
</div>

<div class="custom-control custom-checkbox">

    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" name="ativo" value="1" class="custom-control-input" id="ativo" <?php if($usuario->ativo == true): ?> checked <?php endif; ?> >

    <label class="custom-control-label" for="ativo">Usuário ativo</label>
</div>