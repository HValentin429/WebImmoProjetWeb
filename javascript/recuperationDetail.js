
var queryString = new URLSearchParams(location.search);


$(document).ready(function() {
    queryString = new URLSearchParams(location.search);
    recherchePhotos();
    rechercheDetail();
});

function rechercheDetail(){
    $.ajax({    //create an ajax request to display
        type: "GET",
        data: {
            id: queryString.get('id')
        },
        url: "serveur/recuperationDetail.php",
        //dataType: "json",
        success: function(data){
            var recup = jQuery.parseJSON(data);
            var mainContainer = document.getElementById("description");

            var titre = document.createElement("H2");
            titre.appendChild(document.createTextNode(recup.typeBien.toUpperCase() +" avec " + recup.nbPieces + " chambre(s)"));
            //titre.className="text-primary";

            var commentaire = document.createElement("p");
            commentaire.className="text-secondary";
            var infotechniques = document.createElement("p")
            infotechniques.className="text-secondary";
            var infoPrixLocalisation = document.createElement("p");
            infoPrixLocalisation.className="text-secondary";

            const buttonModif = document.createElement("a");
            buttonModif.href="modifier.html?id="+recup.id_bienImmobilier;
            buttonModif.className="btn btn-outline-success";
            buttonModif.innerHTML="Modifier";


            mainContainer.appendChild(titre)
            mainContainer.appendChild(document.createElement("br"));
            mainContainer.appendChild(commentaire);
            mainContainer.appendChild(infotechniques);
            mainContainer.appendChild(infoPrixLocalisation);
            mainContainer.appendChild(buttonModif);
            commentaire.appendChild(document.createTextNode(recup.commentaire));
            commentaire.appendChild(document.createElement("br"));

            infotechniques.appendChild(document.createTextNode("Surface :" + recup.surface + "m²"));
            infotechniques.appendChild(document.createElement("br"));
            infotechniques.appendChild(document.createTextNode("Chauffage :" + recup.chauffage));
            infotechniques.appendChild(document.createElement("br"));
            infotechniques.appendChild(document.createTextNode("Cuisine :" + recup.cuisine));
            infotechniques.appendChild(document.createElement("br"));
            infotechniques.appendChild(document.createTextNode("PEB :" + recup.PEB));
            infotechniques.appendChild(document.createElement("br"));

            infoPrixLocalisation.appendChild(document.createTextNode(recup.achatLocation.toUpperCase()+ '    ' + recup.prix + " €"));
            if(recup.achatLocation.toUpperCase() == "LOCATION"){
                infoPrixLocalisation.appendChild(document.createTextNode(" par mois"));
            }
            infoPrixLocalisation.appendChild(document.createElement("br"));
            infoPrixLocalisation.appendChild(document.createTextNode(recup.codePostal + '    '+ recup.ville));

        }

    });
}


function recherchePhotos(){
    $.ajax({    //create an ajax request to display
        type: "GET",
        data: {
            id: queryString.get('id')
        },
        url: "serveur/recuperationPhotos.php",
        //dataType: "json",
        success: function(data){
            var recup = jQuery.parseJSON(data);
            var mainContainer = document.getElementById("carouselPhotoBien");

            for(var i=0; i < recup.length; i++){
                var photoCarousel = document.createElement("div");
                photoCarousel.className="carousel-item";
                if(i == 0){
                    photoCarousel.className="carousel-item active";
                }
                else{
                    photoCarousel.className="carousel-item";
                }
                var photo=document.createElement("img");
                photo.className = "d-block w-100 img-responsive";
                photo.src = "ressources/uploads/"+recup[i];
                //photo.style.maxHeight="500px";
                mainContainer.appendChild(photoCarousel);
                photoCarousel.appendChild(photo);
            }
        }

    });
}




