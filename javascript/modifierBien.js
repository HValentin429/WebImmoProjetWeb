var queryString = new URLSearchParams(location.search);


$(document).ready(function() {
    queryString = new URLSearchParams(location.search);
    $.ajax({    //create an ajax request to display
        type: "GET",
        url: "serveur/recuperationPersonne_serveur.php",
        //dataType: "json",
        success: function(data){
            var recup = jQuery.parseJSON(data);
            var container = document.getElementById("proprietaire");

            for (var i = 0; i < recup.length; i++) {
                var option = document.createElement("OPTION");

                option.innerHTML = recup[i].nom + " " + recup[i].prenom;
                option.value = recup[i].id_personne;

                container.appendChild(option);
            }

        }

    });
    rechercheDetailModif();


});

function rechercheDetailModif(){
    $.ajax({    //create an ajax request to display
        type: "GET",
        data: {
            id: queryString.get('id')
        },
        url: "serveur/recuperationDetail.php",
        //dataType: "json",
        success: function(data){
            var recup = jQuery.parseJSON(data);
            document.getElementById("id_bienImmobilier").value = recup.id_bienImmobilier;
            document.getElementById("typeBien").value = recup.typeBien;
            document.getElementById("nRue").value = recup.nRue;
            document.getElementById("rue").value = recup.rue;
            document.getElementById("codePostal").value = recup.codePostal;
            document.getElementById("ville").value = recup.ville;
            document.getElementById("cuisine").value = recup.cuisine;
            document.getElementById("chauffage").value = recup.chauffage;
            document.getElementById("parking").value = recup.parking;
            document.getElementById("proprietaire").value = recup.proprietaire;
            document.getElementById("nbPieces").value = recup.nbPieces;
            document.getElementById("prix").value = recup.prix;
            document.getElementById("PEB").value = recup.PEB;
            document.getElementById("commentaire").value = recup.commentaire;
            document.getElementById("surface").value = recup.surface;
            if(recup.controleElectricite >= 1){
                document.getElementById("Controle_OK").checked = true;
            }else{
                document.getElementById("Controle_NOK").checked = true;
            }
            if(recup.achatLocation = "ACHAT"){
                document.getElementById("achat").checked = true;
            }else if(recup.achatLocation = "LOCATION"){
                document.getElementById("location").checked = true;
            }
        }

    });
}

$('#modifier').click(function(e){
    //demande au navigateur de ne pas envoyer le formulaire en mode normal
    e.preventDefault();
    f_resetErreurs();
    var erreur = f_validationModif();

    if(erreur == true){

    } else {
        var obj = document.getElementById('encoderBien');
        var formData = new FormData(obj);
        var path = "serveur/modifierBien_serveur.php";
        $.ajax({
            async: true,
            type: "POST",
            url: path,
            data: formData,
            dataType: "html",
            success: function(save){
                document.getElementById('feedback').innerText = "Modification reussie";
                document.getElementById('feedback').className = "alert alert-success";

            },
            error:function(){
                document.getElementById('feedback').innerText = "Modification échouée";
                document.getElementById('feedback').className = "alert alert-danger";
            },
            processData: false,
            contentType: false
        });
    }

});

$('#supprimer').click(function(e){
    //demande au navigateur de ne pas envoyer le formulaire en mode normal
    e.preventDefault();
    f_resetErreurs();
        var obj = document.getElementById('encoderBien');
        var formData = new FormData(obj);
        var path = "serveur/supprimerBien_serveur.php";
        $.ajax({
            async: true,
            type: "POST",
            url: path,
            data: formData,
            dataType: "html",
            success: function(){
                document.getElementById('feedback').innerText = "suppression reussie";
                document.getElementById('feedback').className = "alert alert-success";
                window.location.href="index.html";

            },
            error:function(){
                document.getElementById('feedback').innerText = "Suppression échouée";
                document.getElementById('feedback').className = "alert alert-danger";
            },
            processData: false,
            contentType: false
        });
});

function f_validationModif(){
    var id_bienImmobilier,chauffage,surface,commentaire,PEB,cuisine,controleElectricite,nbPieces ,parking,typeBien,proprietaire,achatLocation, nRue, rue, ville, codePostal,prix;
    var regexText = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/;
    var regexTextFull = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'()-]+$/;
    var regexNombreEntier = /^[1234567890]+$/;
    var regexnRue = /^[a-zA-Z1234567890 ,./-]+$/;
    var regexNombreEntierPlus = /^[1234567890 ,.]+$/;
    var regexNombreDecimal = /^[1234567890,.]+$/;
    var erreur = false;

    //adresse = $('#adresse').val().toLowerCase();

    id_bienImmobilier =$('#id_bienImmobilier').val();
    nRue = $('#nRue').val();
    rue = $('#rue').val().toLowerCase();
    ville = $('#ville').val().toLowerCase();
    codePostal = $('#codePostal').val();
    chauffage = $('#chauffage').val();
    surface = $('#surface').val();
    commentaire = $('#commentaire').val();
    PEB = $('#PEB').val();
    cuisine = $('#cuisine').val();
    prix=$('#prix').val();

    nbPieces = $('#nbPieces').val();
    parking = $('#parking').val()
    typeBien = $('#typeBien').val();
    proprietaire = $('#proprietaire').val();



    var tabZone = [id_bienImmobilier,nRue,rue,codePostal,ville,chauffage,surface,commentaire,cuisine,nbPieces ,parking,prix]
    for (let i =0; i < tabZone.length; i++){
        tabZone[i] = tabZone[i].trim();
    }

    controleElectricite ="";
    if($('#Controle_OK').is(':checked'))
        controleElectricite = $('#Controle_OK').val();
    else if($('#Controle_NOK').is(':checked'))
        controleElectricite = $('#Controle_NOK').val();
    else{
        document.getElementById("er_controleElec").innerHTML = "Veuillez choisir une option";
    }


    achatLocation = "";
    if($('#achat').is(':checked'))
        achatLocation = $('#achat').val();
    else if($('#location').is(':checked'))
        achatLocation = $('#location').val();
    else{
        document.getElementById("er_achatLocation").innerHTML = "Veuillez choisir une option";
    }


    if(nRue.length === 0){
        document.getElementById("er_nRue").innerHTML = "Le numero de rue est obligatoire";
        erreur = true;
    } else if(!regexnRue.test(nRue)){
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
    } else if(!regexText.test(rue)){
        document.getElementById("er_ville").innerHTML = "Veuillez renseigner un nom de ville valide";
        erreur = true;
    }

    if(chauffage.length === 0){
        document.getElementById("er_chauffage").innerHTML = "Le chauffage est obligatoire";
        erreur = true;
    } else if(!regexText.test(chauffage)){
        document.getElementById("er_chauffage").innerHTML = "Veuillez renseigner une type de chauffage valide";
        erreur = true;
    }

    if(!regexTextFull.test(commentaire)){
        document.getElementById("er_commentaire").innerHTML = "Veuillez renseigner un commentaire valide";
        erreur = true;
    }


    if(cuisine.length === 0){
        document.getElementById("er_cuisine").innerHTML = "Le type de cuisine est obligatoire";
        erreur = true;
    } else if(!regexText.test(cuisine)){
        document.getElementById("er_cuisine").innerHTML = "Veuillez renseigner un type de cuisine valide";
        erreur = true;
    }

    if(parking.length === 0){
        document.getElementById("er_parking").innerHTML = "Le type de parking est obligatoire";
        erreur = true;
    } else if(!regexText.test(parking)){
        document.getElementById("er_parking").innerHTML = "Veuillez renseigner un type de parking valide";
        erreur = true;
    }

    if(nbPieces.length === 0){
        document.getElementById("er_nbPieces").innerHTML = "Le nombre de piece ne peut être vide";
        erreur = true;
    } else if(!regexNombreEntier.test(nbPieces)){
        document.getElementById("er_nbPieces").innerHTML = "Le nombre de pieces doit contenir uniquement des chiffres entier";
        erreur = true;
    }

    if(prix.length === 0){
        document.getElementById("er_prix").innerHTML = "Le prix ne peut être vide";
        erreur = true;
    } else if(!regexNombreEntierPlus.test(prix)){
        document.getElementById("er_prix").innerHTML = "Le prix doit contenir uniquement des chiffres entier";
        erreur = true;
    }

    if(surface.length === 0){
        document.getElementById("er_surface").innerHTML = "La surface ne peut être vide";
        erreur = true;
    } else if(!regexNombreDecimal.test(surface)){
        document.getElementById("er_surface").innerHTML = "La surface doit contenir uniquement des chiffres";
        erreur = true;
    }


    if(PEB.length === 0){
        document.getElementById("er_PEB").innerHTML = "Le PEB ne peut être vide";
        erreur = true;

    } else if(!regexText.test(PEB)){
        document.getElementById("er_PEB").innerHTML = "Le PEB contenir uniquement du texte";
        erreur = true;
    }

    return erreur;
}

function f_resetErreurs(){
    //document.getElementById("er_adresse").innerHTML = "";
    document.getElementById("er_chauffage").innerHTML = "";
    document.getElementById("er_commentaire").innerHTML = "";
    document.getElementById("er_surface").innerHTML = "";
    document.getElementById("er_nbPieces").innerHTML = "";
    document.getElementById("er_parking").innerHTML = "";
    document.getElementById("er_PEB").innerHTML = "";
    document.getElementById("er_cuisine").innerHTML = "";
    document.getElementById("er_proprietaire").innerHTML = "";
    document.getElementById("er_nRue").innerHTML = "";
    document.getElementById("er_rue").innerHTML = "";
    document.getElementById("er_codePostal").innerHTML = "";
    document.getElementById("er_ville").innerHTML = "";
    document.getElementById("er_prix").innerHTML = "";
    document.getElementById("er_achatLocation").innerHTML = "";
    document.getElementById("er_controleElec").innerHTML = "";
}
