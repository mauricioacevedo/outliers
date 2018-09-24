$("a").live('click', function() {
        $('#loading').show();
        $(document).ready(function() {
            hideLoading();
        });
        function hideLoading() {
            $('#loading').fadeOut(6000);
        }
    });