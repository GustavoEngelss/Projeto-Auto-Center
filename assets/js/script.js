
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

//quando selecionar produtos ou peças vai mudar a forma de pesquisa
const categoria = document.getElementById('categoria');
const pesquisa = document.getElementById('pesquisa');
const medida = document.getElementById('medida');
if(categoria && pesquisa && medida) {

    function mododepesquisa(){

        if(categoria.value === 'Peça' || categoria.value === 'Serviço') {

            pesquisa.style.display = 'block';
            medida.style.display = 'none'

        }else {
            pesquisa.style.display = 'none';
            medida.style.display = 'block'
        }
    }
    categoria.addEventListener('change', mododepesquisa);
    mododepesquisa();
}

//pegando o id da marca, para mandar para api, que retorna os modelos certos
const marca = document.getElementById('marca');
const modelo = document.getElementById('modelo');

if (marca && modelo) {

    marca.addEventListener('change', function() {

        let valorMarca = this.value;

        if (valorMarca === '') {
            modelo.innerHTML = '<option value="">Avulso</option>';
            return;
        }

        fetch('../controller/acao.php?marca=' + valorMarca)
            .then(response => response.text())
            .then(data => {
                modelo.innerHTML = '<option value="">Avulso</option>' + data;
            });

    });

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
var btnExpande = document.querySelector('#btn-expandir');
var menu = document.querySelector('.menu-lateral');

if (btnExpande && menu) {

    btnExpande.addEventListener('click', function(){
        menu.classList.toggle('expandir');
    });

}