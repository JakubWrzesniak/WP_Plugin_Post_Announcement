jQuery( document ).ready( function( $ ) {
        $(document).on( 'click', '.an-delete', function() {
            var id = $(this).data('id');
            var nonce = $(this).data('nonce');
            $.ajax({
                url:    params.ajaxurl, // domain/wp-admin/admin-ajax.php
                type:   'post',                
                data:   {
                    action: 'post_announcement_form_response',
                    nonce: nonce,
                    id: id
                },
            })        
            .done( function( response ) { // response from the PHP action
                location.reload()
            })
                
                // something went wrong  
            .fail( function(xhr, status, error) {
                $(" #ps_form_feedback ").html( "<h2>" + error + ".</h2><br>" );                  
            })
            
                // after all this time?
            .always( function() {
                event.target.reset();
            });
       })
});
