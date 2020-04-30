function curtir(img){
    
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

var div = document.getElementsByClassName("botaoArquivo")[0];
                 var input = document.getElementById("img_perfil");

                div.addEventListener("click", function(){
                    input.click();
                });
                input.addEventListener("change", function(){
                    var nome = "Não há arquivo selecionado. Selecionar arquivo...";
                    if(input.files.length > 0) nome = input.files[0].name;
                    div.innerHTML = nome;
                    console.log(nome);
                });










