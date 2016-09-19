// =============== MOTORES AJAX DEL FRAMEWORK-ERP CANAIMA ====================
// Funcionalidades Generales:
// 1 Recuperación de Datos desde el Servidor por diversas modalidades:
//          (1)POST-HTML (2)POST-XML (3)GET-HTML (4)GET-XML
// 2 Reemplazo de respuesta HTML en TAG DESTINO (innerHTML)
// 3 Otras Funciones CallBack para tareas específicas



//se usa
function ObtenerPorPOSTDatosXML(retorno, url, Datos) {
   
  var XMLHttpRequestObject = false;
  if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }

  if (XMLHttpRequestObject) {
    XMLHttpRequestObject.open("POST", url);
    XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    XMLHttpRequestObject.onreadystatechange = function() {
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
        {
          var respPostXML = XMLHttpRequestObject.responseXML;
          retorno(respPostXML);
          delete XMLHttpRequestObject;
          XMLHttpRequestObject = null;
        }
    }
    XMLHttpRequestObject.send(Datos);
  }
}



//se usa
function ObtenerDatosPorPOST(destino, url, Datos) {
      
  var XMLHttpRequestObject = false;
  if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }

  if (XMLHttpRequestObject) {
    XMLHttpRequestObject.open("POST", url);
    XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    XMLHttpRequestObject.onreadystatechange = function() {
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
        {
          var respPostHTML = XMLHttpRequestObject.responseText;
          document.getElementById(destino).innerHTML = respPostHTML;
          delete XMLHttpRequestObject;
          XMLHttpRequestObject = null;
          //$("#respuesta_slider").html("<img src=./imagenes/modulada.png />")
        }
    }
    XMLHttpRequestObject.send(Datos);
  }
}




function CerrarVentana(control){
// alert('activo');
//document.getElementById(control).innerHTML = '';
document.getElementById(control).style.display = 'none';

}


//====================================================================
//Funcion JavaScript valida q solo se acepten numeros
//====================================================================

function validarnumero(evt) {
  //alert(evt);
  evt = (evt) ? evt : event
  var key = (evt.which) ? evt.which : evt.keyCode;
  if (key > 47 && key < 58 || key == 8 || key == 37 || key == 39 || key == 44 || key == 46 || key == 9) { return true;}
  else {return false;}
}


function acceptDecimal(evt){
	evt = (evt) ? evt : event
	var cod = (evt.which) ? evt.which : evt.keyCode;
    var key = String.fromCharCode(cod);
    if(key != ''){
        if((key.search(/^(([0-9]*)|([0-9]*\.[0-9]*))$/) != -1) || (cod == 8) || (cod == 9))
                return true;
        else
                return false;
    }else
    	return true;
}

function acceptDecimalNegativo(evt){
	evt = (evt) ? evt : event
	var cod = (evt.which) ? evt.which : evt.keyCode;
    var key = String.fromCharCode(cod);
    if(key != ''){
        if((key.search(/^-?(([0-9]*)|([0-9]*\.[0-9]*))$/) != -1) || (cod == 8) || (cod == 9))
                return true;
        else
                return false;
    }else
    	return true;
}

//====================================================================
//Funcion JavaScript valida q solo se acepten carateres
//====================================================================

function validartexto(evt) {
  //alert(evt);
  evt = (evt) ? evt : event
  var key = (evt.which) ? evt.which : evt.keyCode;
  if (key > 47 && key < 58 ) { return false;}
  else {return true;}
}




//Funcion para Verificar si el correo esta bien  escrito
function checkmail() {
  if(document.getElementById('correo_electronico').value !=='' ) {
    var email = document.getElementById('correo_electronico').value;
    var ind1, ind2, ind3;
    ind1 = email.indexOf('@');
    ind2 = email.indexOf('.');
    ind3 = email.lastIndexOf('@');
    if ((ind1<=0) || (ind2<ind1) || (ind3!=ind1)) {
      alert('Su direccion de correo esta mal Escrita Verifiquela!!!')
      document.getElementById('correo_electronico').value="";
      Encontrado = true;
      //document.getElementById('correo_electronico').focus();
    } else {
      document.forms['medico'].aceptar.disabled=false; document.forms['medico'].aceptar.focus();
    }
  } else {
    document.forms['medico'].aceptar.disabled=false; document.forms['medico'].aceptar.focus();
  }
}

  
//==================================================================================================
//Funcion JavaScript Para Modificar los Page mediante el MENU
//==================================================================================================

function modificar_titulo(elemento){
	var sub_titulo = document.getElementById('sub_titulo');
	var titulo = document.getElementById('Titulo');	
	titulo.innerHTML = elemento.title+" <small id='sub_titulo'></small>";
	titulo.title=elemento.title;
}
  
//==================================================================================================
//Funcion JavaScript valida que solo se acepten numeros y los caracteres guion(-) y barra (/)
//==================================================================================================

function ValFechaTelf(evt) {
  //alert(evt.which +"    "+evt.keyCode);
  evt = (evt) ? evt : event
  var key = (evt.which) ? evt.which : evt.keyCode;
  if (key > 47 && key < 58 || key == 8 || key == 37 || key == 39 || key == 44 || key == 46 || key == 9 || evt.which == 47 || evt.which == 45) {
    return true;
  } else {
    return false;
  }
}

function  extraer_strtabla(tablaux,retorno) {
  var tabla;
  arraytabla = tablaux.split('_');  
  
  switch (retorno) {
    case 0 :
      tabla = arraytabla[0];       
      break;
    case 1 :
      if(arraytabla[1] == undefined) {
        tabla = arraytabla;
      } else {
        tabla = arraytabla[1];
      }
      break;
    default :
      tabla = tablaux;
  }
  return tabla;
}



//Funcion para Convertir caracteres a Mayuscula
function ConvertirMay(texto) {     
  texto.value = texto.value.toUpperCase();   
}

function ConvertirMin(texto) {     
  texto.value = texto.value.toLowerCase();   
}



function SerializarDatos(){
//var e = '?accion=' + operacion + '&entidad=' + tabla;
var e = '';

for (var a=0; a < document.forms.length; a++) {
  for (var i=0; i < document.forms[a].length; i++) {
    if (document.forms[a].elements[i].type !== "button") {
      if (document.forms[a].elements[i].type == "checkbox" ) {
  // 3.- Anexa cada par campo-valor del formulario si es un checkbox
          e = e + '&' + document.forms[a].elements[i].name + '=';
          e = e + document.forms[a].elements[i].checked;}
      else{
  // 4.- Anexa cada par campo-valor del formulario
          e = e + '&' + document.forms[a].elements[i].name + '=';
          e = e + document.forms[a].elements[i].value;

          }
        }
    }
}
 return e;

}


function validarsolonumero(evt) {
 
  evt = (evt) ? evt : event
  var key = (evt.which) ? evt.which : evt.keyCode;
  //alert(key);
  if (key > 47 && key < 58 || key == 8 || key == 37 || key == 39) { return true;}
  else {return false;}
}


function validarcedula(evt) {
 
  evt = (evt) ? evt : event
  var key = (evt.which) ? evt.which : evt.keyCode;
  //alert(key);
  if (key > 47 && key < 58 || key == 74 || key == 86 || key == 69 || key == 45 || key == 8 || key == 37 || key == 39 || key == 9 || key == 71) { return true;}
  else {return false;}
}




function acceptBorrarFormula(evt){
	evt = (evt) ? evt : event
	var cod = (evt.which) ? evt.which : evt.keyCode;
    var key = String.fromCharCode(cod);
    if(key != ''){
        if((cod == 8) || (cod == 9))
                return true;
        else
                return false;
    }else
    	return true;
}


