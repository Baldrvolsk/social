function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#preview_avatar').append('<img src="'+e.target.result+'" width="150" />');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

jQuery(document).ready(function() {
    $('a.gal').colorbox({rel:'gal'});
    $("input[name=photo]").change(function() {
        readURL(this);
    });
});