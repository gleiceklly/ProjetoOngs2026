<div class="login-split">

    <div class="login-brand-panel-cadastro">
        <div class="brand-logo"><i class="fa-solid fa-paw"></i> Patas<span>doBem</span></div>
        <h1 class="brand-headline">Crie sua<br>conta e faça<br>a diferença</h1>
        <p class="brand-description">
            Com uma conta no Patas do Bem você pode acompanhar adoções,
            se inscrever como voluntário e ajudar ONGs de animais da sua cidade.
        </p>
    </div>

    <div class="login-form-panel">
        <div class="login-card">

            <h2>Criar conta</h2>
            <p class="login-subtitle">Preencha os campos abaixo para se cadastrar.</p>

            <?= exibeAlerta() ?>

            <div class="tipo-conta-toggle" id="tipoConta">
                <button type="button" class="tipo-btn active" data-tipo="usuario">
                    <i class="fa-solid fa-user"></i> Usuário
                </button>
                <button type="button" class="tipo-btn" data-tipo="ong">
                    <i class="fa-solid fa-paw"></i> ONG
                </button>
            </div>
            <input type="hidden" name="_tipo" id="inputTipo" value="usuario">

            <form id="formUsuario" method="POST" action="<?= baseUrl() ?>Login/cadastrar">
                <?= csrfField() ?>
                <input type="hidden" name="_tipo" value="usuario">

                <div class="mb-3">
                    <label for="nome">Nome completo</label>
                    <input type="text" class="form-control" name="nome" id="nome"
                           placeholder="Seu nome completo"
                           value="<?= setValue('nome') ?>"
                           minlength="3" maxlength="60" required autofocus>
                    <?= setMsgFilderError('nome') ?>
                </div>

                <div class="mb-3">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email"
                           placeholder="seu@email.com"
                           value="<?= setValue('email') ?>"
                           maxlength="150" required>
                    <?= setMsgFilderError('email') ?>
                </div>

                <div class="mb-3">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha"
                           placeholder="Mínimo 8 caracteres" maxlength="100" required>
                    <?= setMsgFilderError('senha') ?>
                </div>

                <div class="mb-3">
                    <label for="confirmarSenha">Confirmar senha</label>
                    <input type="password" class="form-control" name="confirmarSenha" id="confirmarSenha"
                           placeholder="Repita a senha" maxlength="100" required>
                    <?= setMsgFilderError('confirmarSenha') ?>
                </div>

                <?= jsPasswordStrength('senha', 'confirmarSenha', true) ?>

                <div class="mt-4 mb-2">
                    <button type="submit" class="btn-login">Criar conta</button>
                </div>

                <div class="login-footer-links">
                    <a href="<?= baseUrl() ?>">← Voltar ao site</a>
                    <a href="<?= baseUrl() ?>Login">Já tenho conta</a>
                </div>
            </form>

            <form id="formOng" method="POST"
                  action="<?= baseUrl() ?>Ong/insert"
                  enctype="multipart/form-data"
                  style="display:none">

                <?= csrfField() ?>
                <input type="hidden" name="_tipo" value="ong">

                <?php
                $action       = 'insert';
                $selectedAnimais = json_decode(setValue('animais_tipos', '[]'), true) ?: [];
                $selectedAtiv    = json_decode(setValue('atividades',    '[]'), true) ?: [];
                $fotoAtual       = setValue('foto');
                $ongId           = 0;
                ?>

                <div class="cad-section-title">Identidade da ONG</div>

                <div class="foto-row mb-3">
                    <div class="foto-preview" id="fotoPreview">
                        <i class="fa-solid fa-paw"></i>
                    </div>  
                    <div class="foto-info">
                        <p>Foto / Logotipo</p>
                        <small>JPG, PNG ou WEBP · máx. <?= FILE_MAXSIZE ?>MB</small>
                        <div class="foto-actions">
                            <button type="button" class="btn-foto-upload"
                                    onclick="document.getElementById('fotoInput').click()">
                                Escolher arquivo
                            </button>
                        </div>
                        <input type="file" id="fotoInput" name="foto"
                               accept="image/jpeg,image/png,image/webp" style="display:none">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Nome da ONG <span class="required">*</span></label>
                    <input type="text" class="form-control" name="nome" maxlength="100"
                           placeholder="Ex: Associação Bigodes do Bunker"
                           value="<?= setValue('nome') ?>" required>
                    <?= setMsgFilderError('nome') ?>
                </div>

                <div class="mb-3">
                    <label>Pix <span class="required">*</span></label>
                    <input type="text" class="form-control" name="pix" maxlength="100"
                           placeholder="Chave Pix da ONG"
                           value="<?= setValue('pix') ?>" required>
                    <?= setMsgFilderError('pix') ?>
                </div>

                <div class="mb-3">
                    <label>Descrição / Missão <span class="required">*</span></label>
                    <textarea class="form-control" name="descricao" rows="4"
                              placeholder="Conte a história da sua ONG... (mínimo 100 caracteres)"><?= setValue('descricao') ?></textarea>
                    <div class="field-hint">Mínimo 100 caracteres.</div>
                    <?= setMsgFilderError('descricao') ?>
                </div>

                <div class="cad-section-title"><i class="fa-solid fa-location-dot"></i> Localização</div>

                <div class="field-row cols-2 mb-3">
                    <div class="cad-field">
                        <label>CEP <span class="required">*</span></label>
                        <input type="text" class="form-control" name="cep" maxlength="9"
                               placeholder="00000-000" value="<?= setValue('cep') ?>" required>
                        <?= setMsgFilderError('cep') ?>
                    </div>
                    <div class="cad-field">
                        <label>Estado <span class="required">*</span></label>
                        <select class="form-control" name="estado" required>
                            <option value="">Selecionar...</option>
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
                </div>

                <div class="field-row cols-2 mb-3">
                    <div class="cad-field">
                        <label>Cidade <span class="required">*</span></label>
                        <input type="text" class="form-control" name="cidade" maxlength="100"
                               placeholder="Ex: Rio de Janeiro"
                               value="<?= setValue('cidade') ?>" required>
                        <?= setMsgFilderError('cidade') ?>
                    </div>
                    <div class="cad-field">
                        <label>Bairro</label>
                        <input type="text" class="form-control" name="bairro" maxlength="100"
                               placeholder="Ex: Copacabana"
                               value="<?= setValue('bairro') ?>">
                        <?= setMsgFilderError('bairro') ?>
                    </div>
                </div>

                <div class="field-row cols-2 mb-3">
                    <div class="cad-field" style="grid-column: span 1;">
                        <label>Rua / Logradouro</label>
                        <input type="text" class="form-control" name="logradouro" maxlength="255"
                               placeholder="Ex: Av. Copacabana"
                               value="<?= setValue('logradouro') ?>">
                        <?= setMsgFilderError('logradouro') ?>
                    </div>
                    <div class="cad-field">
                        <label>Número</label>
                        <input type="text" class="form-control" name="numero" maxlength="20"
                               placeholder="Ex: 1200"
                               value="<?= setValue('numero') ?>">
                        <?= setMsgFilderError('numero') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Complemento</label>
                    <input type="text" class="form-control" name="complemento" maxlength="100"
                           placeholder="Bloco, apartamento, sala..."
                           value="<?= setValue('complemento') ?>">
                    <?= setMsgFilderError('complemento') ?>
                </div>

                <div class="mb-3">
                    <label>Área de atuação <span class="required">*</span></label>
                    <select class="form-control" name="area_atuacao" required>
                        <option value="">Selecionar alcance de atuação</option>
                        <?php
                        $areas = [
                            'bairro'        => 'Apenas no bairro / localidade',
                            'cidade'        => 'Cidade inteira',
                            'metropolitana' => 'Região metropolitana',
                            'estado'        => 'Estado',
                            'nacional'      => 'Nacional',
                        ];
                        foreach ($areas as $val => $label):
                            $sel = setValue('area_atuacao') === $val ? 'selected' : '';
                        ?>
                            <option value="<?= $val ?>" <?= $sel ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= setMsgFilderError('area_atuacao') ?>
                </div>

                <div class="cad-section-title"><i class="fa-solid fa-heart"></i> Animais &amp; Atividades</div>

                <div class="mb-3">
                    <label>Tipos de animais atendidos <span class="required">*</span></label>
                    <div class="animal-grid">
                        <?php
                        $tiposAnimais = [
                            'gatos'      => ['icon' => '<i class="fa-solid fa-cat"></i>',     'label' => 'Gatos'],
                            'caes'       => ['icon' => '<i class="fa-solid fa-dog"></i>',     'label' => 'Cães'],
                            'aves'       => ['icon' => '<i class="fa-solid fa-dove"></i>',    'label' => 'Aves'],
                            'coelhos'    => ['icon' => '<i class="fa-solid fa-paw"></i>',     'label' => 'Coelhos'],
                            'silvestres' => ['icon' => '<i class="fa-solid fa-feather"></i>', 'label' => 'Silvestres'],
                            'outros'     => ['icon' => '<i class="fa-solid fa-paw"></i>',     'label' => 'Outros'],
                        ];
                        foreach ($tiposAnimais as $val => $info):
                            $chk = in_array($val, $selectedAnimais) ? 'checked' : '';
                        ?>
                            <input type="checkbox" class="animal-option"
                                   id="ca-<?= $val ?>" name="animais_tipos[]"
                                   value="<?= $val ?>" <?= $chk ?>>
                            <label class="animal-label" for="ca-<?= $val ?>">
                                <span class="icon"><?= $info['icon'] ?></span>
                                <span><?= $info['label'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?= setMsgFilderError('animais_tipos') ?>
                </div>

                <div class="mb-3">
                    <label>Animais disponíveis atualmente</label>
                    <input type="number" class="form-control" name="animais_qtd" min="0"
                           placeholder="Ex: 24" value="<?= setValue('animais_qtd') ?>">
                    <?= setMsgFilderError('animais_qtd') ?>
                </div>

                <div class="mb-3">
                    <label>Atividades da ONG <span class="required">*</span></label>
                    <div class="atividade-grid">
                        <?php
                        $atividadesOpcoes = [
                            'adocao'    => 'Adoção responsável',
                            'castracao' => 'Castração gratuita',
                            'resgate'   => 'Resgate de animais',
                            'vet'       => 'Atendimento veterinário',
                            'lartmp'    => 'Lar temporário',
                            'feed'      => 'Alimentação de rua',
                        ];
                        foreach ($atividadesOpcoes as $val => $label):
                            $chk = in_array($val, $selectedAtiv) ? 'checked' : '';
                        ?>
                            <input type="checkbox" class="ativ-option"
                                   id="cat-<?= $val ?>" name="atividades[]"
                                   value="<?= $val ?>" <?= $chk ?>>
                            <label class="ativ-label" for="cat-<?= $val ?>">
                                <?= $label ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?= setMsgFilderError('atividades') ?>
                </div>

                <div class="cad-section-title"><i class="fa-solid fa-address-card"></i> Contato &amp; Responsável</div>

                <div class="field-row cols-2 mb-3">
                    <div class="cad-field">
                        <label>Nome do responsável <span class="required">*</span></label>
                        <input type="text" class="form-control" name="responsavel_nome" maxlength="100"
                               placeholder="Nome completo"
                               value="<?= setValue('responsavel_nome') ?>" required>
                        <?= setMsgFilderError('responsavel_nome') ?>
                    </div>
                    <div class="cad-field">
                        <label>Cargo / Função</label>
                        <input type="text" class="form-control" name="responsavel_cargo" maxlength="100"
                               placeholder="Ex: Presidenta, Coordenadora..."
                               value="<?= setValue('responsavel_cargo') ?>">
                        <?= setMsgFilderError('responsavel_cargo') ?>
                    </div>
                </div>

                <div class="field-row cols-2 mb-3">
                    <div class="cad-field">
                        <label>E-mail de contato <span class="required">*</span></label>
                        <input type="email" class="form-control" name="email" maxlength="150"
                               placeholder="contato@suaong.org.br"
                               value="<?= setValue('email') ?>" required>
                        <?= setMsgFilderError('email') ?>
                    </div>
                    <div class="cad-field">
                        <label>Telefone / WhatsApp <span class="required">*</span></label>
                        <input type="tel" class="form-control" name="telefone" maxlength="20"
                               placeholder="(21) 99999-9999"
                               value="<?= setValue('telefone') ?>" required>
                        <?= setMsgFilderError('telefone') ?>
                    </div>
                </div>

                <div class="social-row mb-2">
                    <div class="social-icon-wrap fb"><i class="fa-brands fa-facebook"></i></div>
                    <div class="cad-field" style="flex:1;margin:0">
                        <input type="text" class="form-control" name="facebook"
                               placeholder="https://facebook.com/suaong"
                               value="<?= setValue('facebook') ?>">
                        <?= setMsgFilderError('facebook') ?>
                    </div>
                </div>

                <div class="social-row mb-3">
                    <div class="social-icon-wrap ig"><i class="fa-brands fa-instagram"></i></div>
                    <div class="cad-field" style="flex:1;margin:0">
                        <input type="text" class="form-control" name="instagram"
                               placeholder="https://instagram.com/suaong"
                               value="<?= setValue('instagram') ?>">
                        <?= setMsgFilderError('instagram') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Site da ONG</label>
                    <input type="url" class="form-control" name="site"
                           placeholder="https://www.suaong.org.br"
                           value="<?= setValue('site') ?>">
                    <?= setMsgFilderError('site') ?>
                </div>

                <!-- HORÁRIOS -->
                <div class="cad-section-title"><i class="fa-solid fa-clock"></i> Horário de Atendimento</div>

                <div class="mb-3">
                    <label>Horários de funcionamento</label>
                    <input type="text" class="form-control" name="horarios" maxlength="255"
                           placeholder="Ex: Seg–Sex 9h–18h · Sáb 9h–12h"
                           value="<?= setValue('horarios') ?>">
                    <div class="field-hint">Descreva livremente os dias e horários de atendimento.</div>
                    <?= setMsgFilderError('horarios') ?>
                </div>

                <!-- ACESSO -->
                <div class="cad-section-title"><i class="fa-solid fa-lock"></i> Acesso da ONG</div>
                <p class="field-hint mb-3">O e-mail de contato acima será seu usuário. Crie a senha abaixo.</p>

                <div class="field-row cols-2 mb-3">
                    <div class="cad-field">
                        <label>Senha <span class="required">*</span></label>
                        <input type="password" class="form-control" name="senha"
                               minlength="8" maxlength="100"
                               placeholder="Mínimo 8 caracteres" required>
                        <div class="field-hint">Mín. 8 caracteres, maiúscula, minúscula, número e símbolo.</div>
                        <?= setMsgFilderError('senha') ?>
                    </div>
                    <div class="cad-field">
                        <label>Confirmar senha <span class="required">*</span></label>
                        <input type="password" class="form-control" name="confirmarSenha"
                               minlength="8" maxlength="100"
                               placeholder="Repita a senha" required>
                        <?= setMsgFilderError('confirmarSenha') ?>
                    </div>
                </div>

                <?= jsPasswordStrength('senha', 'confirmarSenha', true) ?>

                <div class="terms-row">
                    <input type="checkbox" id="t1" name="t1" value="1"
                           <?= !empty(setValue('t1')) ? 'checked' : '' ?>>
                    <label for="t1">Confirmo que sou responsável legal por esta ONG e que todas as informações fornecidas são verdadeiras.</label>
                </div>
                <div class="terms-row">
                    <input type="checkbox" id="t2" name="t2" value="1"
                           <?= !empty(setValue('t2')) ? 'checked' : '' ?>>
                    <label for="t2">Li e concordo com os <a href="#">Termos de Uso</a> e a <a href="#">Política de Privacidade</a>.</label>
                </div>
                <div class="terms-row">
                    <input type="checkbox" id="t3" name="t3" value="1"
                           <?= !empty(setValue('t3')) ? 'checked' : '' ?>>
                    <label for="t3">Autorizo a exibição pública das informações da ONG para fins de divulgação.</label>
                </div>

                <div class="mt-4 mb-2">
                    <button type="submit" class="btn-login">Cadastrar ONG</button>
                </div>

                <div class="login-footer-links">
                    <a href="<?= baseUrl() ?>">← Voltar ao site</a>
                    <a href="<?= baseUrl() ?>Login">Já tenho conta</a>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
(function () {
    const btns      = document.querySelectorAll('.tipo-btn');
    const formUser  = document.getElementById('formUsuario');
    const formOng   = document.getElementById('formOng');

    btns.forEach(btn => {
        btn.addEventListener('click', function () {
            btns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const tipo = this.dataset.tipo;
            if (tipo === 'ong') {
                formUser.style.display = 'none';
                formOng.style.display  = 'block';
            } else {
                formUser.style.display = 'block';
                formOng.style.display  = 'none';
            }
        });
    });

    const fotoInput = document.getElementById('fotoInput');
    if (fotoInput) {
        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                const prev = document.getElementById('fotoPreview');
                prev.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
            };
            reader.readAsDataURL(file);
        });
    }

    <?php if (setValue('_tipo') === 'ong'): ?>
    document.querySelector('[data-tipo="ong"]').click();
    <?php endif; ?>
})();
</script>