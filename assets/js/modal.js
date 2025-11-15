const modalContainer = document.getElementById('modal-container');
const nomeFazendaEl = document.getElementById('nome-fazenda');
const deleteButtons = document.querySelectorAll('.delete-btn');
const btnCancelar = document.getElementById('cancel-delete');
const btnConfirmar = document.getElementById('confirm-delete');
const inputIdFazenda = document.getElementById('id-fazenda-selecionada'); 

let fazendaSelecionada = null;
let idFazendaSelecionada = null;

deleteButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        fazendaSelecionada = btn.getAttribute('data-fazenda');
        idFazendaSelecionada = btn.getAttribute('data-id');

        nomeFazendaEl.textContent = fazendaSelecionada;
        modalContainer.classList.add('active');
    });
});

btnCancelar.addEventListener('click', (e) => {
    e.preventDefault(); 
    modalContainer.classList.remove('active');
});

btnConfirmar.addEventListener('click', () => {
    inputIdFazenda.value = idFazendaSelecionada;
});
