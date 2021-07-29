<script>
    $(document).ready(function () {
        //loading image preview
        $("#ImageSelector").change(function () {
            let file = $("#ImageSelector")[0].files[0];
            let fr = new FileReader();
            fr.onload = function () {
                $("#ImagePreview").attr("src", fr.result);
								$("#ImagePreview").removeClass("d-none");
            };
            fr.readAsDataURL(file);
        });
    });
</script>
