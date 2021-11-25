$(function() {
    var span = $("#span-text");
    var title = $("#title-text");
    var description = $("#description-text");
    $("#span").on("keyup", function() {
        var texto = $(this).val();
        span.text(texto);
    });
    $("#title").on("keyup", function() {
        var texto = $(this).val();
        title.text(texto);
    });
    $("#description").on("keyup", function() {
        var texto = $(this).val();
        description.text(texto);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#banner-class").css(
                    "background-image",
                    "url(" + e.target.result + ")"
                );
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function() {
        readURL(this);
    });
});
