<div class="user-block">

<div class="form-row mb-4">

    <div class="col-md-12">

        <?php if($ordem->id === null): ?>

            <div class="contributions">
               <b class="text-white">O.S aberta por:</b> <?php echo usuario_logado()->nome;?>
            </div>

            <div class="contributions">
               <b class="text-white">TAG: </b> <?php echo $ordem->codigo?>
                <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover" data-tigger="focus"
                    title="TAG" data-content="Esse é o código da ordem de serviço, anote para não esquecer">&nbsp;&nbsp; <i class="fa fa-question-circle fa-lg text-info"></i>
                    </a>
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

        <?php if($ordem->id === null): ?>

            <!-- cliente  -->
            <div class="form-group">
            <label class="form-control-label">Escolha o cliente <b class="text-primary">*</b></label>
                <select name="cliente_id" class="selectize" required>
                    <option value="">Busque o cliente ou CPF</option>
                </select>
            </div>
            <?php else: ?>

<!-- Cliente -->
<div class="form-group">
    <label class="form-control-label">Cliente</label>
    <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover" data-tigger="focus"
    title="Importante" data-content="Não é permitido alterar ou editar o cliente desta O.S">&nbsp;&nbsp; <i class="fa fa-question-circle fa-lg text-info"></i>
    </a>
    <input type="text" class="form-control" disabled readonly value="<?php echo esc($ordem->nome) ?>">
</div>

<?php endif; ?>

<!-- Valor da ordem -->
<div class="form-group">
    <label class="form-control-label">Equipamento <b class="text-primary">*</b></label>
    <input type="text" name="equipamento" placeholder="Informe o equipamento" class="form-control" required value="<?php echo esc($ordem->equipamento) ?>">
</div>

<!-- Defeitos -->
<div class="form-group">
    <label class="form-control-label">Defeitos do equipamento</label>
    <textarea class="form-control" name="defeito" placeholder="Descreva os defeitos do equipamento"><?php echo esc($ordem->defeito) ?></textarea>
</div>
<!-- Observações -->
<div class="form-group">
    <label class="form-control-label">Observações</label>
    <textarea class="form-control" name="observacoes"><?php echo esc($ordem->observacoes) ?></textarea>
</div>

<?php if($ordem->id): ?>
    <!-- Laudo técnico -->
<div class="form-group">
    <label class="form-control-label">Laudo Técnico</label>
    <textarea class="form-control" name="parecer_tecnico"><?php echo esc($ordem->parecer_tecnico) ?></textarea>
</div>

<?php endif; ?>







