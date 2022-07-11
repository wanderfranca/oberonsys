<div class="row">
    <div class="form-group col-md-8">
        <label class="form-control-label">Razão Social</label>
        <input type="text" name="razao" placeholder="Razão Social" require maxlength="110" class="form-control"value="<?php echo esc($fornecedor->razao) ?>">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">CNPJ</label>
        <input type="text" name="cnpj" placeholder="CNPJ" require class="form-control cnpj"value="<?php echo esc($fornecedor->cnpj) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">IE</label>
        <input type="text" name="ie" placeholder="Incrição Estadual" require maxlength="14" class="form-control"value="<?php echo esc($fornecedor->ie) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Telefone</label>
        <input type="text" name="telefone" placeholder="Telefone" require maxlength="14" class="form-control telefone"value="<?php echo esc($fornecedor->telefone) ?>">
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label">E-mail</label>
        <input type="text" name="email" placeholder="E-mail" require maxlength="50" class="form-control "value="<?php echo esc($fornecedor->email) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Cep</label>
        <input type="text" name="cep" placeholder="CEP" require maxlength="15" class="form-control cep"value="<?php echo esc($fornecedor->cep) ?>">
        <div id="cep"></div>
    </div>

    <div class="form-group col-md-7">
        <label class="form-control-label">Endereço</label>
        <input type="text" name="endereco" placeholder="Endereço" require maxlength="110" class="form-control"value="<?php echo esc($fornecedor->endereco)?>" readonly>
    </div>

    <div class="form-group col-md-2">
        <label class="form-control-label">Número</label>
        <input type="text" name="numero" placeholder="Nº" require maxlength="10" class="form-control"value="<?php echo esc($fornecedor->numero) ?>">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Complemento</label>
        <input type="text" name="complemento" placeholder="Complemento" require maxlength="50" class="form-control"value="<?php echo esc($fornecedor->complemento) ?>">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Bairro</label>
        <input type="text" name="bairro" placeholder="Endereço" require maxlength="50" class="form-control"value="<?php echo esc($fornecedor->bairro) ?>" readonly>
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Cidade</label>
        <input type="text" name="cidade" placeholder="cidade" require maxlength="50" class="form-control"value="<?php echo esc($fornecedor->cidade) ?>" readonly>
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Estado</label>
        <input type="text" name="estado" placeholder="UF" require maxlength="2" class="form-control uf"value="<?php echo esc($fornecedor->estado) ?>" readonly>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label">Responsável</label>
        <input type="text" name="responsavel" placeholder="Pessoa de contato" require maxlength="50" class="form-control "value="<?php echo esc($fornecedor->responsavel) ?>">
    </div>

</div>
<div class="custom-control custom-checkbox">

    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" name="ativo" value="1" class="custom-control-input" id="ativo" <?php if($fornecedor->ativo == true): ?> checked <?php endif; ?> >

    <label class="custom-control-label" for="ativo">Fornecedor ativo</label>
</div>