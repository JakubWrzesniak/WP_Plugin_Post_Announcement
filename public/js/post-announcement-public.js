
(function( $ ) {
	'use strict';
	$( document ).ready(function() {
		console.log(php_vars);
	    var main = document.getElementsByTagName('main');
	    var new_container = document.createElement('div');
	    var titile_container = document.createElement('h3');
	    var content_container = document.createElement('p');
	    new_container.classList.add('wp-container-post-announcement');
	    new_container.classList.add('wp-block-group');
	    titile_container.textContent = php_vars.pa_title;
	    content_container.textContent = php_vars.pa_content;

	    new_container.appendChild(titile_container);
	    new_container.appendChild(content_container);
	    main[0].prepend(new_container);
	})
})( jQuery );
