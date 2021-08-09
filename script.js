(function($){
    "use strict";

    var mediaUploader;
    var $activeInpWrap = null;

    // Upload button click functionality
    $(document).on('click', '.img-upload-btn', function(e){
        e.preventDefault();

        let $btn = $(this);
        $activeInpWrap = $btn.closest('.forminp');

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media(
            {
                title: wc_custom_img_field.select_image,
                button: {
                    text: wc_custom_img_field.select_image
                }, 
                multiple: false 
            }
        );
        
        // On selecting an image
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $activeInpWrap.find('input').val(attachment.url);
            $activeInpWrap.find('.uploaded-img img').attr('src', attachment.url);
            $activeInpWrap.find('.uploaded-img').addClass('visible');

            // Hide the upload button
            $activeInpWrap.find('.img-upload-btn').removeClass('visible');
        });

        mediaUploader.open();
    });


    // On click delete button inside selected image
    $(document).on('click', '.img-delete-icon', function(e){
        e.preventDefault();
        let $inpWrap = $(this).closest('.forminp');
        $inpWrap.find('.uploaded-img').removeClass('visible');
        $inpWrap.find('input').val('');
        $inpWrap.find('.img-upload-btn').addClass('visible');
    });

})(jQuery);