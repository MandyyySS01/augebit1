<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Controle de Estoque</title>
<link rel="icon" href="img/favicon.ico" type="image/x-icon" />
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #F7F7F7;
  min-height: 100vh;
  padding: 20px;
  color: #333;
}

.container {
  max-width: 1400px;
  margin: 40px auto;
  background: white;
  border-radius: 15px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  overflow: hidden;
  padding: 60px 40px; /* aumenta o espaçamento interno: vertical 60px, horizontal 40px */
}

.header {
  background: #5E67AD;
  color: white;
  padding: 30px;
  text-align: center;
}

.header h1 {
  font-size: 2.5em;
  margin-bottom: 10px;
}

.header p {
  opacity: 0.9;
  font-size: 1.1em;
}

.content {
  padding: 30px;
}

.status-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 25px;
  margin-bottom: 30px;
}

.status-card {
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
  color: #333;
}

.status-card:hover {
  transform: translateY(-5px);
}

.em-estoque {
  background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
  border-left: 5px solid #4CAF50;
}

.metade {
  background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
  border-left: 5px solid #FF9800;
}

.em-falta {
  background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
  border-left: 5px solid #f44336;
}

.status-title {
  font-size: 1.4em;
  font-weight: bold;
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.status-icon {
  font-size: 1.5em;
}

.produto {
  background: rgba(255,255,255,0.9);
  padding: 12px;
  margin: 8px 0;
  border-radius: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: all 0.3s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.produto:hover {
  background: rgba(255,255,255,1);
  transform: scale(1.02);
}

.produto-nome {
  font-weight: 600;
  color: #333;
}

.produto-qtd {
  font-weight: bold;
  padding: 6px 14px;
  border-radius: 20px;
  color: white;
  font-size: 0.9em;
  min-width: 50px;
  text-align: center;
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.qtd-ok {
  background-color: #4CAF50; /* Verde */
}

.qtd-medio {
  background-color: #FF9800; /* Laranja */
}

.qtd-baixo {
  background-color: #f44336; /* Vermelho */
}

.btn-primary {
  background-color: var(--btn-bg, #5E67AD);
  color: var(--btn-text, #fff);
  border: 1px solid var(--btn-border, #4a54a3);
  padding: 12px 20px;
  border-radius: 8px;
  font-weight: 500;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 20px;
}

.btn-primary:hover {
  background-color: #4a54a3;
  border-color: #3f4894;
}


.form-produto {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  padding: 25px;
  border-radius: 12px;
  margin: 20px 0;
  display: none;
  box-shadow: 0 8px 20px rgba(245, 87, 108, 0.3);
}

.form-produto input {
  padding: 12px;
  margin: 8px;
  border: none;
  border-radius: 8px;
  font-size: 1em;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  width: calc(33% - 24px);
  outline: none;
}

.form-produto button {
  background: white;
  color: #f5576c;
  border: none;
  padding: 12px 25px;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  margin: 8px 4px 8px 0;
  transition: background-color 0.3s ease;
}

.form-produto button:hover {
  background-color: #f093fb;
  color: white;
}

.summary {
  text-align: center;
  margin-top: 30px;
  padding: 20px;
  background: #5E67AD;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.summary h3 {
  color: #ffff;
  margin-bottom: 10px;
}
.summary p {
  color: white;
}
.titulo-centralizado {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
}

.titulo-centralizado h1 {
  font-size: 2.5em;
  margin: 0;
}

.icone-caixa {
  width: 40px;
}

.topo-botoes {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.btn-sair {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 6px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-sair:hover {
  background: rgba(0,0,0,0.05);
}

.btn-sair img {
  width: 28px;
  height: 28px;
}

</style>
</head>
<body>
    <header style="text-align: center; margin: 30px 0;">
      <img src="img/logoroxa.png" alt="Logo da Empresa" style="max-height: 100px;" />
    </header>
<div class="container">
  <div class="titulo-centralizado">
    <img src="img/caixa.png" alt="Ícone de Caixa" class="icone-caixa">
    <h1>Controle de Estoque</h1>
  </div>

  <div class="content">
    <div class="topo-botoes">
      <button class="btn-primary" onclick="toggleForm()">
        <img src="img/plus.png" alt="Adicionar" style="width:16px; height:16px;"> Novo Produto
      </button>

      <a href="telaLogin.php" class="btn-sair" title="Sair">
        <img src="img/sair.png" alt="Sair">
      </a>
    </div>

    <div class="form-produto" id="formProduto">
      <input type="text" id="nomeProduto" placeholder="Nome do produto" />
      <input type="number" id="qtdProduto" placeholder="Quantidade" />
      <input type="number" id="qtdMinima" placeholder="Quantidade mínima" />
      <button onclick="adicionarProduto()">Adicionar</button>
      <button onclick="toggleForm()">Cancelar</button>
    </div>

    <div class="status-grid">
      <div class="status-card em-estoque">
        <div class="status-title">
          <span class="status-icon">✅</span> Em Estoque
        </div>
        <div id="produtosEmEstoque"></div>
      </div>

      <div class="status-card metade">
        <div class="status-title">
          <span class="status-icon">⚠️</span> Estoque Baixo
        </div>
        <div id="produtosMetade"></div>
      </div>

      <div class="status-card em-falta">
        <div class="status-title">
          <span class="status-icon">🚫</span> Em Falta
        </div>
        <div id="produtosEmFalta"></div>
      </div>
    </div>

    <div class="summary" id="resumo"></div>
  </div>
</div>

<script>
let produtos = [
  { nome: "Notebook Dell", quantidade: 15, qtdMinima: 5 },
  { nome: "Mouse Logitech", quantidade: 3, qtdMinima: 10 },
  { nome: "Teclado Mecânico", quantidade: 0, qtdMinima: 5 },
  { nome: "Monitor 24'", quantidade: 8, qtdMinima: 3 },
  { nome: "Cabo HDMI", quantidade: 2, qtdMinima: 15 },
  { nome: "SSD 500GB", quantidade: 12, qtdMinima: 8 },
  { nome: "Memória RAM 8GB", quantidade: 0, qtdMinima: 6 },
  { nome: "Webcam HD", quantidade: 25, qtdMinima: 10 }
];

function classificarProduto(produto) {
  if (produto.quantidade === 0) {
    return 'falta';
  } else if (produto.quantidade <= produto.qtdMinima) {
    return 'baixo';
  } else {
    return 'estoque';
  }
}

function renderizarProdutos() {
  const emEstoque = document.getElementById('produtosEmEstoque');
  const metade = document.getElementById('produtosMetade');
  const emFalta = document.getElementById('produtosEmFalta');

  emEstoque.innerHTML = '';
  metade.innerHTML = '';
  emFalta.innerHTML = '';

  let contadores = { estoque: 0, baixo: 0, falta: 0 };

  produtos.forEach(produto => {
    const classificacao = classificarProduto(produto);
    contadores[classificacao]++;

    const div = document.createElement('div');
    div.className = 'produto';

    let classeQtd, statusQtd;
    if (classificacao === 'falta') {
      classeQtd = 'qtd-baixo';
      statusQtd = `0 / ${produto.qtdMinima}`;
    } else if (classificacao === 'baixo') {
      classeQtd = 'qtd-medio';
      statusQtd = `${produto.quantidade} / ${produto.qtdMinima}`;
    } else {
      classeQtd = 'qtd-ok';
      statusQtd = `${produto.quantidade} / ${produto.qtdMinima}`;
    }

    div.innerHTML = `
      <span class="produto-nome">${produto.nome}</span>
      <span class="produto-qtd ${classeQtd}">${statusQtd}</span>
    `;

    if (classificacao === 'falta') {
      emFalta.appendChild(div);
    } else if (classificacao === 'baixo') {
      metade.appendChild(div);
    } else {
      emEstoque.appendChild(div);
    }
  });

  const resumo = document.getElementById('resumo');
  resumo.innerHTML = `
    <h3>📊 Resumo do Estoque</h3>
    <p><strong>${contadores.estoque}</strong> produtos em estoque |
       <strong>${contadores.baixo}</strong> com estoque baixo |
       <strong>${contadores.falta}</strong> em falta</p>
  `;
}

function toggleForm() {
  const form = document.getElementById('formProduto');
  form.style.display = form.style.display === 'block' ? 'none' : 'block';
}

function adicionarProduto() {
  const nome = document.getElementById('nomeProduto').value.trim();
  const quantidade = parseInt(document.getElementById('qtdProduto').value);
  const qtdMinima = parseInt(document.getElementById('qtdMinima').value);

  if (nome && !isNaN(quantidade) && !isNaN(qtdMinima)) {
    produtos.push({ nome, quantidade, qtdMinima });

    document.getElementById('nomeProduto').value = '';
    document.getElementById('qtdProduto').value = '';
    document.getElementById('qtdMinima').value = '';

    toggleForm();
    renderizarProdutos();
  } else {
    alert('Preencha todos os campos corretamente!');
  }
}

renderizarProdutos();
</script>

</body>
</html>
