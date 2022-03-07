
(function( $ ) {
	'use strict';
	$( document ).ready(function() {
		console.log(php_vars);
	    var main = document.getElementsByTagName('main');
	    var new_container = document.createElement('div');
	    var titile_container = document.createElement('h3');
	    var content_container = document.createElement('p');
	    new_container.classList.add('wp-container');
	    new_container.classList.add('wp-block-group');
	    new_container.setAttribute('id','ad_container');
	    titile_container.setAttribute('id','ad_title');
	    content_container.setAttribute('id','ad_content');

	    titile_container.textContent = php_vars.pa_title;
	    content_container.textContent = php_vars.pa_content;

	    new_container.appendChild(titile_container);
	    new_container.appendChild(content_container);
	    main[0].prepend(new_container);
	})
})( jQuery );
