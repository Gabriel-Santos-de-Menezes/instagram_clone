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
     var result = document.getElementById("Resultado");
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

 function mosta_curtidas(){
     // Declaração de Variáveis
    var classe = document.getElementById('post_img_perfil').className;
    classe = "mostar_curtidas";
    console.log (classe);
     var xmlreq = CriaRequest();
      
     // Exibi a imagem de progresso
     //result.innerHTML = '<img src="https://media.giphy.com/media/N256GFy1u6M6Y/giphy.gif">';
      
     // Iniciar uma requisição
     xmlreq.open("GET", "/mostrar_curtidas_galeria_perfil", true);
     
      
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

/*
 function editar_img_perfil(){
     // Declaração de Variáveis
    var div = document.getElementsByClassName("editar_img_perfil");
    var input = document.getElementById("edit_img");
     

     var xmlreq = CriaRequest();
      
     // Exibi a imagem de progresso
     //result.innerHTML = '<img src="https://media.giphy.com/media/N256GFy1u6M6Y/giphy.gif">';
      
     // Iniciar uma requisição
     xmlreq.open("GET", "/editar_perfil", true);
     
      
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
          
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
              
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 console.log(xmlreq);
                 
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }*/