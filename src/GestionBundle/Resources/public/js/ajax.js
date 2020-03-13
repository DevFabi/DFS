
/*--------------- AJAX POUR LE FORMULAIRE FILTRE ZONE 2 ---------------*/

$("#form_filtre").submit(function(){ 

/* Récuparation du select role et fonction */
var role = $('#select_role option:selected').val();
var fonction = $('#select_fonction option:selected').val();

/* Récupération valeur des checkbox */
$("input[name='check_base']:checked").each(
          function() {
        var tab_check = $(this).attr('value');
          });          
var check_base = ($("input[name='check_base']:checked").attr('value'));
$("input[name='check_flotte']:checked").each(
          function() {
        var tab_check = $(this).attr('value');
          });          
var check_flotte = ($("input[name='check_flotte']:checked").attr('value'));
        
   
   var DATA = 'role=' + role +'&fonction=' + fonction +'&check_base=' + check_base +'&check_flotte=' + check_flotte;
   var url = $('#filtrePath').data('filtrepath');
    $.ajax({
        type: "POST",
        url: url,
        data: DATA,
        cache: false,
        success: function(data){
           $('#resultats_recherche').html(data);
        }
    });    
    return false;
});
