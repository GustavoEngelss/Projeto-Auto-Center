
//quando seleciona a forma de pagamento aparece para selecionar a quantidade 
const pagamento = document.getElementById('pagamento');
const parcelasContainer = document.getElementById('parcelas-container');

if (pagamento && parcelasContainer) {

    function verificarPagamento() {

        if (pagamento.value === 'credito') {
            parcelasContainer.style.display = 'block';
        } else {
            parcelasContainer.style.display = 'none';
        }

    }

    pagamento.addEventListener('change', verificarPagamento);

    // Verifica quando a página é carregada novamente
    verificarPagamento();
}

/*Script do menu*/
var menuItem = document.querySelectorAll('.item-menu')
function selectLinck(){
    menuItem.forEach((item)=>
        item.classList.remove('ativo')
    )
    this.classList.add('ativo')
}
menuItem.forEach((item)=>
    item.addEventListener('click',selectLinck)
)

//expandir o menu
var btnExpande = document.querySelector('#btn-expandir')
var menu = document.querySelector('.menu-lateral')
btnExpande.addEventListener('click', function(){
    menu.classList.toggle('expandir')
})