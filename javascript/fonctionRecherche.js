$('#bouttonRecherche').click(function(e){
    //demande au navigateur de ne pas envoyer le formulaire en mode normal
    e.preventDefault();
    let url = new URL(window.location);
    let tmp = document.getElementById("type").value;
    if(tmp != null && tmp!=""){
        url.searchParams.set("type",  tmp);
    }
    tmp = document.getElementById("codePostal").value;
    if(tmp != null && tmp!=""){
        url.searchParams.set("codePostal",tmp);
    }
    url.searchParams.set("page","1");
    window.location = url;
});