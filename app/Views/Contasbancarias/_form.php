    <div class="form-row">
        <div class="col-md-12 mb-4 my-1">
            <label for="">Tipo de conta:</label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="corrente" name="banco_tipo" value="Conta Corrente" checked>
                <label class="custom-control-label" for="corrente">Corrente</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="poupança" name="banco_tipo" value="Conta Poupança">
                <label class="custom-control-label" for="poupança">Poupança</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="digital" name="banco_tipo" value="Conta Digital">
                <label class="custom-control-label" for="digital">Digital</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="cartaocredito" name="banco_tipo" value="Cartão de Crédito">
                <label class="custom-control-label" for="cartaocredito">Cartão de Crédito</label>
            </div>
        </div>

    <div class="row">
        <div class="form-group col-md-8">
            <label class="form-control-label">Insituição Bancária</label>
            <select name="banco_id" class="form-control mb-3 mb-3">
                <?php foreach( $bancos as $banco): ?>
                <option class="text-black" value="<?php echo $banco->id ?>"
                    <?php echo ($banco->id == $contabancaria->banco_id ? 'selected' : '') ?>>
                    <?php echo $banco->instituicao_bancaria_nome ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-4">
            <label class="form-control-label">Agência</label>
            <input type="text" name="banco_agencia" placeholder="000000" require maxlength="20" class="form-control"
                value="<?php echo esc($contabancaria->banco_agencia) ?>">
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Conta</label>
            <input type="text" name="banco_conta" placeholder="00000-0" require maxlength="20" class="form-control"
                value="<?php echo esc($contabancaria->banco_conta) ?>">
        </div>

        <div class="form-group col-md-8">
            <label class="form-control-label">Chave Pix 1</label>
            <input type="text" name="banco_pix1" placeholder="chave pix" maxlength="100" class="form-control"
                value="<?php echo esc($contabancaria->banco_pix1) ?>">
        </div>

        <div class="form-group col-md-8">
            <label class="form-control-label">Chave Pix 2</label>
            <input type="text" name="banco_pix2" placeholder="chave pix" maxlength="100" class="form-control"
                value="<?php echo esc($contabancaria->banco_pix2) ?>">
        </div>

        <div class="form-group col-md-8">
            <label class="form-control-label">Telefone de contato</label>
            <input type="text" name="banco_telefone" placeholder="(00) 9999-99999" class="form-control sp_celphones"
                value="<?php echo esc($contabancaria->banco_telefone) ?>">
        </div>
</div>


<div class="custom-control custom-checkbox">

    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" name="ativo" value="1" class="custom-control-input" id="ativo"
        <?php if($contabancaria->ativo == true): ?> checked <?php endif; ?>>

    <label class="custom-control-label" for="ativo">Ativa</label>
</div>