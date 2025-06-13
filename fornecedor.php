<?php
session_start();

// Verifica se o usuário está logado e se é fornecedor
if (!isset($_SESSION['usuario_id']) || $_SESSION['cargo'] !== 'fornecedor') {
    // Redirecionar para página de login se não estiver logado ou não for fornecedor
    header("Location: telaLogin.php");
    exit;
}

// Resto do código permanece igual...
$fornecedor = [
    'nome' => 'Empresa Fornecedora Ltda.',
    'cnpj' => '12.345.678/0001-90',
    'status' => 'Ativo',
];

$produtos_cadastrados = 45;
$pedidos_pendentes = 12;
$entregas_semana = 8;
$produtos_em_falta = 3;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Painel Fornecedor - AUGEBIT</title>
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
      color: #000;
    }

    .logo p {
      font-size: 14px;
      opacity: 0.7;
      color: #333;
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

    /* Container principal centralizado */
    .main-content {
      padding: 50px 40px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .welcome-section {
      text-align: center;
      margin-bottom: 50px;
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
      line-height: 1.6;
    }

    /* Container de informações da empresa centralizado */
    .company-info {
      background: white;
      border-radius: 15px;
      padding: 35px;
      margin-bottom: 50px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      text-align: left;
      border: 1px solid #f0f0f0;
    }

    .company-info h3 {
      font-size: 22px;
      color: #333;
      margin-bottom: 25px;
      font-weight: 600;
      text-align: center;
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 15px;
    }

    .company-info p {
      font-size: 15px;
      color: #666;
      margin-bottom: 15px;
      line-height: 1.6;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
    }

    .company-info strong {
      color: #333;
      min-width: 120px;
    }

    /* Seção de status com melhor alinhamento */
    .status-section {
      margin-bottom: 50px;
    }

    .status-section h3 {
      font-size: 26px;
      color: #333;
      margin-bottom: 30px;
      font-weight: 600;
      text-align: center;
    }

    /* Grid de status perfeitamente alinhado */
    .status-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 25px;
      max-width: 1000px;
      margin: 0 auto 50px auto;
    }

    .status-item {
      background: white;
      padding: 30px 20px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      border: 1px solid #f0f0f0;
      min-height: 140px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .status-item:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      border-color: #e0e0e0;
    }

    .status-number {
      font-size: 40px;
      font-weight: 700;
      color: #333;
      margin-bottom: 12px;
      line-height: 1;
    }

    .status-label {
      font-size: 14px;
      color: #666;
      font-weight: 500;
      text-align: center;
      line-height: 1.3;
    }

    /* Grid de ações perfeitamente alinhado */
    .action-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .action-card {
      background: white;
      padding: 35px 25px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      text-decoration: none;
      color: #333;
      border: 2px solid transparent;
      text-align: center;
      min-height: 200px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .action-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      border-color: #333;
      color: #333;
    }

    .action-card .icon {
      font-size: 45px;
      margin-bottom: 20px;
      line-height: 1;
    }

    .action-card .title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 12px;
      line-height: 1.2;
    }

    .action-card .description {
      font-size: 14px;
      color: #666;
      line-height: 1.5;
      text-align: center;
    }

    .footer {
      background: white;
      padding: 30px;
      text-align: center;
      color: #666;
      border-top: 1px solid #eee;
      margin-top: 60px;
    }

    /* Responsividade melhorada */
    @media (max-width: 1024px) {
      .status-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
      
      .action-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
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
        font-size: 28px;
      }

      .status-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
      }

      .action-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .action-card {
        padding: 30px 20px;
        min-height: 180px;
      }

      .company-info {
        padding: 25px 20px;
        margin-bottom: 40px;
      }

      .status-item {
        padding: 25px 15px;
        min-height: 120px;
      }

      .status-number {
        font-size: 32px;
      }
    }

    @media (max-width: 480px) {
      .status-grid {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      
      .company-info p {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }
      
      .company-info strong {
        min-width: auto;
      }
    }
  </style>
</head>
<body>

  <header class="header">
    <div class="logo">
      <img src="img/logo2.png" alt="Logo Augebit">
    </div>
    <div class="user-info">
      <span class="role-badge">
  <img src="img/user.png" alt="Ícone Usuário" style="width: 20px; vertical-align: middle; margin-right: 5px;">
  Fornecedor
</span>

      <span class="logout-badge">
        <img src="img/sair.png" alt="Ícone Logout">
        <a href="logout.php" class="logout-btn">Sair</a>
      </span>
    </div>
  </header>

  <main class="main-content">
    <section class="welcome-section">
      <h2>Portal do Fornecedor</h2>
      <p>Gerencie seus produtos, acompanhe pedidos e mantenha suas informações sempre atualizadas. Sua parceria é fundamental para o sucesso do nosso negócio.</p>

      <div class="company-info">
        <h3>Informações da Empresa</h3>
        <p><strong>Razão Social:</strong> <span><?php echo htmlspecialchars($fornecedor['nome']); ?></span></p>
        <p><strong>CNPJ:</strong> <span><?php echo htmlspecialchars($fornecedor['cnpj']); ?></span></p>
        <p><strong>Status:</strong> 
          <span style="color: <?php echo $fornecedor['status'] === 'Ativo' ? '#059669' : '#b91c1c'; ?>; font-weight: 600;">
            <?php echo htmlspecialchars($fornecedor['status']); ?>
          </span>
        </p>
      </div>
    </section>

    <div class="status-section">
      <h3>Status dos Seus Produtos</h3>
      <div class="status-grid">
        <div class="status-item">
          <div class="status-number"><?php echo $produtos_cadastrados; ?></div>
          <div class="status-label">Produtos Cadastrados</div>
        </div>
        <div class="status-item">
          <div class="status-number"><?php echo $pedidos_pendentes; ?></div>
          <div class="status-label">Pedidos Pendentes</div>
        </div>
        <div class="status-item">
          <div class="status-number"><?php echo $entregas_semana; ?></div>
          <div class="status-label">Entregas Esta Semana</div>
        </div>
        <div class="status-item">
          <div class="status-number"><?php echo $produtos_em_falta; ?></div>
          <div class="status-label">Produtos em Falta</div>
        </div>
      </div>
    </div>

    <div class="action-grid">
      <a href="#" class="action-card" onclick="showProducts()">
  <div class="icon">
    <img src="img/caixa.png" alt="Ícone Produtos" style="width: 36px; height: 36px;">
  </div>
  <div class="title">Meus Produtos</div>
  <div class="description">Visualizar e gerenciar catálogo de produtos fornecidos</div>
</a>


      <a href="#" class="action-card" onclick="showOrders()">
        <div class="icon">
    <img src="img/clipboard.png" alt="Ícone Clipboard" style="width: 36px; height: 36px;">
  </div>
        <div class="title">Pedidos Recebidos</div>
        <div class="description">Acompanhar pedidos e status de entrega</div>
      </a>

      <a href="#" class="action-card" onclick="showProfile()">
        <div class="icon">
    <img src="img/user.png" alt="Ícone User" style="width: 36px; height: 36px;">
  </div>
        <div class="title">Meu Perfil</div>
        <div class="description">Atualizar dados da empresa e contatos</div>
      </a>
    </div>

  </main>

  <footer class="footer">
    <p>&copy; 2025 Augebit. Todos os direitos reservados.</p>
  </footer>

  <script>
    function showProducts() {
      alert('Redirecionando para catálogo de produtos...');
    }
    function showOrders() {
      alert('Você tem <?php echo $pedidos_pendentes; ?> pedidos pendentes para análise.');
    }
    function showPrices() {
      alert('Redirecionando para tabela de preços...');
    }
    function showReports() {
      alert('Redirecionando para relatórios de vendas...');
    }
    function showProfile() {
      alert('Redirecionando para perfil da empresa...');
    }
    function showSupport() {
      alert('Redirecionando para central de suporte...');
    }
  </script>

</body>
</html>