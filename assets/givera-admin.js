jQuery(document).ready(function($) {
    var mediaUploader;

    $('#givera-attachment-button').click(function (e) {
        e.preventDefault();
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Attachment',
            button: {
                text: 'Choose Attachment'
            }, multiple: false
        });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            //var  attachment = file_frame.state().get('selection').first().toJSON();
            $('#_givera_attachment_url').val(attachment.url);
            $('#_givera_link_text').val(attachment.title);
        });
        // Open the uploader dialog
        mediaUploader.open();
    });

    $('span.remove-attachment').click(
        function(){
            $('#_givera_attachment_url').val('');
        });

});