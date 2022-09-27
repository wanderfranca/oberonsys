<div class="row">
    <div class="form-group col-5">
        <label class="form-control-label">Razão Social/Nome</label>
        <input type="text" name="razao" placeholder="Insira o Nome ou Razão Social" class="form-control"
            value="<?php echo esc($configs->razao) ?>">
    </div>
    <div class="form-group col-3">
        <label class="form-control-label">CPF/CNPJ</label>
        <input type="text" name="cpf_cnpj" placeholder="CNPJ Ou CPF sem pontos ou traços" class="form-control"
            value="<?php echo esc($configs->cpf_cnpj) ?>">
    </div>
    <div class="form-group col-2">
        <label class="form-control-label">IE</label>
        <input type="text" name="ie" placeholder="Inscrição Estadual" class="form-control"
            value="<?php echo esc($configs->ie) ?>">
    </div>
    <div class="row">
        <div class="form-group col-md-2">
            <label class="form-control-label">IM</label>
            <input type="text" name="im" placeholder="Inscrição Estadual" class="form-control"
                value="<?php echo esc($configs->im) ?>">
        </div>
        <div class="form-group col-md-2">
            <label class="form-control-label">Nire</label>
            <input type="text" name="nire" placeholder="Inscrição Estadual" class="form-control"
                value="<?php echo esc($configs->nire) ?>">
        </div>
        <div class="form-group col-md-3">
            <label class="form-control-label">Data Nire</label>
            <input type="date" name="data_nire" placeholder="Inscrição Estadual" class="form-control"
                value="<?php echo esc($configs->data_nire) ?>">
        </div>

        <div class="form-group col-md-3">
                <label class="form-control-label">Regime Tributário</label>
                <select name="regime_tributario" class="form-control">
                    <option class="text-black"><?php echo $configs->regime_tributario?></option>
                            <option>simples nacional</option>
                            <option>normal</option>
                            <option>lucro presumido</option>
                            <option>indefinido</option>
                </select>
            </div>
    </div>
</div>
