$(document).ready(function() {

    //afficher le mot de passe quand on flotter sur l'oeil 
    var showpass = $('.password');
    $('.show-pass').hover(function() {
        showpass.attr('type', 'text');
    }, function() {
        showpass.attr('type', 'password')
    }); //fin de fonction oeil


    //étoile
    $('input').each(function() {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="etoile">*</span>');
        }
    });

    //dashboard affiche-plus-moins
    $('.tog-info').click(function() {
        $(this).toggleClass('selectionner').parent().next('.card-body').fadeToggle(300);
        if ($(this).hasClass('selectionner')) {
            $(this).html("<i class='fa fa-chevron-circle-down'></i>");
        } else {
            $(this).html("<i class='fa fa-chevron-circle-up'></i> ");
        }
    });



    //Message de confirmation avant la suppression
    $('.confirmation').click(function() {
        return confirm('Vous-êtes sûre?');
    });


    //afficher les propriétés d'un produit
    $('.affichag-produit').click(function() {
        $(this).next('.full-view').fadeToggle(200);
    });

});