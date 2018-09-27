( function( $ ) {
	"use strict";
	/*
	*	Déplace le Gallery product vers le milieu de l'écran
	*/
	$('#product-gallery').append( $('#woocommerce-product-images') );


	$('body').on('click', '#action-image', function(e) {
		e.preventDefault();

			var button = $(this),
			custom_uploader = wp.media({
				title: 'Insert image',
				library : {
					// uncomment the next line if you want to attach image to the current post
					// uploadedTo : wp.media.view.settings.post.id,
					type : 'image'
				},
				button: {
					text: 'Use this image' // button label text
				},
				multiple: false // for multiple image selection set to true
			}).on('select', function() { // it also has "open" and "close" events
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				// $(button).removeClass('button')
				// 		 .html('<img class="true_pre_image" id="img" src="' + attachment.url + '" style="max-width:95%;display:block;" />')
				// .next().val(attachment.id).next().show();

				$('.true_pre_image').attr('src', attachment.url);
				$('.description').hide();
				$('#image-product').val(attachment.url);
			})

		.open();
	});

	$('body').on('click', '#action-image-hero', function(e) {
		e.preventDefault();

			var button = $(this),
			custom_uploader = wp.media({
				title: 'Insert image',
				library : {
					// uncomment the next line if you want to attach image to the current post
					// uploadedTo : wp.media.view.settings.post.id,
					type : 'image'
				},
				button: {
					text: 'Use this image' // button label text
				},
				multiple: false // for multiple image selection set to true
			}).on('select', function() { // it also has "open" and "close" events
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				// $(button).removeClass('button')
				// 		 .html('<img class="true_pre_image" id="img" src="' + attachment.url + '" style="max-width:95%;display:block;" />')
				// .next().val(attachment.id).next().show();

				$('.true_pre_image_hero').attr('src', attachment.url);
				$('.description_hero').hide();
				$('#hero-product').val(attachment.url);
			})

		.open();
	});

	/* Désactivation des catégorie parent dans l'ajout de produit */

	$('#in-product_cat-21').attr('disabled', true).css('cursor', 'default');
	$('#in-product_cat-24').attr('disabled', true).css('cursor', 'default');
	$('#in-product_cat-28').attr('disabled', true).css('cursor', 'default');

})( jQuery );
