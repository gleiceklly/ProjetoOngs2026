<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Email;
use Core\Library\Raw;
use Core\Library\Redirect;
use Core\Library\Session;
use PHPMailer\PHPMailer\Exception as MailException;

class Voluntario extends ControllerMain
{
    public function admin()
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        return $this->view('admin/listaVoluntario', [
            'titulo'  => $this->model->titulo,
            'lista'   => $this->model->listaAdmin(),
            'aStatus' => $this->model->listaStatus,
        ]);
    }

    public function form($action, $id = 0)
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        $modelOng = $this->loadModel('Ong');

        return $this->view('admin/formVoluntario', [
            'titulo'  => $this->model->titulo,
            'data'    => $this->model->getById((int) $id),
            'aStatus' => $this->model->listaStatus,
            'aOngs'   => $modelOng ? $modelOng->lista() : [],
            'action'  => $this->action,
        ]);
    }

    public function update()
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        $post = $this->request->getPost();

        if ($this->model->update($post)) {
            return Redirect::page(
                $this->controller . '/admin',
                ['msgSucesso' => 'Voluntário atualizado com sucesso.']
            );
        }

        return Redirect::page(
            $this->controller . '/form/update/' . $post[$this->model->primaryKey],
            ['msgError' => 'Falha ao atualizar voluntário.']
        );
    }

    public function delete()
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        $post = $this->request->getPost();

        if ($this->model->delete($post)) {
            return Redirect::page(
                $this->controller . '/admin',
                ['msgSucesso' => 'Voluntário excluído com sucesso.']
            );
        }

        return Redirect::page(
            $this->controller . '/admin',
            ['msgError' => 'Falha ao excluir voluntário.']
        );
    }

    public function index()
    {
        $modelOng  = $this->loadModel('Ong');
        $modelVaga = $this->loadModel('Vaga');

        $todosVol    = $this->model->listaAdmin();
        $voluntarios = array_values(array_filter($todosVol, fn($v) => ($v['statusRegistro'] ?? 1) == 1));

        return $this->view('voluntario', [
            'titulo'      => 'Voluntários — Patas do Bem',
            'ongs'        => $modelOng  ? $modelOng->lista()            : [],
            'vagas'       => $modelVaga ? $modelVaga->listaPublica()    : [],
            'voluntarios' => $voluntarios,
            'extraHead'   => new Raw('<link rel="stylesheet" href="/assets/styles/stylesVoluntarios.css">'),
        ]);
    }

    public function insert()
    {
        $post = $this->request->getPost();
        $post['statusRegistro'] = 1;

        if (!$this->model->insert($post)) {
            return Redirect::page('Voluntario', ['msgError' => 'Verifique os campos obrigatórios e tente novamente.']);
        }

        $modelOng = $this->loadModel('Ong');
        $ong = ($modelOng && !empty($post['ong_id']))
            ? $modelOng->getById((int) $post['ong_id'])
            : [];

        try {
            Email::enviarEmail(
                emailRemetente: $_ENV['MAIL.USER'],
                nomeRemetente:  'Patas do Bem',
                assunto:        'Sua inscrição foi recebida — Patas do Bem',
                corpoEmail:     $this->corpoEmailConfirmacaoVoluntario($post, $ong),
                destinatario:   $post['email']
            );

            if (!empty($ong['email'])) {
                Email::enviarEmail(
                    emailRemetente: $_ENV['MAIL.USER'],
                    nomeRemetente:  'Patas do Bem',
                    assunto:        'Nova inscrição de voluntário — ' . ($ong['nome'] ?? ''),
                    corpoEmail:     $this->corpoEmailNotificacaoOng($post, $ong),
                    destinatario:   $ong['email']
                );
            }
        } catch (\InvalidArgumentException $e) {
            error_log('[Email Voluntario] ' . $e->getMessage());
        } catch (MailException $e) {
            error_log('[Email Voluntario] ' . $e->getMessage());
        }

        return Redirect::page('Voluntario', ['msgSucesso' => 'Inscrição enviada com sucesso! A ONG entrará em contato em breve.']);
    }

    private function corpoEmailConfirmacaoVoluntario(array $dados, array $ong): string
    {
        $nome    = htmlspecialchars($dados['nome'],   ENT_QUOTES, 'UTF-8');
        $funcao  = htmlspecialchars($dados['funcao'], ENT_QUOTES, 'UTF-8');
        $nomeOng = htmlspecialchars($ong['nome'] ?? 'ONG parceira', ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Inscrição recebida</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
                .header { background-color: #ffae00; color: #ffffff; padding: 24px 32px; }
                .header h1 { margin: 0; font-size: 22px; }
                .body { padding: 32px; color: #333333; }
                .field { margin-bottom: 20px; }
                .field-label { font-size: 12px; text-transform: uppercase; color: #888888; letter-spacing: 0.5px; margin-bottom: 4px; }
                .field-value { font-size: 16px; color: #222222; }
                .footer { background-color: #f0f0f0; text-align: center; padding: 16px; font-size: 12px; color: #999999; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Inscrição recebida com sucesso!</h1>
                </div>
                <div class="body">
                    <p>Olá, <strong>{$nome}</strong>! Obrigado por se inscrever como voluntário(a).</p>
                    <div class="field">
                        <div class="field-label">Função</div>
                        <div class="field-value">{$funcao}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">ONG</div>
                        <div class="field-value">{$nomeOng}</div>
                    </div>
                    <p>A equipe da ONG analisará sua inscrição e entrará em contato em breve.</p>
                </div>
                <div class="footer">Patas do Bem — juntos por uma causa animal</div>
            </div>
        </body>
        </html>
        HTML;
    }

    private function corpoEmailNotificacaoOng(array $dados, array $ong): string
    {
        $nome            = htmlspecialchars($dados['nome'],                  ENT_QUOTES, 'UTF-8');
        $email           = htmlspecialchars($dados['email'],                 ENT_QUOTES, 'UTF-8');
        $telefone        = htmlspecialchars($dados['telefone'],              ENT_QUOTES, 'UTF-8');
        $cidade          = htmlspecialchars($dados['cidade'],                ENT_QUOTES, 'UTF-8');
        $funcao          = htmlspecialchars($dados['funcao'],                ENT_QUOTES, 'UTF-8');
        $disponibilidade = htmlspecialchars($dados['disponibilidade'] ?? '—', ENT_QUOTES, 'UTF-8');
        $idade           = !empty($dados['idade']) ? (int) $dados['idade'] . ' anos' : '—';
        $mensagem        = nl2br(htmlspecialchars($dados['mensagem'] ?? '', ENT_QUOTES, 'UTF-8'));
        $nomeOng         = htmlspecialchars($ong['nome'] ?? '', ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Nova inscrição de voluntário</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
                .header { background-color: #ffae00; color: #ffffff; padding: 24px 32px; }
                .header h1 { margin: 0; font-size: 22px; }
                .body { padding: 32px; color: #333333; }
                .field { margin-bottom: 20px; }
                .field-label { font-size: 12px; text-transform: uppercase; color: #888888; letter-spacing: 0.5px; margin-bottom: 4px; }
                .field-value { font-size: 16px; color: #222222; }
                .mensagem-box { background-color: #f8f9fa; border-left: 4px solid #ffae00; padding: 16px; border-radius: 4px; font-size: 15px; line-height: 1.6; }
                .footer { background-color: #f0f0f0; text-align: center; padding: 16px; font-size: 12px; color: #999999; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Nova inscrição de voluntário — {$nomeOng}</h1>
                </div>
                <div class="body">
                    <div class="field">
                        <div class="field-label">Nome</div>
                        <div class="field-value">{$nome}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">E-mail</div>
                        <div class="field-value"><a href="mailto:{$email}">{$email}</a></div>
                    </div>
                    <div class="field">
                        <div class="field-label">Telefone</div>
                        <div class="field-value">{$telefone}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Cidade</div>
                        <div class="field-value">{$cidade}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Idade</div>
                        <div class="field-value">{$idade}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Disponibilidade</div>
                        <div class="field-value">{$disponibilidade}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Função desejada</div>
                        <div class="field-value">{$funcao}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Mensagem</div>
                        <div class="mensagem-box">{$mensagem}</div>
                    </div>
                </div>
                <div class="footer">Notificação automática — Patas do Bem</div>
            </div>
        </body>
        </html>
        HTML;
    }
}
