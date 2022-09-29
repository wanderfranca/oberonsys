<div class="row">

    <div class="form-group col-md-5">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Razão
            Social/Nome</label>
        <input type="text" name="razao" placeholder="Insira o Nome ou Razão Social" class="form-control"
            value="<?php echo esc($configs->razao) ?>">
    </div>
    <div class="form-group col-md-3">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i>
            CNPJ/CPF</label>
        <input type="text" name="cpf_cnpj" placeholder="CNPJ Ou CPF sem pontos ou traços" class="form-control"
            value="<?php echo esc($configs->cpf_cnpj) ?>">
    </div>
    <div class="form-group col-md-2">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> IE</label>
        <input type="text" name="ie" placeholder="Inscrição Estadual" class="form-control"
            value="<?php echo esc($configs->ie) ?>">
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> IM</label>
        <input type="text" name="im" placeholder="Inscrição Estadual" class="form-control"
            value="<?php echo esc($configs->im) ?>">
    </div>
    <div class="form-group col-md-2">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Nire</label>
        <input type="text" name="nire" placeholder="Inscrição Estadual" class="form-control"
            value="<?php echo esc($configs->nire) ?>">
    </div>
    <div class="form-group col-md-3">
        <label class="form-control-label">Data Nire</label>
        <input type="date" name="data_nire" placeholder="Inscrição Estadual" class="form-control"
            value="<?php echo esc($configs->data_nire) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Regime
            Tributário</label>
        <select name="regime_tributario" class="form-control">
            <option class="text-black"><?php echo $configs->regime_tributario?></option>
            <option>simples nacional</option>
            <option>normal</option>
            <option>lucro presumido</option>
            <option>indefinido</option>
        </select>
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">CNAE</label>
        <input type="text" name="cnae" placeholder="CNAE" class="form-control"
            value="<?php echo esc($configs->cnae) ?>">
    </div>
    <div class="form-group col-md-3 mt-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="isento" value="1" class="custom-control-input" id="isento"
                <?php if($configs->isento == true): ?> checked <?php endif; ?>>
            <label class="custom-control-label" for="isento">Isento</label>
        </div>
    </div>

    <hr>  
    <hr>  
    
    <h4 class="pb-3"> Endereço </h4>

    <div class="form-group col-md-5">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Endereço</label>
        <input type="text" name="endereco" placeholder="Endereço" require maxlength="110" class="form-control"value="<?php echo esc($configs->endereco)?>" readonly>
    </div>

    <div class="form-group col-md-2">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Número</label>
        <input type="text" name="numero" placeholder="Nº" require maxlength="10" class="form-control"value="<?php echo esc($configs->numero) ?>">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Complemento</label>
        <input type="text" name="complemento" placeholder="Complemento" require maxlength="50" class="form-control"value="<?php echo esc($configs->complemento) ?>">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Bairro</label>
        <input type="text" name="bairro" placeholder="Endereço" require maxlength="50" class="form-control"value="<?php echo esc($configs->bairro) ?>" readonly>
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Cidade</label>
        <input type="text" name="cidade" placeholder="cidade" require maxlength="50" class="form-control"value="<?php echo esc($configs->cidade) ?>" readonly>
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label"><i class="fa fa-usd text-success fa-1x" aria-hidden="true"></i> Estado</label>
        <input type="text" name="estado" placeholder="UF" require maxlength="2" class="form-control uf"value="<?php echo esc($configs->estado) ?>" readonly>
    </div>

    <hr>  
    <hr>  
    
    <h4 class="pb-3"> Contato </h4>

    <div class="form-group col-md-5">
        <label class="form-control-label">E-mail</label>
        <input type="text" name="email" placeholder="E-mail" require maxlength="85" class="form-control"value="<?php echo esc($configs->email) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Telefone 1</label>
        <input type="text" name="telefone1" placeholder="Telefone 1" require maxlength="20" class="form-control"value="<?php echo esc($configs->telefone1) ?>">
    </div>

    <div class="form-group col-md-3">
        <label class="form-control-label">Telefone 2</label>
        <input type="text" name="telefone2" placeholder="Telefone 2" maxlength="20" class="form-control"value="<?php echo esc($configs->telefone2) ?>">
    </div>

    <div class="form-group col-md-8">
        <label class="form-control-label">Site da Empresa</label>
        <input type="url" name="site" placeholder="site" maxlength="20" class="form-control"value="<?php echo esc($configs->site) ?>">
    </div>

</div>