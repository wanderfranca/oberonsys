<style>
#body-pdf {
    font-family: Arial, Helvetica, sans-serif;
}

#pdf {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#pdf td,
#pdf th {
    border: 1px solid #ddd;
    padding: 8px;
}

#pdf tr:nth-child(even) {
    background-color: #f2f2f2;
}

#pdf tr:hover {
    background-color: #ddd;
}

#pdf th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #03186D;
    color: white;
}

.color {
    color: #03186D;
}
</style>

<div id="body-pdf">

    <div>

        <h3 class="color"><?php echo esc($ordem->nome); ?></h3>
        <p><strong class="color">TAG: </strong><?php echo esc($ordem->codigo); ?></p>
        <p><strong class="color">Situação: </strong><?php echo $ordem->exibeSituacao(); ?></p>
        <p><strong class="color">Atendente: </strong><?php echo $ordem->usuario_abertura; ?></p>
        <p><strong class="color">Técnico:
            </strong><?php echo ($ordem->usuario_responsavel != null ? $ordem->usuario_responsavel : 'Não definido'); ?>
        </p>

        <?php if($ordem->situacao === 'encerrada'): ?>

        <p><strong class="color">Encerrada por: </strong><?php echo $ordem->usuario_encerramento; ?></p>

        <?php endif; ?>

        <p><strong class="color">O.S Aberta em: </strong><?php echo date('d/m/Y', strtotime( $ordem->criado_em)); ?></p>

        <?php if($ordem->atualizado_em !== null): ?>
        <p><strong class="color">O.S atualizado em:
            </strong><?php echo date('d/m/Y', strtotime( $ordem->atualizado_em)); ?></p>
        <?php endif; ?>

    </div>

</div>


<table id="pdf">
    <thead>
        <tr>
            <th scope="col">Item</th>
            <th scope="col">Tipo</th>
            <th scope="col">Preço Unitário</th>
            <th scope="col">Qtde</th>
            <th scope="col">Subtotal</th>
        </tr>
    </thead>
    <tbody>

        <?php         
            $valorProdutos = 0;
            $valorServicos = 0;
        ?>

        <?php foreach($ordem->itens as $item): ?>
        
        <?php                     
        if($item->tipo === 'produto')
            {
                $valorProdutos += $item->preco_total_vendido;
            
            } else
            {
                $valorServicos += $item->preco_total_vendido;
            }
        
        ?>
        <tr>
            <!-- 0 Item -->
            <td><?php echo ellipsize($item->nome, 30); ?></th>
            <!-- 1 Tipo -->
            <td><?php echo esc(ucfirst($item->tipo)); ?></td>
            <!-- 2 Preço do item vendido -->
            <td>R$ <?php echo esc(number_format($item->preco_vendido, 2)); ?></td>
            <!-- 3 Quantidade de itens -->
            <td> <?php echo $item->item_quantidade; ?></td>
            <!-- 4 Preço que foi vendido -->
            <td>R$ <?php echo esc(number_format($item->preco_total_vendido, 2)) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right;">
                <label><b> Valor Produtos: </b></label>
            </td>

            <td>R$ <?php echo esc(number_format($valorProdutos, 2)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right;">
                <label><b> Valor Serviços:</b> </label>
            </td>

            <td >R$ <?php echo esc(number_format($valorServicos, 2)); ?>
            </td>
        </tr>

        <?php  if($ordem->valor_desconto !== null || 0): ?>
        <!-- Valor do desconto -->
        <tr>
            <td colspan="4" style="text-align: right;">
                <label><b> Valor Desconto: </b></label>
            </td>
            <td>
                R$ <?php echo esc(number_format($ordem->valor_desconto, 2)); ?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td colspan="4" style="text-align: right;">
                <label><b> Valor Total da OS: </b></label>
            </td>
            <td>
                R$ <?php echo esc(number_format($valorServicos + $valorProdutos, 2)); ?>
            </td>
        </tr>

        <!-- TR - VALOR TOTAL  -->
        <tr>
            <td colspan="4" style="text-align: right;">
                <label><?php echo ($ordem->valor_desconto == null || 0 ? '<b> Valor Total:</b> ' : '<b>Valor Total Com Desconto: </b>') ?>
                </label>
            </td>
            <td>R$ <?php 
                        $valorItens = $valorServicos + $valorProdutos;        
                        echo esc(number_format($valorItens - $ordem->valor_desconto, 2)); 
                
                    ?>
            </td>
        </tr>

    </tfoot>

</table>
