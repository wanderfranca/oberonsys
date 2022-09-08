<div class="user-block">

<div class="form-row mb-4">

    <div class="col-md-12">

        <?php if($ordem->id === null): ?>

            <div class="contributions">
               <b class="text-white">O.S aberta por:</b> <?php usuario_logado()->nome;?>
            </div>

            <?php else: ?>

                <div class="contributions">
                <b class="text-white">O.S aberta por:</b> <?php echo esc($ordem->usuario_abertura); ?>
                </div>

                <?php if($ordem->usuario_responsavel !== null): ?>
                    <p class="contributions mt-o"><b class="text-white">Téc. Responsável: </b> <?php echo esc($ordem->usuario_responsavel); ?></p>

                <?php endif; ?>
        <?php endif; ?>

    </div>

</div>

<!-- Número do documento  -->
<div class="form-group">
    <label class="form-control-label">Número do Doc</label>
    <input type="text" name="numero_documento" placeholder="Nr Doc" class="form-control" value="<?php echo esc($ordem->numero_documento) ?>">
</div>
<!-- Valor da ordem -->
<div class="form-group">
    <label class="form-control-label">Valor da ordem</label>
    <input type="text" name="valor_conta" placeholder="Insira o valor" class="form-control money" required value="<?php echo esc($ordem->valor_conta) ?>">
</div>

<!-- Data de vencimento -->
<div class="form-group">
    <label class="form-control-label">Data de vencimento</label>
    <input type="date" name="data_vencimento" placeholder="dd-mm-aaaa" required class="form-control" value="<?php echo esc($ordem->data_vencimento) ?>">
</div>

<!-- Descrição -->
<div class="form-group">
    <label class="form-control-label">Descrição</label>
    <textarea class="form-control" name="descricao_conta" placeholder="Desreva a finalidade da ordem"><?php echo esc($ordem->descricao_conta) ?></textarea>
</div>

</div>





