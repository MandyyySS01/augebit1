<?php
include 'banco.php';

// Primeiro, vamos testar se a query simples funciona
try {
// Query mais robusta que funciona mesmo se a tabela fornecedores não existir
$sql = "SELECT itens_estoque.id, itens_estoque.nome, itens_estoque.preco, itens_estoque.quantidade, itens_estoque.fornecedor_id,
COALESCE(fornecedores.email, '') as email,
COALESCE(fornecedores.nome, 'N/A') as fornecedor_nome,
COALESCE(fornecedores.responsavel, '') as responsavel
FROM itens_estoque
LEFT JOIN fornecedores ON itens_estoque.fornecedor_id = [fornecedores.id](http://fornecedores.id/)
ORDER BY itens_estoque.id DESC";

$result = $conn->query($sql);

if (!$result) {
    // Se der erro, usa query simples sem JOIN
    $sql = "SELECT * FROM itens_estoque ORDER BY id DESC";
    $result = $conn->query($sql);
}

} catch (Exception $e) {
// Em caso de erro, usa query básica
$sql = "SELECT * FROM itens_estoque ORDER BY id DESC";
$result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Estoque e Inventário</title>
<style>
/* Reset e base */
* {
box-sizing: border-box;
margin: 0;
padding: 0;
}

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
            Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        background-color: var(--bg-color);
        color: var(--text-color);
        line-height: 1.6;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    :root[data-theme="light"] {
        --bg-color: #F7F7F7;
        --card-bg: #ffffff;
        --text-color: #333;
        --text-secondary: #666;
        --border-color: #e0e0e0;
        --header-bg: #ffffff;
        --table-header-bg: #f8f9fa;
        --hover-bg: #f8f9fa;
        --gradient-start: #6c5ce7;
        --gradient-end: #a29bfe;
    }

    :root[data-theme="dark"] {
        --bg-color: #555586;
        --card-bg: #43436E;
        --text-color: #ffffff;
        --text-secondary: #cccccc;
        --border-color: #444444;
        --header-bg: #2a2a40;
        --table-header-bg: #363650;
        --hover-bg: #363650;
        --gradient-start: #764ba2;
        --gradient-end: #667eea;
    }

    /* Header principal */
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: var(--header-bg);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 0;
        transition: background-color 0.3s ease;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 40px;
        width: auto;
        object-fit: contain;
    }

    .header-controls {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* Toggle de tema estilizado */
    .theme-toggle-container {
        display: flex;
        background-color: var(--border-color);
        border-radius: 25px;
        padding: 2px;
        transition: background-color 0.3s ease;
    }

    .theme-toggle {
        cursor: pointer;
        background-color: transparent;
        border: none;
        color: var(--text-secondary);
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 23px;
        font-size: 12px;
        transition: all 0.3s ease;
        min-width: 60px;
    }

    .theme-toggle.active {
        background-color: #6c5ce7;
        color: white;
        box-shadow: 0 2px 4px rgba(108, 92, 231, 0.3);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        background-color: #6c5ce7;
        color: white;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }

    /* Container principal */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
    }

    /* Seção do título */
    .title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .title-section h1 {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .product-count {
        display: flex;
        align-items: center;
        gap: 15px;
        color: var(--text-secondary);
    }

    .count-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-color);
    }

    .count-text {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    /* Seção dos botões de ação */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }

    .btn-primary {
        background-color: #2d3436;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #636e72;
    }

    .btn-secondary {
        background-color: var(--card-bg);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--hover-bg);
        border-color: var(--text-secondary);
    }

    /* Container da tabela */
    .table-container {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: background-color 0.3s ease;
    }

    /* Filtros superiores */
    .filters-section {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        padding: 20px 30px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-btn {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background-color: rgba(255,255,255,0.3);
        border-color: rgba(255,255,255,0.5);
    }

    .search-box {
        background-color: rgba(255,255,255,0.9);
        border: none;
        padding: 10px 15px;
        border-radius: 20px;
        width: 300px;
        font-size: 14px;
    }

    .search-box::placeholder {
        color: #999;
    }

    /* Cabeçalho da tabela */
    .table-header {
        background-color: var(--table-header-bg);
        padding: 15px 30px;
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr 1fr 1fr 0.5fr;
        gap: 20px;
        align-items: center;
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: background-color 0.3s ease;
    }

    /* Linhas da tabela */
    .table-row {
        padding: 20px 30px;
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr 1fr 1fr 0.5fr;
        gap: 20px;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.2s ease;
    }

    .table-row:hover {
        background-color: var(--hover-bg);
    }

    .table-row:last-child {
        border-bottom: none;
    }

    /* Produto com imagem */
    .product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-image {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    .product-name {
        font-weight: 500;
        color: var(--text-color);
    }

    /* Preço */
    .price-cell {
        font-weight: 600;
        color: var(--text-color);
    }

    /* Fornecedor */
    .supplier-cell {
        color: var(--text-color);
    }

    /* Contato */
    .contact-cell {
        color: var(--text-secondary);
        font-size: 13px;
    }

    /* Status/Quantidade */
    .status-cell {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        min-width: 80px;
    }

    .status-high {
        background-color: #d4edda;
        color: #155724;
    }

    .status-low {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Ações */
    .actions-cell {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.2s ease;
    }

    .edit-btn {
        background-color: var(--hover-bg);
        color: var(--text-secondary);
    }

    .edit-btn:hover {
        background-color: var(--border-color);
        color: var(--text-color);
    }

    .delete-btn {
        background-color: var(--hover-bg);
        color: var(--text-secondary);
    }

    .delete-btn:hover {
        background-color: #f5c6cb;
        color: #721c24;
    }

    /* Responsividade */
    @media (max-width: 1200px) {
        .table-header,
        .table-row {
            grid-template-columns: 2fr 1fr 1.5fr 1fr 0.5fr;
        }
        .contact-cell {
            display: none;
        }
    }

    @media (max-width: 900px) {
        .container {
            padding: 20px;
        }

        .search-box {
            width: 200px;
        }

        .filters-section {
            padding: 15px 20px;
        }

        .main-header {
            padding: 15px 20px;
        }

        .theme-toggle {
            padding: 6px 12px;
            font-size: 11px;
            min-width: 50px;
        }
    }
</style>

</head>
<body>

<!-- Header principal -->
<header class="main-header">
<div class="logo">
<img src="img/logo.png" alt="Logo da Empresa">
</div>
<div class="header-controls">
<div class="theme-toggle-container">
<button class="theme-toggle active" onclick="toggleTheme('light')" id="lightBtn">Claro</button>
<button class="theme-toggle" onclick="toggleTheme('dark')" id="darkBtn">Escuro</button>
</div>
<div class="user-avatar">S</div>
</div>
</header>

<div class="container">
<!-- Seção do título -->
<div class="title-section">
<h1>Estoque e Inventário</h1>
<div class="product-count">
<div class="count-number"><?= $result->num_rows ?></div>
<div class="count-text">produtos no<br>estoque</div>
</div>
</div>

<!-- Botões de ação -->
<div class="action-buttons">
    <a href="inserir_itens.php" class="btn-primary">+ Novo produto</a>
    <a href="dashboard.php" class="btn-secondary">Dashboard</a>
</div>

<!-- Container da tabela -->
<div class="table-container">
    <!-- Filtros superiores -->
    <div class="filters-section">
        <div class="filter-group">
            <button class="filter-btn active">Preço</button>
            <button class="filter-btn">Fornecedor</button>
            <button class="filter-btn">Contato</button>
            <button class="filter-btn">Status</button>
        </div>
        <input type="text" class="search-box" placeholder="Buscar produtos...">
    </div>

    <!-- Cabeçalho da tabela -->
    <div class="table-header">
        <div>Produto</div>
        <div>Preço</div>
        <div>Fornecedor</div>
        <div>Contato</div>
        <div>Status</div>
        <div></div>
    </div>

    <!-- Linhas da tabela -->
    <?php while($row = $result->fetch_assoc()): ?>
        <?php
            $nomeArquivo = strtolower(str_replace(' ', '_', $row['nome']));
            $extensoes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $caminhoImagem = '';

            foreach ($extensoes as $ext) {
                $arquivoTeste = "img/{$nomeArquivo}.{$ext}";
                if (file_exists($arquivoTeste)) {
                    $caminhoImagem = $arquivoTeste;
                    break;
                }
            }

            $qtd = (int)$row['quantidade'];
            $statusClass = $qtd < 3 ? "status-low" : "status-high";
            $statusText = $qtd . " unidades";
        ?>
        <div class="table-row">
            <div class="product-cell">
                <?php if ($caminhoImagem): ?>
                    <img src="<?= $caminhoImagem ?>" alt="<?= htmlspecialchars($row['nome']) ?>" class="product-image">
                <?php else: ?>
                    <img src="img/placeholder.png" alt="Sem imagem" class="product-image" />
                <?php endif; ?>
                <span class="product-name"><?= htmlspecialchars($row['nome']) ?></span>
            </div>

            <div class="price-cell">R$ <?= number_format($row['preco'], 2, ',', '.') ?></div>

            <div class="supplier-cell"><?= htmlspecialchars($row['fornecedor_nome'] ?? 'N/A') ?></div>

            <div class="contact-cell"><?= htmlspecialchars($row['email'] ?? '') ?></div>

            <div class="status-cell">
                <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
            </div>

            <div class="actions-cell">
                <button class="action-btn edit-btn" onclick="location.href='editar_item.php?id=<?= $row['id'] ?>'" title="Editar">✏️</button>
                <button class="action-btn delete-btn" onclick="if(confirm('Deseja realmente excluir este item?')) location.href='excluir_item.php?id=<?= $row['id'] ?>'" title="Excluir">🗑️</button>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</div>

<script>
// Função para alternar tema
function toggleTheme(theme) {
const root = document.documentElement;
root.setAttribute('data-theme', theme);

    // Atualiza botões
    document.getElementById('darkBtn').classList.remove('active');
    document.getElementById('lightBtn').classList.remove('active');
    document.getElementById(theme + 'Btn').classList.add('active');

    // Salva preferência
    localStorage.setItem('theme', theme);

    console.log('Tema alterado para:', theme); // Debug
}

// Inicializa tema ao carregar página
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    toggleTheme(savedTheme);

    // Adiciona event listeners aos botões
    document.getElementById('lightBtn').addEventListener('click', function() {
        toggleTheme('light');
    });

    document.getElementById('darkBtn').addEventListener('click', function() {
        toggleTheme('dark');
    });
});

// Funcionalidade dos filtros
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Funcionalidade da busca
    document.querySelector('.search-box').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.table-row').forEach(row => {
            const productName = row.querySelector('.product-name').textContent.toLowerCase();
            if (productName.includes(searchTerm)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

</script>

</body>
</html>