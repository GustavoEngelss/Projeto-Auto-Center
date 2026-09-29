
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

//calculo de valores da O.S
function formatar(valor) {
    return valor.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
function recalcular() {
    var totalGeral = 0;

    $('table tbody tr').each(function () {
        var qtd = parseFloat($(this).find('.qntd-itens').val());
        var unitario = parseFloat($(this).find('.valor-unitario').val());

        if (isNaN(qtd) || isNaN(unitario)) return;

        var totalItem = qtd * unitario;
        $(this).find('.total-item').text(formatar(totalItem));
        totalGeral += totalItem;
    });

    $('#total-geral').val(formatar(totalGeral));
    $('#total-fechamento').val(formatar(totalGeral));
}
$(document).on('input', '.qntd-itens, .valor-unitario', recalcular);
$(document).ready(recalcular);

//ENTER NOS CAMPOS DE QUANTIDADE/VALOR SALVA OS ITENS
$(document).on('keydown', '.qntd-itens, .valor-unitario', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        var form = $(this).closest('form');

        $('<input>').attr({
            type: 'hidden',
            name: 'atualizar_itens',
            value: '1'
        }).appendTo(form);

        form.submit();
    }
});

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

