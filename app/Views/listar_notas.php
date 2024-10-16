<?php include 'templates/header.php'; ?>
<div class="container">
    <h2>Lista de Notas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Matéria</th>
                <th>Média</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notas as $nota): ?>
                <tr>
                    <td><?= $nota['aluno'] ?? $usuario_id; ?></td> <!-- Mostra o aluno, ou o ID do usuário se for aluno -->
                    <td><?= $nota['materia']; ?></td> <!-- Mostra o nome da matéria -->
                    <td><?= number_format($nota['media'], 2) ?></td>
                    <td>
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detalhesModal" 
                                data-aluno="<?= $nota['aluno'] ?? 'Você' ?>" 
                                data-materia-id="<?= $nota['materia_id'] ?>" 
                                data-materia="<?= $nota['materia'] ?>" 
                                data-usuario="<?= $nota['usuario_id'] ?>"> <!-- Passa o ID do usuário -->
                            Ver Detalhes
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Modal -->
    <div class="modal fade" id="detalhesModal" tabindex="-1" aria-labelledby="detalhesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalhesModalLabel">Detalhes da Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Aluno:</strong> <span id="modal-aluno"></span></p>
                    <p><strong>Matéria:</strong> <span id="modal-materia"></span></p>
                    <span id="modal-nota"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <h3>Criar Nova Nota</h3>
    <form action="/notas/create" method="POST">
        <div class="form-group">
            <label for="usuario_id">Aluno</label>
            <select name="usuario_id" class="form-control" required>
                <?php foreach ($notas as $nota): ?>
                    <option value="<?= $nota['usuario_id'] ?>"><?= $nota['aluno'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="materia_id">Matéria</label>
            <select name="materia_id" class="form-control" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?= $materia['id'] ?>"><?= $materia['nome'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="nota">Nota</label>
            <input type="number" name="nota" class="form-control" required step="0.01" min="0" max="10">
        </div>
        <button type="submit" class="btn btn-primary">Criar Nota</button>
    </form>
</div>
<?php include 'templates/footer.php'; ?>

<script>
    const detalhesModal = document.getElementById('detalhesModal');
    detalhesModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget; // Botão que acionou o modal

        const aluno = button.getAttribute('data-aluno');
        const materiaId = button.getAttribute('data-materia-id');
        const materia = button.getAttribute('data-materia');
        const usuarioId = button.getAttribute('data-usuario');

        const modalAluno = detalhesModal.querySelector('#modal-aluno');
        const modalMateria = detalhesModal.querySelector('#modal-materia');
        const modalNota = detalhesModal.querySelector('#modal-nota');

        modalAluno.textContent = aluno;
        modalMateria.textContent = materia;

        // Aqui você fará a chamada AJAX para buscar as notas
        fetch(`/notas/getNotasPorMateria/${usuarioId}/${materiaId}`)
            .then(response => response.json())
            .then(data => {
                modalNota.innerHTML = ''; // Limpa as notas anteriores
                if (data.length > 0) {
                    data.forEach(nota => {
                        modalNota.innerHTML += `<p>Nota: ${nota.nota}</p>`; // Mostra todas as notas
                    });
                } else {
                    modalNota.innerHTML = '<p>Nenhuma nota encontrada.</p>';
                }
            })
            .catch(error => console.error('Erro ao buscar notas:', error));
    });
</script>