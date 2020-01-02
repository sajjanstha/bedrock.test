<script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function ($) {
        $('.contact-modal a').click(function () {
                $('.contact-modal').find('a').attr('data-toggle', 'modal');
                $('.contact-modal').find('a').attr('data-target', '#modal-contact');
            }
        );
        $('#contactModalClose svg').click(function () {
                $('.wpcf7-response-output').hide();
                $('.wpcf7-not-valid-tip').hide();
            }
        );
    });
</script>
