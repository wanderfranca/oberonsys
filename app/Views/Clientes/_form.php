<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label">Nome Completo</label>
        <input type="text" name="nome" placeholder="Nome Completo" require maxlength="110" class="form-control"value="<?php echo esc($cliente->nome) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">CPF</label>
        <input type="text" name="cpf" placeholder="cpf" require class="form-control cpf"value="<?php echo esc($cliente->cpf) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Telefone</label>
        <input type="text" name="telefone" placeholder="Telefone" require class="form-control sp_celphones"value="<?php echo esc($cliente->telefone) ?>">
    </div>

    <div class="form-group col-md-5">
        <label class="form-control-label">E-mail (para acesso ao sistema)</label>
        <input type="text" name="email" placeholder="E-mail" require maxlength="50" class="form-control "value="<?php echo esc($cliente->email) ?>">
        <div id="email"></div>
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Cep</label>
        <input type="text" name="cep" placeholder="CEP" require maxlength="15" class="form-control cep"value="<?php echo esc($cliente->cep) ?>">
        <div id="cep"></div>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label">Endereço</label>
        <input type="text" name="endereco" placeholder="Endereço" require maxlength="110" class="form-control"value="<?php echo esc($cliente->endereco)?>" readonly>
    </div>

    <div class="form-group col-md-2">
        <label class="form-control-label">Nª</label>
        <input type="text" name="numero" placeholder="Nº" require maxlength="10" class="form-control"value="<?php echo esc($cliente->numero) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Complemento</label>
        <input type="text" name="complemento" placeholder="Complemento" require maxlength="50" class="form-control"value="<?php echo esc($cliente->complemento) ?>">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Bairro</label>
        <input type="text" name="bairro" placeholder="Endereço" require maxlength="50" class="form-control"value="<?php echo esc($cliente->bairro) ?>" readonly>
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Cidade</label>
        <input type="text" name="cidade" placeholder="cidade" require maxlength="50" class="form-control"value="<?php echo esc($cliente->cidade) ?>" readonly>
    </div>

    <div class="form-group col-md-2">
        <label class="form-control-label">Estado</label>
        <input type="text" name="estado" placeholder="UF" require maxlength="2" class="form-control uf"value="<?php echo esc($cliente->estado) ?>" readonly>
    </div>

</div>