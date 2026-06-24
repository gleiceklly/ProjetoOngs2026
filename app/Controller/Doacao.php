<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Email;
use Core\Library\Raw;
use Core\Library\Redirect;
use Core\Library\Session;
use PHPMailer\PHPMailer\Exception as MailException;

class Doacao extends ControllerMain
{
    public function admin()
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        return $this->view('admin/listaDoacao', [
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

        return $this->view('admin/formDoacao', [
            'titulo'  => $this->model->titulo,
            'data'    => $this->model->getById((int) $id),
            'aStatus' => $this->model->listaStatus,
            'action'  => $this->action,
        ]);
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
                ['msgSucesso' => 'Registro de doação excluído com sucesso.']
            );
        }

        return Redirect::page(
            $this->controller . '/admin',
            ['msgError' => 'Falha ao excluir registro de doação.']
        );
    }

    public function index()
    {
        $modelOng = $this->loadModel('Ong');

        return $this->view('doacao', [
            'titulo'    => 'Doações — Patas do Bem',
            'ongs'      => $modelOng ? $modelOng->lista() : [],
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesDoacoes.css">'),
        ]);
    }

    public function insert()
    {
        $post = $this->request->getPost();
        $post['statusRegistro'] = 1;

        if (!$this->model->insert($post)) {
            return Redirect::page('Doacao', ['msgError' => 'Verifique os campos obrigatórios e tente novamente.']);
        }

        $modelOng = $this->loadModel('Ong');
        $ong = ($modelOng && !empty($post['ong_id']))
            ? $modelOng->getById((int) $post['ong_id'])
            : [];

        try {
            Email::enviarEmail(
                emailRemetente: $_ENV['MAIL.USER'],
                nomeRemetente:  'Patas do Bem',
                assunto:        'Sua intenção de doação foi registrada — Patas do Bem',
                corpoEmail:     $this->corpoEmailConfirmacaoDoador($post, $ong),
                destinatario:   $post['email']
            );

            if (!empty($ong['email'])) {
                Email::enviarEmail(
                    emailRemetente: $_ENV['MAIL.USER'],
                    nomeRemetente:  'Patas do Bem',
                    assunto:        'Nova intenção de doação — ' . ($ong['nome'] ?? ''),
                    corpoEmail:     $this->corpoEmailNotificacaoOng($post, $ong),
                    destinatario:   $ong['email']
                );
            }
        } catch (\InvalidArgumentException $e) {
            error_log('[Email Doacao] ' . $e->getMessage());
        } catch (MailException $e) {
            error_log('[Email Doacao] ' . $e->getMessage());
        }

        return Redirect::page('Doacao', ['msgSucesso' => 'Intenção de doação registrada! Você receberá uma confirmação por e-mail em breve.']);
    }

    private function corpoEmailConfirmacaoDoador(array $dados, array $ong): string
    {
        $nome    = htmlspecialchars($dados['nome'],  ENT_QUOTES, 'UTF-8');
        $valor   = number_format((float) $dados['valor'], 2, ',', '.');
        $plano   = $dados['plano'] === 'mensal' ? 'Mensal' : 'Única';
        $nomeOng = htmlspecialchars($ong['nome'] ?? 'ONG parceira', ENT_QUOTES, 'UTF-8');
        $pixKey  = htmlspecialchars($ong['pix'] ?? '', ENT_QUOTES, 'UTF-8');

        $pixInfo = $pixKey
            ? "<p>Use a chave PIX abaixo para realizar sua doação:<br><strong>{$pixKey}</strong></p><p>Após o pagamento, envie o comprovante para o e-mail da ONG.</p>"
            : "<p>Entre em contato com a ONG para obter a chave PIX e realizar sua doação.</p>";

        return <<<HTML
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Doação registrada</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
                .header { background-color: #fcd444; color: #333333; padding: 24px 32px; }
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
                    <h1>Intenção de doação registrada!</h1>
                </div>
                <div class="body">
                    <p>Olá, <strong>{$nome}</strong>! Sua intenção de doação foi registrada com sucesso.</p>
                    <div class="field">
                        <div class="field-label">ONG</div>
                        <div class="field-value">{$nomeOng}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Valor</div>
                        <div class="field-value">R$ {$valor}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Plano</div>
                        <div class="field-value">{$plano}</div>
                    </div>
                    {$pixInfo}
                    <p>Obrigado por apoiar a causa animal!</p>
                </div>
                <div class="footer">Patas do Bem — juntos por uma causa animal</div>
            </div>
        </body>
        </html>
        HTML;
    }

    private function corpoEmailNotificacaoOng(array $dados, array $ong): string
    {
        $nome     = htmlspecialchars($dados['nome'],     ENT_QUOTES, 'UTF-8');
        $email    = htmlspecialchars($dados['email'],    ENT_QUOTES, 'UTF-8');
        $telefone = htmlspecialchars($dados['telefone'], ENT_QUOTES, 'UTF-8');
        $cpf      = htmlspecialchars($dados['cpf'],      ENT_QUOTES, 'UTF-8');
        $valor    = number_format((float) $dados['valor'], 2, ',', '.');
        $plano    = $dados['plano'] === 'mensal' ? 'Mensal' : 'Única';
        $nomeOng  = htmlspecialchars($ong['nome'] ?? '', ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Nova intenção de doação</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
                .header { background-color: #fcd444; color: #333333; padding: 24px 32px; }
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
                    <h1>Nova intenção de doação — {$nomeOng}</h1>
                </div>
                <div class="body">
                    <div class="field">
                        <div class="field-label">Nome</div>
                        <div class="field-value">{$nome}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">CPF/CNPJ</div>
                        <div class="field-value">{$cpf}</div>
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
                        <div class="field-label">Valor da Intenção</div>
                        <div class="field-value">R$ {$valor}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Plano</div>
                        <div class="field-value">{$plano}</div>
                    </div>
                    <p style="color:#888;font-size:0.9rem;">Este é um registro de intenção. Confirme o recebimento do PIX antes de processar a doação.</p>
                </div>
                <div class="footer">Notificação automática — Patas do Bem</div>
            </div>
        </body>
        </html>
        HTML;
    }
}
