    <div class="form-row">

        <?php if($item->id === null ): ?>

        <div class="col-md-12 mb-4 my-1">
            <label for="">Este é um item do tipo:</label>
            <div class="custom-control custom-radio mb-2">
                <input type="radio" class="custom-control-input" id="produto" name="tipo" value="produto" readonly checked>
                <label class="custom-control-label" for="produto"><i class="fa fa-archive text-success"></i>
                    Produto</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="servico" name="tipo" value="servico" readonly>
                <label class="custom-control-label" for="servico"><i class="fa fa-wrench text-white"></i>
                    Serviço</label>
            </div>
        </div>

        <?php endif; ?>

        <div class="form-group col-md-8">
            <label class="form-control-label">Nome Reduzido</label>
            <input type="text" name="nome" placeholder="Nome do produto" require maxlength="60" readonly class="form-control"value="<?php echo esc($item->nome) ?>">
        </div>

        
        <div class="form-group col-md-8">
            <label class="form-control-label">Descrição Completa</label>
            <textarea name="descricao" class="form-control" col="5" readonly
                rows="3"><?php echo esc($item->descricao)?></textarea>
        </div>

            <div class="servico form-group col-md-5">
                <label class="form-control-label">SKU</label>
                <input type="text" name="codigo_interno" placeholder="Código Interno" maxlength="15" require class="form-control" readonly value="<?php echo esc($item->codigo_interno) ?>">
            </div>

            <!-- <div class="servico form-group col-md-5">
                <label class="form-control-label">EAN/GTIN</label>
                <input type="text" name="ean" placeholder="Código de Barras" maxlength="14" require class="form-control ean13"
                    value="">
            </div> -->

            <div class="servico form-group col-md-5">
                <label class="form-control-label">Marca</label>
                <input type="text" name="marca" placeholder="Marca do Item" require class="form-control" readonly
                    value="<?php echo esc($item->marca) ?>">
            </div>

            <div class="servico form-group col-md-5">
                <label class="form-control-label">Modelo</label>
                <input type="text" name="modelo" placeholder="modelo" require maxlength="50" class="form-control" readonly
                    value="<?php echo esc($item->modelo) ?>">
            </div>

            <div class="form-group col-md-5">
                <label class="form-control-label">Categoria</label>
                <select name="categoria_id" class="form-control mb-3 mb-3" readonly>
                    <?php foreach( $categoriasAtivas as $categoria): ?>
                    <option class="text-black" value="<?php echo $categoria->id ?>"
                        <?php echo ($categoria->id == $item->categoria_id ? 'selected' : '') ?>>
                        <?php echo $categoria->nome ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label class="form-control-label">Preço Venda</label>
            <input type="text" name="preco_venda" placeholder="0.00" require maxlength="20" class="form-control money" readonly
                value="<?php echo esc($item->preco_venda) ?>">
        </div>

        <div class="servico form-group col-md-2">
            <label class="form-control-label">Preço Custo</label>
            <input type="text" name="preco_custo" placeholder="0.00" require maxlength="20" class="form-control money" readonly
                value="<?php echo esc($item->preco_custo) ?>">
        </div>

        <div class="servico form-group col-md-2">
            <label class="form-control-label">Estoque</label>
            <input type="number" name="estoque" placeholder="00" require maxlength="20" class="form-control number" readonly
                value="<?php echo esc($item->estoque) ?>">
        </div>
    </div>
</div>

    <div class="servico custom-control custom-checkbox">
        <input type="hidden" name="controla_estoque" value="0">
        <input type="checkbox" name="controla_estoque" value="1" class="custom-control-input" id="controla_estoque" readonly
            <?php if($item->controla_estoque == true): ?> checked <?php endif; ?>>
        <label class="custom-control-label" for="controla_estoque">Controla Estoque</label>
    </div>

    <div class="custom-control custom-checkbox">
        <input type="hidden" name="situacao" value="0">
        <input type="checkbox" name="situacao" value="1" class="custom-control-input" id="situacao" readonly
            <?php if($item->situacao == true): ?> checked <?php endif; ?>>
        <label class="custom-control-label" for="situacao">Item ativo</label>
    </div>