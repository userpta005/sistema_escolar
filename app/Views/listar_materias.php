<?php include 'templates/header.php'; ?>

<div class="row">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="col-md-12">
        <h2>Matérias Cadastradas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materias as $materia): ?>
                    <tr>
                        <td><?= $materia['id'] ?></td>
                        <td><?= $materia['nome'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Cadastrar Nova Matéria</h3>
        <form action="/materias/criar" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Matéria</button>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>