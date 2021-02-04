var nbElement = 6;
var lastId = 0;
var nombrePages = 1;
var queryString;
var page_span = document.getElementById("page");


document.getElementById("bouttonRecherche").addEventListener("click", function(){
    recherche();
});



$(document).ready(function() {
    queryString = new URLSearchParams(location.search);
    numPages();
    f_recuperationServeur();
});

//ajoute l'attribut page si absent et l'initialise à 1
function assignPage(){

    if( queryString.get('page') == null){
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set("page","1");
        window.location.search = urlParams;
        document.getElementById('page').innerHTML="1";
    }
    page_span.innerHTML = queryString.get('page');


}

$('#btnPrevious').click(function(e){
    prevPage();
});

$('#btnNext').click(function(e){
    nextPage();
});

function prevPage() {
    if (queryString.get('page') > 1) {
        validatePage(parseInt(queryString.get('page'))-1);
    }
}

function nextPage()
{
    if (queryString.get('page') < nombrePages) {
        validatePage(parseInt(queryString.get('page'))+1);
    }
}

function numPages(){

    queryString = new URLSearchParams(location.search);
    $.ajax({
        type: "GET",
        data: {

            codePostal: queryString.get('codePostal'),
            typeListing: queryString.get('typeListing'),
            type: queryString.get('type')
        },
        url: "serveur/pagination.php",
        //dataType: "json",
        success: function (data) {
            nombrePages = Math.ceil(parseInt(data)/nbElement);
            //nombrePages = 50; //test pagination
            //Une fois le nombre de page recupere, on lance les operations suivantes.
            assignPage();
            //validatePage(queryString.get('page'));
            }
    });
}

//valide si la page exi
// ste ou non
function validatePage(page){
    var btnNext = document.getElementById("btnNext");
    var btnPrevious = document.getElementById("btnPrevious");

    var validationOK = true;




    if (page < 1) {
        page = 1
        validationOK = false;
    } else if (page > nombrePages) {
        page = nombrePages;
        validationOK = false;
    } else if (page > 0 && page <= nombrePages){
        const urlParams = new URLSearchParams(window.location.search);

    } else{
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set("page","1");
        window.location.search = urlParams;
        document.getElementById('page').innerHTML="1";
    }

    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set("page",page);
    window.location.search = urlParams;
    page_span.innerHTML = page;

    if (page == 1) {
        btnPrevious.style.visibility = 'hidden';
    } else {
        btnPrevious.style.visibility = 'visible';
    }

    if (page == nombrePages) {
        btnNext.style.visibility = 'hidden';
    } else {
        btnNext.style.visibility = 'visible';
    }
}