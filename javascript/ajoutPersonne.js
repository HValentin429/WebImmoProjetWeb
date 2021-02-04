

    function f_resetErreurs(){
    //document.getElementById("er_adresse").innerHTML = "";
    document.getElementById("er_nom").innerHTML = "";
    document.getElementById("er_prenom").innerHTML = "";
    document.getElementById("er_mail").innerHTML = "";
    document.getElementById("er_telephone").innerHTML = "";
    document.getElementById("er_proprietaire").innerHTML = "";
    document.getElementById("er_nRue").innerHTML = "";
    document.getElementById("er_rue").innerHTML = "";
    document.getElementById("er_codePostal").innerHTML = "";
    document.getElementById("er_ville").innerHTML = "";

}

function f_validation(){

    var adresse, nom, prenom, mail, proprietaire,telephone, nRue, rue, codePostal, ville;
    var regexText = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/;
    //var regexAdresse = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.1234567890'-]+$/;
    var regexEmail = /^[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/;
    var regexNombreEntier = /^[1234567890]+$/;
    var regexTelephone = /^[0-9]{8,10}$/;
    var erreur = false;

    nRue = $('#nRue').val();
    rue = $('#rue').val().toLowerCase();
    ville = $('#ville').val().toLowerCase();
    codePostal = $('#codePostal').val();
    nom = $('#nom').val().toUpperCase();
    prenom = $('#prenom').val().toLowerCase();
    mail = $('#mail').val().toLowerCase();
    //proprietaire = $('#proprietaire').val();
    telephone= $('#telephone').val();

    var tabZone = [nRue,rue,codePostal,ville,nom,prenom,mail,telephone]
    for (let i =0; i < tabZone.length; i++){
        tabZone[i] = tabZone[i].trim();
    }


    proprietaire = '';
    if($('#proprietaire').is(':checked')){
        proprietaire = $('#proprietaire').val();
}
    else{
        proprietaire = 0;
}


    if(nRue.length === 0){
        document.getElementById("er_nRue").innerHTML = "Le numero de rue est obligatoire";
        erreur = true;
    } else if(!regexNombreEntier.test(nRue)){
        document.getElementById("er_nRue").innerHTML = "Veuillez renseigner un numero de rue valide";
        erreur = true;
    }

    if(codePostal.length === 0){
        document.getElementById("er_codePostal").innerHTML = "Le code postal est obligatoire";
        erreur = true;
    } else if(!regexNombreEntier.test(codePostal)){
        document.getElementById("er_codePostal").innerHTML = "Veuillez renseigner un code postal valide";
        erreur = true;
    }

    if(rue.length === 0){
        document.getElementById("er_rue").innerHTML = "Le nom de rue est obligatoire";
        erreur = true;
    } else if(!regexText.test(rue)){
        document.getElementById("er_rue").innerHTML = "Veuillez renseigner un nom de rue valide";
        erreur = true;
}

    if(ville.length === 0){
        document.getElementById("er_ville").innerHTML = "Le nom de ville est obligatoire";
        erreur = true;
    } else if(!regexText.test(ville)){
        document.getElementById("er_ville").innerHTML = "Veuillez renseigner un nom de ville valide";
        erreur = true;
    }


    if(nom.length === 0){
        document.getElementById("er_nom").innerHTML = "Le nom est obligatoire";
        erreur = true;
    } else if(!regexText.test(nom)){
        document.getElementById("er_nom").innerHTML = "Veuillez renseigner un nom valide";
        erreur = true;
    }

    if(prenom.length === 0){
        document.getElementById("er_prenom").innerHTML = "Le prenom est obligatoire";
        erreur = true;
    } else if(!regexText.test(prenom)){
        document.getElementById("er_prenom").innerHTML = "Veuillez renseigner un prenom valide";
        erreur = true;
    }

    if(mail.length === 0){
        document.getElementById("er_mail").innerHTML = "Le mail est obligatoire";
        erreur = true;
    } else if(!regexEmail.test(mail)){
        document.getElementById("er_mail").innerHTML = "Veuillez renseigner un mail valide";
        erreur = true;
    }

    if(telephone.length === 0){
        document.getElementById("er_telephone").innerHTML = "Le telephone est obligatoire";
        erreur = true;
    } else if(!regexTelephone.test(telephone)){
        document.getElementById("er_telephone").innerHTML = "Veuillez renseigner un numero de telephone valide";
        erreur = true;
    }

    return erreur;


}

$('#submit').click(function(e){
    //demande au navigateur de ne pas envoyer le formulaire en mode normal
    e.preventDefault();
    f_resetErreurs();
    var erreur = f_validation();
    if(erreur == true){

    } else {
        var obj = document.getElementById('encoderPersonne');
        var formData = new FormData(obj);
        var path = "serveur/ajoutPersonne_serveur.php";
        $.ajax({
            async: true,
            type: "POST",
            url: path,
            data: formData,
            dataType: "html",
            success: function(save){
                $('#encoderPersonne')[0].reset();
                document.getElementById('feedback').innerText = "L'ajout a reussi";
                document.getElementById('feedback').className = "alert alert-success";

            },
            error:function(){
                document.getElementById('feedback').innerText = "L'ajout a échoué";
                document.getElementById('feedback').className = "alert alert-danger";
            },
            processData: false,
            contentType: false
        });
    }
});

$('#rinit').click(function(){
    $('#encoderPersonne')[0].reset();
});

