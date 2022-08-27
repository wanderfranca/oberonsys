<div class="form-row">
        <?php if($conta->id === null): ?>

            Nova conta

        <?php else: ?>

            <div class="form-group col-md-7">
            <label class="form-control-label">Fornecedor</label>
            <input type="text" disabled readonly class="form-control"value="<?php echo esc($conta->razao) ?>">
        </div>

        <div class="form-group col-md-5">
                        <label class="form-control-label">Conta Bancária</label>
                        <select name="despesa_id" class="form-control" disabled readonly>
                            <?php foreach( $contasBancariasAtivas as $cbancaria): ?>
                            <option class="text-black" value="<?php echo $cbancaria->id ?>"
                                <?php echo ($cbancaria->id == $conta->conta_bancaria_id ? 'selected' : '') ?>>
                                <?php echo $cbancaria->banco_finalidade ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

        <?php endif; ?>
            <!-- Despesa -->
            <div class="form-group col-md-4">
                <label class="form-control-label">Despesa</label>
                <select name="despesa_id" class="form-control">
                    <?php foreach( $despesasAtivas as $despesa): ?>
                    <option class="text-black" value="<?php echo $despesa->id ?>"
                        <?php echo ($despesa->id == $conta->despesa_id ? 'selected' : '') ?>>
                        <?php echo $despesa->despesa_nome ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipos de Documentos -->
            <div class="form-group col-md-3">
                <label class="form-control-label">Documento</label>
                <select name="despesa_id" class="form-control">
                    <?php foreach( $tiposDocumentosAtivos as $doc): ?>
                    <option class="text-black" value="<?php echo $despesa->id ?>"
                        <?php echo ($doc->id == $conta->ddocumento_id ? 'selected' : '') ?>>
                        <?php echo $doc->tipo_documento_nome ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

        <!-- Número do documento  -->
        <div class="form-group col-md-5">
            <label class="form-control-label">Número do Doc</label>
            <input type="text" name="numero_documento" placeholder="Insira o valor" class="form-control" value="<?php echo esc($conta->numero_documento) ?>">
        </div>
        <!-- Valor da conta -->
        <div class="form-group col-md-3">
            <label class="form-control-label">Valor da conta</label>
            <input type="text" name="valor_conta" placeholder="Insira o valor" class="form-control money" value="<?php echo esc($conta->valor_conta) ?>">
        </div>

        <!-- Data de vencimento -->
        <div class="form-group col-md-5">
            <label class="form-control-label">Data de vencimento</label>
            <input type="date" name="data_vencimento" placeholder="dd-mm-aaaa" class="form-control" value="<?php echo esc($conta->data_vencimento) ?>">
        </div>
        
        <!-- Descrição -->
        <div class="form-group col-md-8">
            <label class="form-control-label">Descrição</label>
            <textarea class="form-control" name="descricao_conta"><?php echo esc($conta->descricao_conta) ?></textarea>
        </div>
    </div>

        <!-- Paga -->
        <?php if($conta->situacao == false): ?>
        <div class="custom-control custom-radio mb-2">
            <input type="radio" name="situacao" value="0" class="custom-control-input" id="aberta" <?php if($conta->situacao == false): ?> checked <?php endif; ?> >
            <label class="custom-control-label" for="aberta">Esta conta está em aberto</label>
        </div>
        <?php endif; ?>

        <div class="custom-control custom-radio mb-2">
            <input type="radio" name="situacao" value="1" class="custom-control-input" id="paga" <?php if($conta->situacao == true): ?> checked <?php endif; ?> >
            <label class="custom-control-label" for="paga">Esta conta está paga</label>
        </div>

        <?php if($conta->situacao == false): ?>
        <!-- Data de pagamento -->
        <div class="form-group col-md-5 ml-2 pagamento" id="dataPagamento">
            <label class="form-control-label">Data do pagamento</label>
            <input type="date" id="datapg" name="data_pagamento" placeholder="dd-mm-aaaa" class="form-control" value="<?php echo esc($conta->data_pagamento) ?>">
        </div>

        <?php else: ?>
        <div class="form-group col-md-5 ml-2 pagamento" id="dataPagamento" >
            <label class="form-control-label">Data do pagamento</label>
            <input type="date" id="datapg" readonly name="data_pagamento" placeholder="dd-mm-aaaa" class="form-control" value="<?php echo esc($conta->data_pagamento) ?>">
        </div>
        <?php endif; ?>