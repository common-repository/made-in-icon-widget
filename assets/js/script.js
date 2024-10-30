/**
 * Made In Themes - Business
 *
 * Made In Themes - Business theme entry point.
 *
 * @package Made In Themes - Business\JS
 * @author  Made in Themes
 * @license GPL-2.0+
 * @link    https://madeinthemes.com/
 */

jQuery(document).ready( function(){
 function media_upload(button_class) {
    var _custom_media = true,
    _orig_send_attachment = wp.media.editor.send.attachment;
    jQuery('body').on('click',button_class, function(e) {
        var button_id ='#'+jQuery(this).attr('id');
		var widget_id ='#widget-id-'+jQuery(this).attr('id');
        //console.log(button_id);
        var self = jQuery(button_id);
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = jQuery(button_id);
        var id = button.attr('id').replace('_button', '');
        _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment){
            if ( _custom_media  ) {
               //jQuery(widget_id + '.custom_media_id').val(attachment.id); 
               jQuery(widget_id + ' .custom_media_url').val(attachment.url);
               jQuery(widget_id + ' .custom_media_image').attr('src',attachment.url);   
            } else {
                return _orig_send_attachment.apply( button_id, [props, attachment] );
            }
        }
        wp.media.editor.open(button);
		var saveButton = '#widget-'+jQuery(this).attr('id')+'-savewidget';
		jQuery(saveButton).prop( "disabled", false );
        return false;
    });
}

function choose_display(sel) {
	console.log("hola");
	var valueSelected = sel.value;
	var widget_id ='#widget-id-'+jQuery(sel).attr('class');
	if(valueSelected == 'image') {
		jQuery(widget_id + ' #icon-width').css('display', 'none');
		jQuery(widget_id + ' #icon-label').css('display', 'none');
		jQuery(widget_id + ' #image-label').css('display', 'block');
		jQuery(widget_id + ' .icon-update').css('display', 'none');
		jQuery(widget_id + ' .image-update').css('display', 'block');
	}
	else {
		jQuery(widget_id + ' #icon-width').css('display', 'block');
		jQuery(widget_id + ' #icon-label').css('display', 'block');
		jQuery(widget_id + ' #image-label').css('display', 'none');
		jQuery(widget_id + ' .icon-update').css('display', 'block');
		jQuery(widget_id + ' .image-update').css('display', 'none');
	}
}
media_upload( '.custom_media_upload');
window.choose_display=choose_display;
});