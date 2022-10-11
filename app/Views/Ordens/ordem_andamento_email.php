<?php $nomeCliente = (isset($ordem->cliente) ? $ordem->cliente->nome : $ordem->nome); ?>

<h3>Olá, <?php echo esc($nomeCliente); ?></h3>
<p>Até o momento a sua ordem de serviço está com o status de 
    <strong><?php echo esc(ucfirst($ordem->situacao)) ?></strong>
</p>

<p><strong>Equipamento: </strong><?php echo esc($ordem->equipamento); ?></p>
<p><strong>Defeito: </strong><?php echo esc($ordem->defeito != null ? $ordem->defeito : 'Não informado' ); ?></p>
<p><strong>Observações: </strong><?php echo esc($ordem->observacoes != null ? $ordem->observacoes : 'Não informado' ); ?></p>
<p><strong>Data de abertura: </strong><?php echo date('d/m/Y H:i', strtotime($ordem->criado_em)); ?></p>

<?php if($ordem->itens === null): ?>

    <p>Nenhum item foi adicionado à ordem de serviço, até o momento</p>

<?php else: ?>

    <?php 
        
        $valorProdutos = 0;
        $valorServicos = 0;

        foreach($ordem->itens as $item)
        {
            if($item->tipo === 'produto')
            {
                $valorProdutos += $item->preco_venda * $item->item_quantidade;
            
            } else
            {
                $valorServicos += $item->preco_venda * $item->item_quantidade;
            }
        }
    ?>

    <h3><strong>Valores até o momento: </strong></h3>

    <p><strong>Produto: </strong> R$<?php echo number_format($valorProdutos, 2) ?></p>
    <p><strong>Serviços: </strong> R$<?php echo number_format($valorServicos, 2) ?></p>
    <p><strong>Valor total: </strong> R$<?php echo number_format($valorServicos + $valorProdutos, 2) ?></p>


<?php endif; ?>

<hr>

<p>
    clique para consultar <a target="_blank" href="<?php echo site_url("ordens/minhas-ordens") ?>">seus serviços</a>
</p>

<small>Não é necessário responder este e-mail</small>