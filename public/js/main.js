function curtida(img){
    
    var coracao = document.getElementById('curtir').src;
    var imagem = document.getElementById('curtir');
    console.log(coracao, imagem);
    
    
    if(img_vermelho == true){
        img.src = "img/coracao.png";
        img_vermelho == false;
    }
    //var coracao = imagem.src;
    else{
        img.src = "img/coracao_vermelho.png";
        var img_vermelho = true;
        console.log("Ola")
    }
    
    var coracao = imagem.src;
    console.log(coracao,imagem);
    //imagem.src = "img/coracao.png";
    

}

               /* div.addEventListener("click", function(){
                    input.click();
                });
                input.addEventListener("change", function(){
                    var nome = "Não há arquivo selecionado. Selecionar arquivo...";
                    if(input.files.length > 0) nome = input.files[0].name;
                    console.log(nome);
                });*/

/*
$(function(){
    $('#img_perfil_edit').change(function(){
        var img_perfil_edit = ($(this)[0].files[0]['name'])
        $.ajax({
            url     :   "/editar_perfil"
        ,   method  :   "post"
        ,   data    :   { img_perfil_edit }
    });
    })
})

$(function() {
    $("form").submit(function(event) {
        event.preventDefault(); // prevent sending the form before we processed the form
    
        var active_input        =   $(".active")[0];        
        var active_input_value  =   active_input.val();
    
        $.ajax({
                url     :   "/editar_perfil"
            ,   method  :   "post"
            ,   data    :   { something : active_input_value }
        });
    });


       */         

                









