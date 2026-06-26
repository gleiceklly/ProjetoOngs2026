<h1 style="padding-top: 55px; display: flex; justify-content: center; padding-left: 25px; margin-bottom: -70px; color: #86c7df"><i class="fa-solid fa-paw"></i> Painel do Administrador <i class="fa-solid fa-paw"></i></h1>

<div class="painel-container">
    <div class="grid-cards">
        
        <a href="<?= baseUrl() ?>Ong/admin" class="card-item">
            <h2>ONGs</h2>
            <p>Gerenciar organizações cadastradas.</p>
            <span class="card-btn">Gerenciar</span>
        </a>

        <a href="<?= baseUrl() ?>Animal" class="card-item">
            <h2>Animais</h2>
            <p>Gerenciar animais disponíveis para adoção.</p>
            <span class="card-btn">Gerenciar</span>
        </a>

        <a href="<?= baseUrl() ?>Voluntario/admin" class="card-item">
            <h2>Voluntários</h2>
            <p>Gerenciar inscrições de voluntários.</p>
            <span class="card-btn">Gerenciar</span>
        </a>

        <a href="<?= baseUrl() ?>Doacao/admin" class="card-item">
            <h2>Doações</h2>
            <p>Gerenciar intenções de doação registradas.</p>
            <span class="card-btn">Gerenciar</span>
        </a>

        <a href="<?= baseUrl() ?>Usuario" class="card-item">
            <h2>Usuários</h2>
            <p>Gerenciar usuários do sistema.</p>
            <span class="card-btn">Gerenciar</span>
        </a>

    </div>
</div>

<style>
    .painel-container {
        padding: 20px;
    }

    .grid-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .card-item {
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        border-radius: 14px;
        padding: 20px;
        text-decoration: none;
        color: #333;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        transition: all 0.3s ease;
        height: 160px; 
    }

    .card-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        background: linear-gradient(135deg, #f0f0f0 0%, #e6e6e6 100%);
    }

    .card-item{
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        text-align: center;
        padding: 28px 20px;
        border-radius: 18px;
    }

    .card-item::before{
        content: "\f1b0";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        inset: 0;
        color: rgba(119, 196, 219, 0.15);
        font-size: 42px;
        line-height: 52px;
        letter-spacing: 20px;
        word-spacing: 20px;
        white-space: pre-wrap;
        content:
        "\f1b0 \f1b0 \f1b0 \f1b0 \f1b0 \A"
        "\f1b0 \f1b0 \f1b0 \f1b0 \f1b0 \A"
        "\f1b0 \f1b0 \f1b0 \f1b0 \f1b0 \A"
        "\f1b0 \f1b0 \f1b0 \f1b0 \f1b0";
        pointer-events: none;
    }

    .card-item h2 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: #094f4f;
    }

    .card-item p {
        font-size: 16px;
        color: #666;
        margin: 0 0 10px 0;
    }

    .card-btn {
        font-size: 17px;
        font-weight: 600;
        color: #094f4f;
        transition: transform 0.2s ease;
    }

    .card-btn::before {
        content: "→ ";
    }

    .card-btn:hover {
        transform: translateX(4px);
    }
</style>