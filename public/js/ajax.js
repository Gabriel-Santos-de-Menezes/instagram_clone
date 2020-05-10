/*
* Função para criar um objeto XMLHTTPRequest
*/
 function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
          
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
          
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
      
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
  
 /**
  * Função para enviar os dados
  */
 function getDados() {
      
     // Declaração de Variáveis
     var usuario   = document.getElementById("pesquisar").value;
     var result = document.getElementById("resultado");
     var xmlreq = CriaRequest();
      
     // Exibi a imagem de progresso
     //result.innerHTML = '<img src="https://media.giphy.com/media/N256GFy1u6M6Y/giphy.gif">';
      
     // Iniciar uma requisição
     xmlreq.open("GET", "/pesquisarUsuario?usuario=" + usuario, true);
     
      
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
          
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
              
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
     
 }

 function curtir(id_post, acao, src, i) {
      
    // Declaração de Variáveis
    var coracao   = document.getElementById("curtir"+i) ;
    console.log(src);
    console.log(coracao);
    var result = document.getElementById("resultado_test");
    var id_post = id_post;
    var acao = acao;
    console.log(acao);
    var xmlreq = CriaRequest();
     
    // Exibi a imagem de progresso
    //result.innerHTML = '<img src="https://media.giphy.com/media/N256GFy1u6M6Y/giphy.gif">';
     
    // Iniciar uma requisição
    xmlreq.open("GET", "/curtidas?id_post=" + id_post + "&acao=" + acao, true);
    
     
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
         
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
             
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
                console.log(xmlreq);
                if(src == "img/coracao.png" && acao == "curtir"){
                    coracao.src = "img/coracao_vermelho.png";
                }
                else if(src = "img/coracao_vermelho.png" && acao == "descurtir"){
                    coracao.src = "img/coracao.png";
                }

            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
                console.log("Erro ao enviar");
            }
        }
    };
    xmlreq.send(null);
    
}


 function comentar(id_post, i) {
     
     // Declaração de Variáveis
     var comentario = document.getElementById("comentar"+i).value ;
     console.log(comentario);
    
    console.log(id_post);
    var xmlreq = CriaRequest();
     
    // Exibi a imagem de progresso
    //result.innerHTML = '<img src="https://media.giphy.com/media/N256GFy1u6M6Y/giphy.gif">';
     
    // Iniciar uma requisição
    xmlreq.open("GET", "/comentar?id_post=" + id_post + "&comentario=" + comentario, true);
    
     
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
         
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
             
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                //result.innerHTML = xmlreq.responseText;
                console.log(xmlreq.responseText);
                
                
                   // Iniciar uma requisição
                   xmlreq.open("GET", "/timeline", true);
                   
                    
                   // Atribui uma função para ser executada sempre que houver uma mudança de ado
                   xmlreq.onreadystatechange = function(){
                        
                       // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
                       if (xmlreq.readyState == 4) {
                            
                           // Verifica se o arquivo foi encontrado com sucesso
                           if (xmlreq.status == 200) {
                               //result.innerHTML = xmlreq.responseText;
                               console.log(xmlreq.responseText);
                               
                               console.log("Concluido");
               
               
                           }else{
                               result.innerHTML = "Erro: " + xmlreq.statusText;
                               console.log("Erro ao enviar");
                           }
                       }
                   };
                   xmlreq.send(null);
                   
               
               


            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
                console.log("Erro ao enviar");
            }
        }
    };
    xmlreq.send(null);
    
}

 function carregar_img_perfil(){
     // Declaração de Variáveis
     var img_perfil = document.getElementById('img_perfil_edit').value;
     console.log(img_perfil);

     var xmlreq = CriaRequest();
      
     // Iniciar uma requisição
     xmlreq.open("POST", "/editar_perfil?img_perfil=" + img_perfil, true);
     
      
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
          
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
              
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 //result.innerHTML = xmlreq.responseText;
                 console.log(xmlreq.responseText);
             }else{
                 //result.innerHTML = "Erro: " + xmlreq.statusText;
                 console.log("Erro ao enviar");
             }
         }
     };
     xmlreq.send(null);
 }



   
     