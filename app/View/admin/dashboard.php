<?= formTitulo('Painel Administrativo') ?>

<div class="m-3">
    <div class="row row-cols-1 row-cols-md-3 g-4">

        <div class="col">
            <div class="card h-100 border-primary">
                <div class="card-body">
                    <h5 class="card-title">ONGs</h5>
                    <p class="card-text text-muted">Gerenciar organizações cadastradas.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= baseUrl() ?>Ong/admin" class="btn btn-primary btn-sm">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-success">
                <div class="card-body">
                    <h5 class="card-title">Animais</h5>
                    <p class="card-text text-muted">Gerenciar animais disponíveis para adoção.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= baseUrl() ?>Animal" class="btn btn-success btn-sm">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-warning">
                <div class="card-body">
                    <h5 class="card-title">Voluntários</h5>
                    <p class="card-text text-muted">Gerenciar inscrições de voluntários.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= baseUrl() ?>Voluntario/admin" class="btn btn-warning btn-sm">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-info">
                <div class="card-body">
                    <h5 class="card-title">Doações</h5>
                    <p class="card-text text-muted">Gerenciar intenções de doação registradas.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= baseUrl() ?>Doacao/admin" class="btn btn-info btn-sm">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-danger">
                <div class="card-body">
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text text-muted">Gerenciar usuários do sistema.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= baseUrl() ?>Usuario" class="btn btn-danger btn-sm">Gerenciar</a>
                </div>
            </div>
        </div>

    </div>
</div>
