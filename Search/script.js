$(document).ready(function() {

    $("#formPesquisa").on('submit', function(event) {
        
        event.preventDefault();
        carregarResultados(0);
    });
});
    
    function carregarResultados(pagina) {
        
        var pesquisaUsuario = $('#pesquisaUsuario').val();
        var pesquisaEmail = $('#pesquisaEmail').val();
        var pesquisaTelefone = $('#pesquisaTelefone').val();
        var pesquisaCNPJ = $('#pesquisaCNPJ').val();
        var situacao = $('#situacao').val();
        
        $.ajax({
            
            url: 'pesquisa.php',
            type: 'get',
            data: {
                
                pesquisaUsuario: pesquisaUsuario,
                pesquisaEmail: pesquisaEmail,
                pesquisaTelefone: pesquisaTelefone,
                pesquisaCNPJ: pesquisaCNPJ,
                situacao: situacao,
                pagination: pagina
            },
            success: function(data) {
                
                $("#pesquisaResultados").html(data);
                $('#pagination').val(pagina);
            },
            
            error: function() {
                
                $("#pesquisaResultados").html('<p>Ocorreu um erro ao carregar os resultados.</p>');
                
            }
        });
    }
    
    function carregarPagina(pagina) {
        carregarResultados(pagina);
    }
    
    