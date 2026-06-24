<?php
$animalId = (int) setValue('id', 0);

$tagsPos  = json_decode(setValue('caracteristicas_positivas', '[]'), true) ?: [];
$tagsNeg  = json_decode(setValue('pontos_atencao',            '[]'), true) ?: [];
$compat   = json_decode(setValue('compatibilidade',           '[]'), true) ?: [];

$compatOpcoes = [
    'criancas'   => 'Convive com crianças',
    'cachorros'  => 'Convive com outros cachorros',
    'gatos'      => 'Convive com gatos',
    'sozinho'    => 'Pode ficar sozinho',
    'apartamento'=> 'Indicado para apartamento',
];
?>

<div class="cad-animal-wrap">

    <?= exibeAlerta() ?>

    <form method="POST"
          action="<?= baseUrl() ?>Animal/<?= $action ?>"
          enctype="multipart/form-data"
          id="formAnimal">

        <?= csrfField() ?>

        <input type="hidden" name="id" value="<?= $animalId ?>">
        <input type="hidden" name="caracteristicas_positivas"
               id="inputTagsPos" value="<?= htmlspecialchars(setValue('caracteristicas_positivas', '[]')) ?>">
        <input type="hidden" name="pontos_atencao"
               id="inputTagsNeg" value="<?= htmlspecialchars(setValue('pontos_atencao', '[]')) ?>">

        <div class="cad-animal-card">

            <div class="animal-form-section">
                <div class="animal-section-title">Fotos do animal</div>
                <div class="animal-section-sub">Adicione de 1 a 8 fotos. A primeira será a imagem de capa.</div>

                <div class="photo-zone" id="dropzone"
                     onclick="document.getElementById('fileInput').click()"
                     ondragover="event.preventDefault(); this.classList.add('drag')"
                     ondragleave="this.classList.remove('drag')"
                     ondrop="handleDrop(event)">
                    <input type="file" id="fileInput" name="fotos[]"
                           multiple accept="image/jpeg,image/png,image/webp"
                           onchange="handleFiles(this.files)">
                    <h3>Arraste fotos aqui ou clique para selecionar</h3>
                    <p>JPG, PNG ou WEBP · máx. <?= FILE_MAXSIZE ?>MB cada</p>
                    <div class="file-types">
                        <span class="file-type">JPG</span>
                        <span class="file-type">PNG</span>
                        <span class="file-type">WEBP</span>
                        <span class="file-type">até <?= FILE_MAXSIZE ?>MB</span>
                    </div>
                </div>

                <div class="photo-previews" id="photoGrid" style="display:none"></div>

                <?php if (!empty($aFotos)): ?>
                <div class="fotos-existentes">
                    <div style="font-size:13px;font-weight:700;color:var(--gray-600);margin-bottom:8px;">
                        Fotos cadastradas
                    </div>
                    <div class="fotos-existentes-grid">
                        <?php foreach ($aFotos as $foto): ?>
                        <div class="foto-existente">
                            <img src="/uploads/animais/<?= $animalId ?>/<?= $foto['nomearquivo'] ?>"
                                 alt="Foto do animal">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?= setMsgFilderError('fotos') ?>
            </div>

            <div class="animal-form-section">
                <div class="animal-section-title">Informações básicas</div>

                <div style="margin-bottom:20px;">
                    <div class="an-field" style="margin-bottom:8px;">
                        <label>Espécie <span class="required">*</span></label>
                    </div>
                    <div class="pill-group">
                        <?php
                        $especies = ['cachorro' => 'Cachorro', 'gato' => 'Gato',
                                     'coelho' => 'Coelho', 'outro' => 'Outro'];
                        foreach ($especies as $val => $label):
                            $chk = setValue('especie', 'cachorro') === $val ? 'checked' : '';
                        ?>
                        <div class="pill">
                            <input type="radio" name="especie"
                                   id="e-<?= $val ?>" value="<?= $val ?>" <?= $chk ?>>
                            <label for="e-<?= $val ?>"><?= $label ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?= setMsgFilderError('especie') ?>
                </div>

                <div class="form-grid grid-2" style="margin-bottom:18px;">
                    <div class="an-field">
                        <label for="nome">Nome do animal <span class="required">*</span></label>
                        <input type="text" id="nome" name="nome" maxlength="60"
                               placeholder="Ex: Monica, Thor, Mel…"
                               value="<?= setValue('nome') ?>" required>
                        <?= setMsgFilderError('nome') ?>
                    </div>
                    <div class="an-field">
                        <label for="raca">Raça</label>
                        <input type="text" id="raca" name="raca" maxlength="60"
                               placeholder="Ex: Border Collie, SRD…"
                               value="<?= setValue('raca') ?>">
                        <?= setMsgFilderError('raca') ?>
                    </div>
                </div>

                <div class="form-grid grid-3">
                    <div class="an-field">
                        <label>Sexo <span class="required">*</span></label>
                        <div class="pill-group" style="margin-top:2px;">
                            <?php foreach (['femea' => 'Fêmea', 'macho' => 'Macho'] as $val => $label):
                                $chk = setValue('sexo', 'femea') === $val ? 'checked' : ''; ?>
                            <div class="pill">
                                <input type="radio" name="sexo"
                                       id="s-<?= $val ?>" value="<?= $val ?>" <?= $chk ?>>
                                <label for="s-<?= $val ?>"><?= $label ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?= setMsgFilderError('sexo') ?>
                    </div>
                    <div class="an-field">
                        <label>Fase de vida <span class="required">*</span></label>
                        <div class="pill-group" style="margin-top:2px;">
                            <?php foreach (['filhote' => 'Filhote', 'adulto' => 'Adulto', 'idoso' => 'Idoso'] as $val => $label):
                                $chk = setValue('fase_vida', 'adulto') === $val ? 'checked' : ''; ?>
                            <div class="pill">
                                <input type="radio" name="fase_vida"
                                       id="fv-<?= $val ?>" value="<?= $val ?>" <?= $chk ?>>
                                <label for="fv-<?= $val ?>"><?= $label ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?= setMsgFilderError('fase_vida') ?>
                    </div>
                    <div class="an-field">
                        <label>Idade aproximada</label>
                        <div style="display:flex; gap:8px; width: 50px; margin-right: 200px;">
                            <input type="number" name="idade" min="0" max="30"
                                   placeholder="0"
                                   value="<?= setValue('idade') ?>"
                                   style="width:72px; text-align:center; flex-shrink:0;">
                            <select name="unidade_idade" style="flex:1;">
                                <option value="meses" <?= setValue('unidade_idade') === 'meses' ? 'selected' : '' ?>>meses</option>
                                <option value="anos"  <?= setValue('unidade_idade') === 'anos'  ? 'selected' : '' ?>>anos</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="inner-divider"></div>

                <div class="form-grid grid-2">
                    <div class="an-field">
                        <label>Porte <span class="required">*</span></label>
                        <div class="pill-group">
                            <?php foreach (['pequeno' => 'Pequeno', 'medio' => 'Médio', 'grande' => 'Grande'] as $val => $label):
                                $chk = setValue('porte', 'medio') === $val ? 'checked' : ''; ?>
                            <div class="pill">
                                <input type="radio" name="porte"
                                       id="p-<?= $val ?>" value="<?= $val ?>" <?= $chk ?>>
                                <label for="p-<?= $val ?>"><?= $label ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?= setMsgFilderError('porte') ?>
                    </div>
                    <div class="an-field-pelagem">
                        <label for="pelagem">Pelagem / cor</label>
                        <input type="text" id="pelagem" name="pelagem" maxlength="60"
                               placeholder="Ex: Tricolor, caramelo, preto e branco…"
                               value="<?= setValue('pelagem') ?>">
                    </div>
                </div>
            </div>

            <!-- ── PERSONALIDADE ──────────────────────────────────── -->
            <div class="animal-form-section">
                <div class="animal-section-title">Personalidade e características</div>

                <div class="form-grid" style="margin-bottom:18px;">
                    <div class="an-field">
                        <label>A história do animal</label>
                        <textarea name="historia"
                                  placeholder="Conte sobre a história, de onde veio, como foi resgatado…"><?= setValue('historia') ?></textarea>
                    </div>
                </div>

                <div class="form-grid grid-2">
                    <div class="an-field">
                        <label>Características positivas</label>
                        <div class="tags-wrap" id="posTagsWrap"
                             onclick="this.querySelector('.tags-input').focus()">
                            <input class="tags-input" id="posInput"
                                   placeholder="Digite e pressione Enter…"
                                   onkeydown="addTag(event,'pos')">
                        </div>
                        <div class="suggestions">
                            <button type="button" class="sug-btn pos" onclick="quickTag('pos','Dócil')">+ Dócil</button>
                            <button type="button" class="sug-btn pos" onclick="quickTag('pos','Calmo')">+ Calmo</button>
                            <button type="button" class="sug-btn pos" onclick="quickTag('pos','Brincalhão')">+ Brincalhão</button>
                            <button type="button" class="sug-btn pos" onclick="quickTag('pos','Carinhoso')">+ Carinhoso</button>
                        </div>
                    </div>
                    <div class="an-field">
                        <label>Pontos de atenção</label>
                        <div class="tags-wrap" id="negTagsWrap"
                             onclick="this.querySelector('.tags-input').focus()">
                            <input class="tags-input" id="negInput"
                                   placeholder="Digite e pressione Enter…"
                                   onkeydown="addTag(event,'neg')">
                        </div>
                        <div class="suggestions">
                            <button type="button" class="sug-btn neg" onclick="quickTag('neg','Morde objetos')">+ Morde objetos</button>
                            <button type="button" class="sug-btn neg" onclick="quickTag('neg','Tímido')">+ Tímido</button>
                            <button type="button" class="sug-btn neg" onclick="quickTag('neg','Latidor')">+ Latidor</button>
                        </div>
                    </div>
                </div>

                <div class="inner-divider"></div>

                <div class="an-field">
                    <label>Compatibilidade</label>
                    <div class="check-group">
                        <?php foreach ($compatOpcoes as $val => $label):
                            $chk = in_array($val, $compat) ? 'checked' : ''; ?>
                        <label class="check-item">
                            <input type="checkbox" name="compatibilidade[]"
                                   value="<?= $val ?>" <?= $chk ?>>
                            <?= $label ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- ── SAÚDE ──────────────────────────────────────────── -->
            <div class="animal-form-section">
                <div class="animal-section-title">Saúde e condição</div>

                <div class="health-grid" style="margin-bottom:20px;">
                    <?php
                    $saudeOpcoes = [
                        'vacinado'            => ['label' => 'Vacinado',            'sub' => 'Vacinas em dia'],
                        'castrado'            => ['label' => 'Castrado',            'sub' => 'Já castrado'],
                        'necessidade_especial'=> ['label' => 'Necessidade especial','sub' => 'Requer cuidado extra'],
                        'em_tratamento'       => ['label' => 'Em tratamento',       'sub' => 'Acompanhamento ativo'],
                    ];
                    foreach ($saudeOpcoes as $campo => $info):
                        $chk = setValue($campo) ? 'checked' : '';
                    ?>
                    <div class="health-card">
                        <label>
                            <input type="checkbox" name="<?= $campo ?>"
                                   value="1" <?= $chk ?>>
                            <div class="hc-text">
                                <strong><?= $info['label'] ?></strong>
                                <span><?= $info['sub'] ?></span>
                            </div>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="an-field">
                    <label for="obs_saude">Observações de saúde</label>
                    <textarea id="obs_saude" name="obs_saude"
                              style="min-height:80px;"
                              placeholder="Doenças, alergias, medicamentos, condição especial…"><?= setValue('obs_saude') ?></textarea>
                </div>
            </div>

            <!-- ── LOCALIZAÇÃO & CONTATO ──────────────────────────── -->
            <div class="animal-form-section">
                <div class="animal-section-title">Localização e contato</div>
                <div class="animal-section-sub">Onde o animal está e como o adotante pode entrar em contato</div>

                <div class="form-grid grid-3" style="margin-bottom:18px;">
                    <div class="an-field">
                        <label for="estado">Estado <span class="required">*</span></label>
                        <select id="estado" name="estado" required>
                            <option value="">Selecione</option>
                            <?php
                            $estados = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA',
                                        'MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN',
                                        'RS','RO','RR','SC','SP','SE','TO'];
                            foreach ($estados as $uf):
                                $sel = setValue('estado') === $uf ? 'selected' : '';
                            ?>
                                <option value="<?= $uf ?>" <?= $sel ?>><?= $uf ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= setMsgFilderError('estado') ?>
                    </div>
                    <div class="an-field">
                        <label for="cidade">Cidade <span class="required">*</span></label>
                        <input type="text" id="cidade" name="cidade" maxlength="100"
                               placeholder="Nome da cidade"
                               value="<?= setValue('cidade') ?>" required>
                        <?= setMsgFilderError('cidade') ?>
                    </div>
                    <div class="an-field">
                        <label for="bairro">Bairro / Região</label>
                        <input type="text" id="bairro" name="bairro" maxlength="100"
                               placeholder="Opcional"
                               value="<?= setValue('bairro') ?>">
                    </div>
                </div>

                <div class="form-grid grid-2" style="margin-bottom:18px;">
                    <div class="an-field">
                        <label for="ong_id">ONG responsável <span class="required">*</span></label>
                        <select id="ong_id" name="ong_id" required>
                            <option value="">Selecione a ONG…</option>
                            <?php foreach ($aOngs as $ong):
                                $sel = (int) setValue('ong_id') === (int) $ong['id'] ? 'selected' : ''; ?>
                            <option value="<?= $ong['id'] ?>" <?= $sel ?>><?= $ong['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= setMsgFilderError('ong_id') ?>
                    </div>
                    <div class="an-field">
                        <label for="statusRegistro">Status <span class="required">*</span></label>
                        <select id="statusRegistro" name="statusRegistro" required>
                            <?php foreach ($aStatus as $key => $value):
                                $sel = (int) setValue('statusRegistro', 1) === $key ? 'selected' : ''; ?>
                            <option value="<?= $key ?>" <?= $sel ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= setMsgFilderError('statusRegistro') ?>
                    </div>
                </div>

                <div class="form-grid grid-2">
                    <div class="an-field">
                        <label for="responsavel">Responsável / ONG <span class="required">*</span></label>
                        <input type="text" id="responsavel" name="responsavel" maxlength="100"
                               placeholder="Nome do tutor ou organização"
                               value="<?= setValue('responsavel') ?>" required>
                        <?= setMsgFilderError('responsavel') ?>
                    </div>
                    <div class="an-field">
                        <label for="contato">WhatsApp ou e-mail de contato <span class="required">*</span></label>
                        <input type="text" id="contato" name="contato" maxlength="150"
                               placeholder="(21) 99999-9999 ou email@exemplo.com"
                               value="<?= setValue('contato') ?>" required>
                        <?= setMsgFilderError('contato') ?>
                    </div>
                </div>
            </div>

            <div class="animal-form-footer">
                <a href="<?= baseUrl() ?>Adocao" class="btn btn-outline">Voltar</a>
                <div class="footer-actions">
                    <button type="submit" class="btn-animal-primary">
                        <?= $action === 'insert' ? 'Publicar animal' : 'Salvar alterações' ?>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let photos = [];

function handleFiles(files) {
    Array.from(files).forEach(function (f) {
        if (photos.length >= 8) return;
        photos.push({ url: URL.createObjectURL(f), name: f.name });
    });
    renderPreviews();
}

function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropzone').classList.remove('drag');
    handleFiles(e.dataTransfer.files);
}

function renderPreviews() {
    var grid = document.getElementById('photoGrid');
    var zone = document.getElementById('dropzone');
    if (photos.length === 0) { grid.style.display = 'none'; zone.style.display = 'flex'; return; }
    zone.style.display = 'none';
    grid.style.display = 'grid';
    grid.innerHTML = '';
    photos.forEach(function (p, i) {
        var d = document.createElement('div');
        d.className = 'preview-thumb';
        d.innerHTML = '<img src="' + p.url + '" alt="' + p.name + '">'
            + (i === 0 ? '<div class="badge-main">Capa</div>' : '')
            + '<button type="button" class="btn-remove" onclick="removePhoto(' + i + ')">✕</button>';
        grid.appendChild(d);
    });
    if (photos.length < 8) {
        var add = document.createElement('div');
        add.className = 'preview-add';
        add.textContent = '+';
        add.onclick = function () { document.getElementById('fileInput').click(); };
        grid.appendChild(add);
    }
}

function removePhoto(i) { photos.splice(i, 1); renderPreviews(); }

var tagsData = {
    pos: <?= json_encode($tagsPos) ?>,
    neg: <?= json_encode($tagsNeg) ?>
};

function addTag(e, type) {
    if (e.key !== 'Enter') return;
    e.preventDefault();
    var input = document.getElementById(type + 'Input');
    var val = input.value.trim();
    if (!val) return;
    tagsData[type].push(val);
    input.value = '';
    renderTags(type);
}

function quickTag(type, val) {
    if (tagsData[type].includes(val)) return;
    tagsData[type].push(val);
    renderTags(type);
}

function removeTag(type, i) { tagsData[type].splice(i, 1); renderTags(type); }

function renderTags(type) {
    var wrap = document.getElementById(type + 'TagsWrap');
    var input = document.getElementById(type + 'Input');
    Array.from(wrap.querySelectorAll('.atag')).forEach(function (t) { t.remove(); });
    tagsData[type].forEach(function (t, i) {
        var chip = document.createElement('span');
        chip.className = 'atag ' + type;
        chip.innerHTML = t + ' <span class="rm" onclick="removeTag(\'' + type + '\',' + i + ')">✕</span>';
        wrap.insertBefore(chip, input);
    });
}

renderTags('pos');
renderTags('neg');

document.getElementById('formAnimal').addEventListener('submit', function () {
    document.getElementById('inputTagsPos').value = JSON.stringify(tagsData.pos);
    document.getElementById('inputTagsNeg').value = JSON.stringify(tagsData.neg);
});
</script>
