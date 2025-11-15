const selectCultura = document.getElementById('cultura');
const inputPreco = document.getElementById('valor_unitario');

selectCultura.addEventListener('change', function () {
    const preco = this.options[this.selectedIndex].getAttribute('data-preco');
    inputPreco.value = preco || ''; // Preenche se tiver preço cadastro no sistema
});