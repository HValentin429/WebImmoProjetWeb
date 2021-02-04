//va rechercher dans la BD les biens immobiliers
function f_recuperationServeur(){

    queryString = new URLSearchParams(location.search);
    //change le menu actif
    if(queryString.get('type') == 'ACHAT'){
        var tmp = document.getElementById("accueil");
        tmp.setAttribute("class","nav-item");
        tmp = document.getElementById("location_nav");
        tmp.setAttribute("class","nav-item");
        tmp = document.getElementById("vente_nav");
        tmp.setAttribute("class","nav-item active")
    }

    //change le menu actif
    if(queryString.get('type') == 'LOCATION'){
        var tmp = document.getElementById("accueil");
        tmp.setAttribute("class","nav-item");
        tmp = document.getElementById("location_nav");
        tmp.setAttribute("class","nav-item active");
        tmp = document.getElementById("vente_nav");
        tmp.setAttribute("class","nav-item")
    }



    $.ajax({    //create an ajax request to display
        type: "GET",
        data: {
            codePostal : queryString.get('codePostal'),
            type : queryString.get('type'),
            typeListing : queryString.get('typeListing'),
            cursor: ((parseInt(queryString.get('page'))-1)*nbElement).toString(),
            group: nbElement

        },
        url: "serveur/recuperationBien_serveur.php",
        //dataType: "json",
        success: function(data){
            var recup = jQuery.parseJSON(data);
            var mainContainer = document.getElementById("row");
            //creation des cartes / previews
            for (var i = 0; i < recup.length; i++) {
                const article = document.createElement("article");
                article.className="col-md-4";

                const card = document.createElement("div");
                card.className="card mb-4 box-shadow"


                const image = document.createElement("img");

                if(typeof (recup[i].nomPhoto) == null){
                    image.src ="ressources/uploads/default.png" ;
                }else{
                    image.src ="ressources/uploads/" + recup[i].nomPhoto;
                }

                image.className="card-img-top";
                image.height=250;

                const cardBody = document.createElement("div");
                cardBody.className="card-body";

                const lienArticle = document.createElement("a");
                lienArticle.className="stretched-link";
                lienArticle.href="details.html?id="+recup[i].id_bienImmobilier;

                const cardTextMain = document.createElement("p");
                cardTextMain.className="card-text";


                const cardText1 = document.createTextNode(recup[i].typeBien.toUpperCase());
                const cardText2 = document.createTextNode(recup[i].achatLocation.toUpperCase()+ '    ' + recup[i].prix + " €");
                const cardText3 = document.createTextNode(recup[i].codePostal + '    '+ recup[i].ville);
                const cardText4 = document.createTextNode('Nombre de chambre(s): ' + recup[i].nbPieces);
                const cardText5 = document.createTextNode('Surface: ' + recup[i].surface + 'm²');


                mainContainer.appendChild(article);

                article.appendChild(card);
                card.appendChild(image);
                card.appendChild(cardBody);
                card.appendChild(lienArticle);
                cardBody.appendChild(cardTextMain);
                cardTextMain.appendChild(cardText1);
                cardTextMain.appendChild(document.createElement("br"));
                cardTextMain.appendChild(cardText2);
                if(recup[i].achatLocation.toUpperCase() == "LOCATION"){
                    cardTextMain.appendChild(document.createTextNode(" par mois"));
                }
                cardTextMain.appendChild(document.createElement("br"));
                cardTextMain.appendChild(cardText3);
                cardTextMain.appendChild(document.createElement("br"));
                cardTextMain.appendChild(cardText4);
                cardTextMain.appendChild(document.createTextNode( '\u00A0\u00A0\u00A0\u00A0\u00A0' ));
                cardTextMain.appendChild(cardText5);

                lastId = recup[i].id_bienImmobilier;
            }

        }

    });
};