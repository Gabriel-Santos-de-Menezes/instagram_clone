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

function nome_imagem(){
    var img_post = document.getElementById('img_post').value;
    console.log(img_post);

    while (img_post == ''){
        img_post = document.getElementById('img_post').value;
        if(img_post != ''){
            Console.log(img_post);
        }
    }
}


$(function(){
    $("#pesquisar").autocomplete({
        source: "php"
    });
});



