//Функция для превьюшки картинок перед аплоадом
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
    $('a.gallery').colorbox({rel:'avatar_gal'});
    $('a.gallery_profie').colorbox({rel:'profile_gal'});
    $("input[name=photo]").change(function() {
        readURL(this);
    });
    jQuery(document.body).on('click','.status_string',function(){
        var current_status = $(this).html();
        var input_elem = '<input name="status" value="'+current_status+'" class="status_input"/><i class="glyphicon glyphicon-ok" id="save_status"></i>';
        $(this).parent().html(input_elem);
    });
    jQuery(document.body).on('click', '#save_status', function(event) {
        var status = $('input[name=status]').val();
        var status_elem = '<span class="status_string">'+status+'</span>';
        var this_context =  $(this);
        $.ajax({
            url: '/ajax/save_status',
            type: 'POST',
            data: 'status='+status,
            success: function(msg) {
                console.log(msg);
                $(this_context).parent().html(status_elem);

            }
        });


    });
});