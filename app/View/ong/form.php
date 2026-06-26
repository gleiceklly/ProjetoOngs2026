<?php
$selectedAnimais = json_decode(setValue('animais_tipos', '[]'), true) ?: [];
$selectedAtiv    = json_decode(setValue('atividades',    '[]'), true) ?: [];
$fotoAtual       = setValue('foto');
$ongId           = (int) setValue('id', 0);
?>

<div class="cad-ong-wrap">

    <?= exibeAlerta() ?>

    <form method="POST"
          action="<?= baseUrl() ?>Ong/<?= $action ?>"
          enctype="multipart/form-data">

        <?= csrfField() ?>

        <input type="hidden" name="id" value="<?= $ongId ?>">

        <div class="cad-card-foto">
            <div class="cad-card-header">
                <div class="cad-card-title">Identidade da ONG</div>
                <div class="cad-card-subtitle">Informações que aparecerão no perfil público</div>
            </div>
            <div class="cad-card-body">

                <div class="foto-row">
                    <div class="foto-preview" id="fotoPreview">
                        <?php if (!empty($fotoAtual)): ?>
                            <img src="/uploads/ongs/<?= $ongId ?>/<?= $fotoAtual ?>"
                                 alt="Logo da ONG">
                        <?php else: ?>
                            <i class="fa-solid fa-paw"></i>
                        <?php endif; ?>
                    </div>
                    <div class="foto-info">
                        <p>Foto / Logotipo da ONG</p>
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

                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="cad-field">
                            <label>Nome da ONG <span class="required">*</span></label>
                            <input type="text"
                                class="form-control"
                                name="nome"
                                maxlength="100"
                                placeholder="Ex: Associação Bigodes do Bunker"
                                value="<?= setValue('nome') ?>"
                                required
                                autofocus>

                            <?= setMsgFilderError('nome') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field">
                            <label>Pix <span class="required">*</span></label>
                            <input type="text"
                                class="form-control"
                                name="pix"
                                maxlength="100"
                                placeholder="Chave Pix da ONG"
                                value="<?= setValue('pix') ?>"
                                required>

                            <?= setMsgFilderError('pix') ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="cad-field">
                            <label>Descrição / Missão <span class="required">*</span></label>

                            <textarea class="form-control"
                                    name="descricao"
                                    rows="5"
                                    placeholder="Conte a história da sua ONG, sua missão, como começou... (mínimo 100 caracteres)"><?= setValue('descricao') ?></textarea>

                            <div class="field-hint">
                                Mínimo 100 caracteres. Seja inspirador!
                            </div>

                            <?= setMsgFilderError('descricao') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cad-card">
            <div class="cad-card-header">
                <div class="cad-card-title">Localização</div>
                <div class="cad-card-subtitle">Endereço principal de atuação</div>
            </div>

            <div class="cad-card-body-local">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="cad-field">
                            <label>CEP <span class="required">*</span></label>
                            <input type="text"
                                class="form-control"
                                name="cep"
                                maxlength="9"
                                placeholder="00000-000"
                                value="<?= setValue('cep') ?>"
                                required>
                            <?= setMsgFilderError('cep') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field">
                            <label>Estado <span class="required">*</span></label>
                            <select class="form-select" name="estado" required>
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

                    <div class="col-md-3">
                        <div class="cad-field">
                            <label>Cidade <span class="required">*</span></label>
                            <input type="text"
                                class="form-control"
                                name="cidade"
                                maxlength="100"
                                placeholder="Ex: Rio de Janeiro"
                                value="<?= setValue('cidade') ?>"
                                required>
                            <?= setMsgFilderError('cidade') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field">
                            <label>Bairro</label>
                            <input type="text"
                                class="form-control"
                                name="bairro"
                                maxlength="100"
                                placeholder="Ex: Copacabana"
                                value="<?= setValue('bairro') ?>">
                            <?= setMsgFilderError('bairro') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field-local">
                            <label>Rua / Logradouro</label>
                            <input type="text"
                                class="form-control"
                                name="logradouro"
                                maxlength="255"
                                placeholder="Ex: Av. Nossa Senhora de Copacabana"
                                value="<?= setValue('logradouro') ?>">
                            <?= setMsgFilderError('logradouro') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field-local">
                            <label>Número</label>
                            <input type="text"
                                class="form-control"
                                name="numero"
                                maxlength="20"
                                placeholder="Ex: 1200"
                                value="<?= setValue('numero') ?>">
                            <?= setMsgFilderError('numero') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field-local">
                            <label>Complemento</label>
                            <input type="text"
                                class="form-control"
                                name="complemento"
                                maxlength="100"
                                placeholder="Bloco, apartamento, sala..."
                                value="<?= setValue('complemento') ?>">
                            <?= setMsgFilderError('complemento') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field-local">
                            <label>Área de atuação <span class="required">*</span></label>
                            <select class="form-select" name="area_atuacao" required>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="cad-card">
            <div class="cad-card-header">
                <div class="cad-card-title">Animais &amp; Atividades</div>
                <div class="cad-card-subtitle">O que sua ONG faz e com quais animais trabalha</div>
            </div>
            <div class="cad-card-body">
                <div class="cad-field-animais-atend">
                    <label>Tipos de animais atendidos <span class="required">*</span></label>
                    <div class="animal-grid">
                        <?php
                        $tiposAnimais = [
                            'gatos'     => ['icon' => '<i class="fa-solid fa-cat"></i>',    'label' => 'Gatos'],
                            'caes'      => ['icon' => '<i class="fa-solid fa-dog"></i>',    'label' => 'Cães'],
                            'aves'      => ['icon' => '<i class="fa-solid fa-dove"></i>',   'label' => 'Aves'],
                            'coelhos'   => ['icon' => '<i class="fa-solid fa-paw"></i>',    'label' => 'Coelhos'],
                            'silvestres'=> ['icon' => '<i class="fa-solid fa-feather"></i>','label' => 'Silvestres'],
                            'outros'    => ['icon' => '<i class="fa-solid fa-paw"></i>',    'label' => 'Outros'],
                        ];
                        foreach ($tiposAnimais as $val => $info):
                            $chk = in_array($val, $selectedAnimais) ? 'checked' : '';
                        ?>
                            <input type="checkbox" class="animal-option"
                                   id="a-<?= $val ?>" name="animais_tipos[]"
                                   value="<?= $val ?>" <?= $chk ?>>
                            <label class="animal-label" for="a-<?= $val ?>">
                                <span class="icon"><?= $info['icon'] ?></span>
                                <span><?= $info['label'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?= setMsgFilderError('animais_tipos') ?>
                </div>

                <div class="field-row cols-2" style="margin-top:-80px; margin-left: -100px;">
                    <div class="cad-field">
                        <label>Animais disponíveis atualmente</label>
                        <input type="number" name="animais_qtd" min="0"
                               placeholder="Ex: 24"
                               value="<?= setValue('animais_qtd') ?>">
                        <?= setMsgFilderError('animais_qtd') ?>
                    </div>
                </div>

                <div class="section-divider" style="margin-top:24px;">
                    <span>Atividades desenvolvidas</span>
                </div>

                <div class="cad-field">
                    <label>Selecione as atividades da ONG <span class="required">*</span></label>
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
                                   id="at-<?= $val ?>" name="atividades[]"
                                   value="<?= $val ?>" <?= $chk ?>>
                            <label class="ativ-label" for="at-<?= $val ?>">
                                <?= $label ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?= setMsgFilderError('atividades') ?>
                </div>

            </div>
        </div>

        <div class="cad-card">
            <div class="cad-card-header">
                <div class="cad-card-title">Contato &amp; Responsável</div>
                <div class="cad-card-subtitle">Como as pessoas podem entrar em contato com a ONG</div>
            </div>
            <div class="cad-card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="cad-field" style="margin-top: -90px;">
                            <label>Nome do responsável <span class="required">*</span></label>
                            <input type="text"
                                class="form-control"
                                name="responsavel_nome"
                                maxlength="100"
                                placeholder="Nome completo"
                                value="<?= setValue('responsavel_nome') ?>"
                                required>
                            <?= setMsgFilderError('responsavel_nome') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field" style="margin-top: -90px;">
                            <label>Cargo / Função</label>
                            <input type="text"
                                class="form-control"
                                name="responsavel_cargo"
                                maxlength="100"
                                placeholder="Ex: Presidenta, Coordenadora..."
                                value="<?= setValue('responsavel_cargo') ?>">
                            <?= setMsgFilderError('responsavel_cargo') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field" style="margin-top: -90px;">
                            <label>E-mail de contato <span class="required">*</span></label>
                            <input type="email"
                                class="form-control"
                                name="email"
                                maxlength="150"
                                placeholder="contato@suaong.org.br"
                                value="<?= setValue('email') ?>"
                                required>
                            <?= setMsgFilderError('email') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="cad-field" style="margin-top: -90px;">
                            <label>Telefone / WhatsApp <span class="required">*</span></label>
                            <input type="tel"
                                class="form-control"
                                name="telefone"
                                maxlength="20"
                                placeholder="(21) 99999-9999"
                                value="<?= setValue('telefone') ?>"
                                required>
                            <?= setMsgFilderError('telefone') ?>
                        </div>
                    </div>
                </div>

                <div class="section-divider" style="margin-top:-70px;">
                    <span>Redes sociais</span>
                </div>

                <div class="social-row" style="margin-top:-20px;">
                    <div class="social-icon-wrap fb">
                        <i class="fa-brands fa-facebook"></i>
                    </div>
                    <div class="cad-field">
                        <input type="text" name="facebook"
                               placeholder="apenas usuario ex: amicaomuriae"
                               value="<?= setValue('facebook') ?>">
                        <?= setMsgFilderError('facebook') ?>
                    </div>
                </div>

                <div class="social-row" style="margin-top:-70px;">
                    <div class="social-icon-wrap ig">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                    <div class="cad-field">
                        <input type="text" name="instagram"
                               placeholder="apenas usuario ex: amicaomuriae"
                               value="<?= setValue('instagram') ?>">
                        <?= setMsgFilderError('instagram') ?>
                    </div>
                </div>

                <div class="social-row" style="margin-top:-70px;">
                    <div class="social-icon-wrap fb">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="cad-field">
                        <input type="url" name="site"
                               placeholder="https://www.suaong.org.br"
                               value="<?= setValue('site') ?>">
                        <?= setMsgFilderError('site') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="cad-card" style="max-height: 350px;">
            <div class="cad-card-header">
                <div class="cad-card-title">Horário de Atendimento</div>
                <div class="cad-card-subtitle">Quando sua ONG pode ser contatada ou visitada</div>
            </div>
            <div class="cad-card-body">
                <div class="cad-field" style="margin-top:-70px;">
                    <label>Horários de funcionamento</label>
                    <input type="text" name="horarios" maxlength="255"
                           placeholder="Ex: Seg–Sex 9h–18h · Sáb 9h–12h"
                           value="<?= setValue('horarios') ?>">
                    <div class="field-hint">Descreva livremente os dias e horários de atendimento.</div>
                    <?= setMsgFilderError('horarios') ?>
                </div>
            </div>
        </div>

        <?php if ($action === 'insert'): ?>
        <div class="cad-card">
            <div class="cad-card-header">
                <div class="cad-card-title">Acesso da ONG</div>
                <div class="cad-card-subtitle">Crie a senha de login. O e-mail de contato acima será seu usuário de acesso.</div>
            </div>
            <div class="cad-card-body">
                <div class="field-row cols-2">
                    <div class="cad-field">
                        <label>Senha <span class="required">*</span></label>
                        <input type="password" name="senha" minlength="8" maxlength="100"
                               placeholder="Mínimo 8 caracteres" required>
                        <div class="field-hint">Mín. 8 caracteres, com maiúscula, minúscula, número e símbolo.</div>
                        <?= setMsgFilderError('senha') ?>
                    </div>
                    <div class="cad-field">
                        <label>Confirmar senha <span class="required">*</span></label>
                        <input type="password" name="confirmarSenha" minlength="8" maxlength="100"
                               placeholder="Repita a senha" required>
                        <?= setMsgFilderError('confirmarSenha') ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="cad-card">
            <div class="cad-card-body">
                <div class="terms-row">
                    <input type="checkbox" id="t1" name="t1" value="1"
                           <?= !empty(setValue('t1')) ? 'checked' : '' ?>>
                    <label for="t1">Confirmo que sou responsável legal por esta ONG e que todas as informações fornecidas são verdadeiras e atualizadas.</label>
                </div>
                <div class="terms-row">
                    <input type="checkbox" id="t2" name="t2" value="1"
                           <?= !empty(setValue('t2')) ? 'checked' : '' ?>>
                    <label for="t2">Li e concordo com os <a href="#">Termos de Uso</a> e a <a href="#">Política de Privacidade</a> da plataforma.</label>
                </div>
                <div class="terms-row">
                    <input type="checkbox" id="t3" name="t3" value="1"
                           <?= !empty(setValue('t3')) ? 'checked' : '' ?>>
                    <label for="t3">Autorizo a plataforma a exibir publicamente as informações da ONG para fins de divulgação de adoção responsável.</label>
                </div>
            </div>
            <div class="cad-submit-bar">
                <a href="<?= baseUrl() ?>Ong" class="btn btn-outline-secondary">Voltar</a>
                <button type="submit" class="btn-cad-submit">
                    <?= $action === 'insert' ? 'Cadastrar ONG' : 'Salvar alterações' ?>
                </button>
            </div>
        </div>

    </form>
</div>

<script>
document.getElementById('fotoInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const prev = document.getElementById('fotoPreview');
        prev.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
    };
    reader.readAsDataURL(file);
});
</script>
