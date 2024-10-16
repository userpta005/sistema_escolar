<?php include 'templates/header.php'; ?>

<div class="row">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="col-md-12">
        <h2>Alunos Cadastrados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sobrenome</th> <!-- Adicionado sobrenome -->
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= $aluno['id'] ?></td>
                        <td><?= $aluno['nome'] ?></td>
                        <td><?= $aluno['sobrenome'] ?></td> <!-- Exibir sobrenome -->
                        <td><?= $aluno['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Cadastrar Novo Aluno</h3>
        <form action="/alunos/criar" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="sobrenome" class="form-label">Sobrenome</label> <!-- Novo campo de sobrenome -->
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Aluno</button>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>