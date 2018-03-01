$('.btn-webforce').click(function (event) {

    var errors = [];
    var name = $('#name').val();
    var email = $('#email').val();
    var message = $('#message').val();

    $('.form-control').removeClass('is-invalid'); // reset tous les champs
    $('p.invalid-feedback').remove();

    if (name.length < 1) {
        $('#name').addClass('is-invalid');
        errors.push('Erreur sur le name');
        $('#name').after('<p class="invalid-feedback">Le nom n\'est pas valide</p>');
    }

    var regex = /[a-zA-Z0-9._-]{1,}@[a-zA-Z0-9._-]{1,}\.[a-zA-Z]{2,}/g;
    var emailIsValid = email.match(regex);
    if (emailIsValid == null || emailIsValid[0] != email) {
        $('#email').addClass('is-invalid');
        errors.push('Erreur sur l\'email');
        $('#email').after('<p class="invalid-feedback">L\'email n\'est pas valide</p>');
    }

    if (message.length < 10) {
        $('#message').addClass('is-invalid');
        errors.push('Erreur sur le message');
        $('#message').after('<p class="invalid-feedback">Le message n\'est pas valide</p>');
    }

    if (errors.length != 0) { // Si le formulaire n'est pas valide
        event.preventDefault();
    }

});