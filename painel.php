<?php
include 'banco.php';

// Ativa modo de exceção para o mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$result = false;
$total_items = 0;
$error_msg = '';

// Verifica se a conexão está ativa
if (!$conn) {
    die("Erro: Conexão com o banco não foi estabelecida.");
}

try {
    // Query com LEFT JOIN para buscar os dados dos itens e seus fornecedores
    $sql = "SELECT 
                itens_estoque.id, 
                itens_estoque.nome, 
                itens_estoque.preco, 
                itens_estoque.quantidade, 
                itens_estoque.fornecedor_id,
                COALESCE(fornecedores.email, '') as email,
                COALESCE(fornecedores.nome, 'N/A') as fornecedor_nome,
                COALESCE(fornecedores.responsavel, '') as responsavel,
                COALESCE(fornecedores.telefone, '') as telefone
            FROM itens_estoque
            LEFT JOIN fornecedores ON itens_estoque.fornecedor_id = fornecedores.id
            ORDER BY itens_estoque.id DESC";

    $result = mysqli_query($conn, $sql);

    $total_items = mysqli_num_rows($result);

} catch (Exception $e) {
    // Se a primeira consulta falhar, tenta uma consulta simples
    try {
        $sql = "SELECT * FROM itens_estoque ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $total_items = mysqli_num_rows($result);
    } catch (Exception $e2) {
        $error_msg = "Erro na consulta ao banco: " . $e2->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Estoque e Inventário</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
    <style>
        /* ========== RESET E BASE ========== */
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
        }

        /* ========== VARIÁVEIS CSS - CORES DOS TEMAS ========== */
       :root[data-theme="light"] {
    --bg-color: #F7F7F7;
    --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    --card-bg: #ffffff;
    --chart-bg: rgba(255, 255, 255, 0.95);
    --chart-text: #333;
    --text-color: #333;
    --text-secondary: #666;
    --border-color: #F7F7F7;
    --header-bg: #F7F7F7;
    --table-header-bg: #f8f9fa;
    --table-row-bg: #ffffff;
    --gradient-start: #6c5ce7;
    --gradient-end: #a29bfe;
    --hover-bg: #f8f9fa;
    --toggle-bg: #e0e0e0;
    --toggle-inactive: #999;
    --toggle-hover-bg: rgba(108, 92, 231, 0.1);
    --toggle-active-bg: #6c5ce7;
    --toggle-active-text: #ffffff;
    --table-header-color: #5E67AD;
    --filters-bg: #5E67AD;
    --btn-bg: #5E67AD;
    --btn-text: #ffffff;
    --btn-border: #5E67AD;
}

:root[data-theme="dark"] {
    --bg-color: #5a548a;
    --bg-gradient: linear-gradient(135deg, #555586 0%, #764ba2 100%);
    --card-bg: rgba(255, 255, 255, 0.1);
    --chart-bg: rgba(255, 255, 255, 0.95);
    --chart-text: #333;
    --text-color: #ffffff;
    --text-secondary: #b8b8cc;
    --border-color: #555586;
    --header-bg: #555586;
    --table-header-bg: #40407a;
    --table-row-bg: #ffffff;
    --gradient-start: #667eea;
    --gradient-end: #764ba2;
    --hover-bg: #4a4a75;
    --toggle-bg: #40407a;
    --toggle-inactive: #b8b8cc;
    --toggle-hover-bg: rgba(102, 126, 234, 0.2);
    --toggle-active-bg: #667eea;
    --toggle-active-text: #ffffff;
    --table-header-color: #403572;
    --filters-bg: #3a3365;
    --btn-bg: #43436E;
    --btn-text: #ffffff;
    --btn-border: #43436E;
}


/* Fundo branco nas linhas no tema escuro */
:root[data-theme="dark"] .table-row {
    background-color: var(--table-row-bg);
}

/* Texto preto dentro das células das linhas no tema escuro */
:root[data-theme="dark"] .table-row * {
    color: #000000 !important;
}


/* ... */

.table-header {
    background-color: var(--table-header-color);
    padding: 18px 30px;
    display: grid;
    grid-template-columns: 2fr 1fr 1.5fr 1fr 1fr 0.5fr;
    gap: 20px;
    align-items: center;
    font-weight: 700;
    color: #ffffff;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid rgba(255,255,255,0.2);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    position: sticky;
    top: 0;
    z-index: 10;
}


.table-row {
    padding: 20px 30px;
    display: grid;
    grid-template-columns: 2fr 1fr 1.5fr 1fr 1fr 0.5fr;
    gap: 20px;
    align-items: center;
    background-color: var(--table-row-bg); /* ALTERADO */
    border-bottom: 1px solid #667eea;
    transition: background-color 0.2s ease;
    
}


        /* ========== HEADER PRINCIPAL ========== */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: var(--header-bg);
            margin-bottom: 0;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        #logo-light {
            height: 60px;
            width: auto;
            object-fit: contain;
        }

        #logo-dark {
            height: 58px;
            width: auto;
            object-fit: cover;
            margin-top: 4px;
            margin-left: 2px;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* ========== TOGGLE DE TEMA ========== */
        .theme-toggle-container {
            display: flex;
            background-color: var(--toggle-bg);
            border-radius: 25px;
            padding: 3px;
            transition: all 0.3s ease;
            position: relative;
        }

        .theme-toggle {
            cursor: pointer;
            background-color: transparent;
            border: none;
            color: var(--toggle-inactive);
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 22px;
            font-size: 13px;
            transition: all 0.3s ease;
            min-width: 70px;
            position: relative;
            z-index: 2;
        }

        .theme-toggle:hover:not(.active) {
            background-color: var(--toggle-hover-bg);
            color: var(--text-color);
            transform: translateX(2px);
        }

        .theme-toggle.active {
            background-color: var(--toggle-active-bg);
            color: var(--toggle-active-text);
        }

        .theme-toggle.active:hover {
            transform: translateX(-2px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: var(--gradient-start);
            color: white;
            font-weight: 700;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        /* ========== CONTAINER PRINCIPAL ========== */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        /* ========== SEÇÃO DO TÍTULO ========== */
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

        /* ========== BOTÕES DE AÇÃO ========== */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

     .btn-primary, .btn-secondary {
    background-color: var(--btn-bg);
    color: var(--btn-text);
    border: 1px solid var(--btn-border);
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

       

        /* ========== CONTAINER DA TABELA ========== */
        .table-container {
            background-color: #667eea;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: background-color 0.3s ease;
        }

        /* ========== FILTROS SUPERIORES ========== */
   .filters-section {
    background: var(--filters-bg);
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
            color: #333;
        }

        .search-box::placeholder {
            color: #999;
        }

        /* ========== CABEÇALHO DA TABELA ========== */
        .table-header {
    background-color: var(--table-header-color);
    padding: 18px 30px;
    display: grid;
    grid-template-columns: 2fr 1fr 1.5fr 1fr 1fr 0.5fr;
    gap: 20px;
    align-items: center;
    font-weight: 700;
    color: #ffffff;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid rgba(255,255,255,0.2);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    position: sticky;
    top: 0;
    z-index: 10;
}


        /* ========== LINHAS DA TABELA ========== */
        .table-row {
            padding: 20px 30px;
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr 1fr 1fr 0.5fr;
            gap: 20px;
            align-items: center;
            border-bottom: 1px solid #667eea;
            transition: background-color 0.2s ease;
        }

       

        .table-row:last-child {
            border-bottom: none;
        }

        /* ========== CÉLULAS DA TABELA ========== */
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

        .price-cell {
            font-weight: 600;
            color: var(--text-color);
        }

        .supplier-cell {
            color: var(--text-color);
        }

     .contact-cell {
    color: var(--text-color); /* mesma cor das outras células */
    color: var(--table-text-color);
    font-size: 14px; /* opcional: ajustar tamanho como os demais */
    font-weight: 500; /* opcional: dar o mesmo peso */
}

        /* ========== STATUS/QUANTIDADE ========== */
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

        /* ========== AÇÕES ========== */
        .actions-cell {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.action-icon {
  width: 24px;
  height: 24px;
  cursor: pointer;
  transition: filter 0.3s ease;
}

.action-icon:hover {
  filter: brightness(0.8);
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

        /* ========== MENSAGENS DE ERRO E ESTADOS VAZIOS ========== */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-secondary);
        }

        /* ========== RESPONSIVIDADE ========== */
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
                padding: 8px 14px;
                font-size: 12px;
                min-width: 60px;
            }
        }
    </style>
</head>
<body>

<!-- Header principal -->
<header class="main-header">
    <div class="logo">
        <!-- LOGO PARA MODO CLARO -->
        <img id="logo-light" src="img/logo3.png" alt="Logo Modo Claro" style="display: block;">
        <!-- LOGO PARA MODO ESCURO -->
        <img id="logo-dark" src="img/logo9.png" alt="Logo Modo Escuro" style="display: none;">
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
            <div class="count-number"><?php echo $total_items; ?></div>
            <div class="count-text">produtos no<br>estoque</div>
        </div>
    </div>

    <!-- Botões de ação -->
    <div class="action-buttons">
        <a href="inserir_itens.php" class="btn-primary">+ Novo produto</a>
        <a href="inserir_fornecedores.php" class="btn-secondary">+ Novo fornecedor</a>
        <a href="dashboard.php" class="btn-secondary">Dashboard</a>
    </div>

    <!-- Mensagem de erro se houver -->
    <?php if ($error_msg): ?>
        <div class="error-message">
            <strong>Erro:</strong> <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>

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
        <?php if ($result && $total_items > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    // Valores seguros do produto
                    $nome = isset($row['nome']) ? $row['nome'] : 'Nome não definido';
                    $preco = isset($row['preco']) ? floatval($row['preco']) : 0;
                    $quantidade = isset($row['quantidade']) ? intval($row['quantidade']) : 0;
                    $fornecedor_id = isset($row['fornecedor_id']) ? $row['fornecedor_id'] : null;
                    
                    // Dados do fornecedor (do JOIN ou busca separada)
                    $fornecedor_nome = 'N/A';
                    $contato_info = '';
                    
                    // Verifica se os dados do fornecedor vieram do JOIN
                    if (isset($row['fornecedor_nome']) && !empty($row['fornecedor_nome']) && $row['fornecedor_nome'] !== 'N/A') {
                        $fornecedor_nome = $row['fornecedor_nome'];
                        
                        // Procura o melhor contato disponível
                        if (!empty($row['telefone'])) {
                            $contato_info = $row['telefone'];
                        } elseif (!empty($row['contato'])) {
                            $contato_info = $row['contato'];
                        } elseif (!empty($row['email'])) {
                            $contato_info = $row['email'];
                        }
                    } else if ($fornecedor_id) {
                        // Se não veio do JOIN, busca separadamente
                        $sql_fornecedor = "SELECT nome, email, telefone, contato FROM fornecedores WHERE id = " . intval($fornecedor_id);
                        $result_fornecedor = mysqli_query($conn, $sql_fornecedor);
                        if ($result_fornecedor && mysqli_num_rows($result_fornecedor) > 0) {
                            $fornecedor = mysqli_fetch_assoc($result_fornecedor);
                            $fornecedor_nome = $fornecedor['nome'];
                            
                            if (!empty($fornecedor['telefone'])) {
                                $contato_info = $fornecedor['telefone'];
                            } elseif (!empty($fornecedor['contato'])) {
                                $contato_info = $fornecedor['contato'];
                            } elseif (!empty($fornecedor['email'])) {
                                $contato_info = $fornecedor['email'];
                            }
                        }
                    }

                    // Busca pela imagem do produto
                    $nomeArquivo = strtolower(str_replace(' ', '_', $nome));
                    $extensoes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $caminhoImagem = '';

                    foreach ($extensoes as $ext) {
                        $arquivoTeste = "img/{$nomeArquivo}.{$ext}";
                        if (file_exists($arquivoTeste)) {
                            $caminhoImagem = $arquivoTeste;
                            break;
                        }
                    }

                    // Status baseado na quantidade
                    $statusClass = $quantidade < 3 ? "status-low" : "status-high";
                    $statusText = $quantidade . " unidades";
                ?>
                <div class="table-row">
                    <div class="product-cell">
                        <?php if ($caminhoImagem): ?>
                            <img src="<?php echo htmlspecialchars($caminhoImagem); ?>" alt="<?php echo htmlspecialchars($nome); ?>" class="product-image">
                        <?php else: ?>
                            <img src="img/placeholder.png" alt="Sem imagem" class="product-image" />
                        <?php endif; ?>
                        <span class="product-name"><?php echo htmlspecialchars($nome); ?></span>
                    </div>

                    <div class="price-cell">R$ <?php echo number_format($preco, 2, ',', '.'); ?></div>

                    <div class="supplier-cell"><?php echo htmlspecialchars($fornecedor_nome); ?></div>

                    <div class="contact-cell"><?php echo htmlspecialchars($contato_info); ?></div>

                    <div class="status-cell">
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    </div>

                    <div class="actions-cell">
    <img
      src="img/pen.png"
      alt="Editar"
      class="action-icon edit-icon"
      onclick="location.href='editar_item.php?id=<?php echo $row['id']; ?>'"
      title="Editar"
      style="cursor:pointer;"
    />
    <img
      src="img/trash-bin.png"
      alt="Excluir"
      class="action-icon delete-icon"
      onclick="if(confirm('Deseja realmente excluir este item?')) location.href='excluir_item.php?id=<?php echo $row['id']; ?>'"
      title="Excluir"
      style="cursor:pointer;"
    />
</div>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-data">
                <h3>Nenhum produto encontrado</h3>
                <p>Clique em "Novo produto" para adicionar itens ao estoque.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// ========== FUNÇÃO PARA ALTERNAR TEMA ==========
function toggleTheme(theme) {
    const root = document.documentElement;
    root.setAttribute('data-theme', theme);

    // Atualiza botões com animação suave
    document.getElementById('darkBtn').classList.remove('active');
    document.getElementById('lightBtn').classList.remove('active');
    document.getElementById(theme + 'Btn').classList.add('active');

    // ========== TROCA DE LOGO BASEADA NO TEMA ==========
    const logoLight = document.getElementById('logo-light');
    const logoDark = document.getElementById('logo-dark');

    if (theme === 'light') {
        logoLight.style.display = 'block';
        logoDark.style.display = 'none';
        console.log('☀️ Logo claro ativado');
    } else {
        logoLight.style.display = 'none';
        logoDark.style.display = 'block';
        console.log('🌙 Logo escuro ativado');
    }

    // Salva preferência no localStorage
    localStorage.setItem('theme', theme);
    console.log('🎨 Tema alterado para:', theme);
}

// ========== INICIALIZAÇÃO DO TEMA ==========
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    toggleTheme(savedTheme);

    // Event listeners para os botões com feedback visual
    document.getElementById('lightBtn').addEventListener('click', function() {
        toggleTheme('light');
        console.log('☀️ Modo claro ativado');
    });

    document.getElementById('darkBtn').addEventListener('click', function() {
        toggleTheme('dark');
        console.log('🌙 Modo escuro ativado');
    });
});

// ========== FUNCIONALIDADE DOS FILTROS ==========
document.addEventListener('DOMContentLoaded', function() {
    // Filtros da tabela
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Funcionalidade da busca em tempo real
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