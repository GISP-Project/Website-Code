function validaForm(user, pass1, pass2, privacy){

  //espressioni regolari per la password
  //caratteri ammessi
  var regexppass= /[^a-zA-Z]/g;
  //almeno uno minuscolo
  var regexpmin= /[a-z]/;
  //almeno un maiuscolo
  var regexpmax=/[A-Z]/;

  errorspass= pass1.match(regexppass);
  

  if((user.length>=3) && (user.length<=100) && (privacy.checked==true)
       && !errorspass && regexpmin.test(pass1) && regexpmax.test(pass1) && (pass1.length>=4) && (pass1.length<=8) && pass1==pass2 ){
    window.alert("user e password ok");
    return true;
  }else{
    if(user.length<3){
      window.alert("Lo username è troppo breve, deve essere lungo almeno 3 caratteri");
    }
    if(user.length>100){
      window.alert("Lo username è troppo lungo, non può superare i 100 caratteri");
    }
    if (pass1.length<4) {
      window.alert("La password scelta è troppo breve");
    }
    if (pass1.length>8) {
      window.alert("La password scelta è troppo lunga");

    }
    if (pass1!=pass2) {
      window.alert("Le password inserite non corrispondono");
    }

    if (errorspass) {
      window.alert("Nella password scelta ci sono caratteri errati: " + errorspass +". La password può contenere solo caratteri alfabetici");
    }
    if (!regexpmin.test(pass1)) {
      window.alert("Nella password deve esserci almeno un carattere minuscolo");
    }
    if (!regexpmax.test(pass1)) {
      window.alert("Nella password deve esserci almeno un carattere maiuscolo");
    }
	if(privacy.checked==false) {
	  window.alert("E' obbligatorio dare il consenso al trattamento dei dati per la privacy");
	}

    return false;
  }

}

function validaFormLive(pass1, pass2, live){
  var p1= document.getElementById(pass1).value;
  var p2= document.getElementById(pass2).value;
  document.getElementById(live).style.align= "center";
  if (p1==p2) {
    var si="Le password inserite corrispondono";
    document.getElementById(live).value= si;
    document.getElementById(live).style.color= "green";
  } else{
    var no="Le password inserite non corrispondono";
    document.getElementById(live).value= no;
    document.getElementById(live).style.color= "red";
  }

}

function validaFormLiveLength(pass1, live){
  var p1= document.getElementById(pass1).value;
  document.getElementById(live).style.align= "center";
  if (p1.length<4) {
    var breve="La password inserita è troppo breve";
    document.getElementById(live).value= breve;
    document.getElementById(live).style.color= "red";


  } else if(p1.length>8){
    var lunga="La password inserita è troppo lunga";
    document.getElementById(live).value= lunga;
    document.getElementById(live).style.color= "red";

  }
  else{
    var ok="La password inserita è della lunghezza giusta";
    document.getElementById(live).value= ok;
    document.getElementById(live).style.color= "green";
  }
}

function validaLogin(user, pass){
	return true;
}

