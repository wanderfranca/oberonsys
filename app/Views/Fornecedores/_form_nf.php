<div class="row">

    <div class="form-group col-md-4">
        <label class="form-control-label">Valor da NF</label>
        <input type="text" name="valor_nota" placeholder="Insira o valor da NF" require maxlength="20" class="form-control money">
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label">Data de Emissão da NF</label>
        <input type="date" name="data_emissao" placeholder="Data da Emissão" require maxlength="20" class="form-control">
    </div>

    <div class="form-group col-md-12">
        <label class="form-control-label">PDF da NF</label>
        <input type="file" name="nota_fiscal" class="form-control" accept=".pdf,.xml">
    </div>

    <div class="form-group col-md-12">
        <label class="form-control-label">Observação da NF</label>
        <textarea name="descricao_itens" class="form-control" placeholder="Insira descrições e observações pertinentes a NF..."></textarea>
    </div>
</div>
