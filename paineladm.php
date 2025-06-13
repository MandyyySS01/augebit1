<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Painel Administrador - AUGEBIT</title>
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

    .logo h1 {
      font-size: 28px;
      font-weight: 700;
    }

    .logo p {
      font-size: 14px;
      opacity: 0.9;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 40px;
    }

    .role-badge {
      display: flex;
      align-items: center;
      gap: 10px;
      color: rgb(0, 0, 0);
      font-weight: 500;
      font-size: 20px;
    }

    .role-badge img {
      height: 20px;
      width: 20px;
    }

    .logout-badge {
      display: flex;
      align-items: center;
      gap: 0px;
      color: #000;
      font-weight: 600;
      font-size: 16px;
    }

    .logout-badge img {
      height: 20px;
      width: 20px;
    }

    .logout-btn {
      color: #000000;
      border: none;
      padding: 13px 15px;
      border-radius: 7px;
      font-size: 18px;
      font-weight: 500;
      text-decoration: none;
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

    .action-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px;
      max-width: 800px;
      margin: 0 auto;
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
    }

    .action-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
      border-color: #000000;
      color: #000000;
    }

    .action-card .icon {
      font-size: 40px;
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
    }

    .footer {
      background: white;
      padding: 25px;
      text-align: center;
      color: #666;
      border-top: 1px solid #eee;
      margin-top: 50px;
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

      .action-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .action-card {
        padding: 25px 20px;
      }
    }
  </style>
</head>
<body>

  <header class="header">
    <div class="logo">
      <img src="img/logo2.png" alt="Logo Augebit">
      <div>
        <h1></h1>
        <p></p>
      </div>
    </div>
    <div class="user-info">
      <span class="role-badge">
        <img src="img/contrato.png" alt="Ícone Admin">
        Administrador
      </span>
      <span class="logout-badge">
        <img src="img/sair.png" alt="Ícone Logout">
        <a href="telaLogin.php" class="logout-btn">Sair</a>
      </span>
    </div>
  </header>

  <main class="main-content">
    <section class="welcome-section">
      <h2>Painel do Administrador</h2>
      <p>Controle total do sistema. Gerencie usuários, produtos e todas as funcionalidades do sistema de estoque.</p>
    </section>

    <div class="action-grid">
      <a href="painel.php" class="action-card">
        <div class="icon"></div>
        <div class="title">Painel Geral</div>
        <div class="description">Controle geral do sistema</div>
      </a>

      <a href="inserir_itens.php" class="action-card">
        <div class="icon"></div>
        <div class="title">Gerenciar Produtos</div>
        <div class="description">Adicionar, editar e remover itens</div>
      </a>

      <a href="inserir_usuarios.php" class="action-card">
        <div class="icon"></div>
        <div class="title">Gerenciar Usuários</div>
        <div class="description">Cadastrar e gerenciar funcionários</div>
      </a>

      <a href="inserir_fornecedores.php" class="action-card">
        <div class="icon"></div>
        <div class="title">Gerenciar Fornecedores</div>
        <div class="description">Cadastrar e gerenciar fornecedores</div>
      </a>
    </div>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Augebit. Todos os direitos reservados.</p>
  </footer>

  <script>
    function showConfig() {
      alert('Funcionalidade em desenvolvimento');
    }
  </script>

</body>
</html>
