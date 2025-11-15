document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const temErro = params.get('erro');

  if (temErro) {
    mostrarErro("Usuário ou senha incorretos!");
  }
});

function mostrarErro(msg) {
  const msgDiv = document.getElementById('msgErro');
  msgDiv.textContent = msg;
  msgDiv.classList.add('visivel');

  setTimeout(() => {
    msgDiv.classList.remove('visivel');
  }, 3000);
}
