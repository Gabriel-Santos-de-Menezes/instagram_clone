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
