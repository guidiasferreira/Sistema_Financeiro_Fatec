const radioNovaCultura = document.querySelector('#nova_cultura');
const radioCulturaExistente = document.querySelector('#cultura_existente');
const selectInput = document.querySelector('.select');


radioNovaCultura.addEventListener('click', () => {
    selectInput.classList.toggle("displayNone");}
);
