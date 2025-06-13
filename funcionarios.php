<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Painel Funcionário - AUGEBIT</title>
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f5f5;
    min-height: 100vh;
  }

  .header {
    background: linear-gradient(135deg, #f4f4f4 0%, #f4f4f4 100%);
    color: white;
    padding: 25px 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .logo img {
    height: 60px;
  }

  .user-info {
    display: flex;
    align-items: center;
    gap: 40px;
  }

  .role-badge, .logout-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
    font-size: 18px;
    color: #000;
  }

  .role-badge img, .logout-badge img {
    height: 20px;
    width: 20px;
  }

  .logout-btn {
    color: #000;
    text-decoration: none;
    font-weight: 600;
  }

  .main-content {
    padding: 50px 40px;
    text-align: center;
  }

  .welcome-section h2 {
    font-size: 32px;
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
  }

  .welcome-section p {
    font-size: 16px;
    color: #666;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .quick-stats {
    background: white;
    margin: 40px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    max-width: 900px;
  }

  .quick-stats h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 20px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }

  .stat-item {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
  }

  .stat-number {
    font-size: 28px;
    font-weight: 700;
    color: #555586;
    margin-bottom: 5px;
  }

  .stat-label {
    font-size: 14px;
    color: #666;
  }

  .action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    max-width: 900px;
    margin: 0 auto;
    margin-top: 40px;
  }

  .action-card {
    background: white;
    padding: 30px 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    text-decoration: none;
    color: #333;
    border: 2px solid transparent;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    border-color: #000;
    color: #000;
  }

  .action-card .icon img {
    width: 40px;
    height: 40px;
    margin-bottom: 15px;
  }

  .action-card .title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .action-card .description {
    font-size: 14px;
    color: #666;
    line-height: 1.4;
    text-align: center;
  }

  .footer {
    background: white;
    padding: 25px;
    text-align: center;
    color: #666;
    border-top: 1px solid #eee;
    margin-top: 50px;
  }

  /* Responsivo */
  @media (max-width: 1024px) {
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .header {
      padding: 20px 25px;
      flex-direction: column;
      gap: 15px;
    }

    .main-content {
      padding: 30px 25px;
    }

    .welcome-section h2 {
      font-size: 26px;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>

<header class="header">
  <div class="logo">
    <img src="img/logo2.png" alt="Logo Augebit" />
  </div>
  <div class="user-info">
    <span class="role-badge">
      <img src="img/user.png" alt="Ícone Funcionário" />
      Funcionário
    </span>
    <span class="logout-badge">
      <img src="img/sair.png" alt="Ícone Logout" />
      <a href="telaLogin.php" class="logout-btn">Sair</a>
    </span>
  </div>
</header>

<main class="main-content">
  <section class="welcome-section">
    <h2>Painel do Funcionário</h2>
    <p>Gerencie o estoque, processe pedidos e mantenha o sistema organizado com eficiência.</p>
  </section>

  <div class="quick-stats">
    <h3>Resumo Rápido</h3>
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-number">156</div>
        <div class="stat-label">Produtos em Estoque</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">23</div>
        <div class="stat-label">Produtos com Baixo Estoque</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">8</div>
        <div class="stat-label">Pedidos Pendentes</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">12</div>
        <div class="stat-label">Fornecedores Ativos</div>
      </div>
    </div>
  </div>

  <div class="action-grid">
    <a href="painel.php" class="action-card">
      <div class="icon">
        <!-- Exemplo com imagem -->
        <img src="img/clipboard.png" alt="Painel de Controle" />
      </div>
      <div class="title">Painel de Controle</div>
      <div class="description">Acesso ao painel principal</div>
    </a>

    <a href="inserir_itens.php" class="action-card">
      <div class="icon">
        <img src="img/caixa.png" alt="Gerenciar Produtos" />
      </div>
      <div class="title">Gerenciar Produtos</div>
      <div class="description">Adicionar e editar produtos</div>
    </a>

    <a href="estoque.php" class="action-card" onclick="showAlerts()">
      <div class="icon">
        <img src="img/warning.png" alt="Alertas" />
      </div>
      <div class="title">Alertas</div>
      <div class="description">Produtos com baixo estoque</div>
    </a>
  </div>
</main>

<footer class="footer">
  <p>© 2025 Augebit. Todos os direitos reservados.</p>
</footer>



</body>
</html>
