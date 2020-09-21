// slider hook
$(window).load(function() {
	$('.flexslider').flexslider({
		slideshow: true,
		animation: "slide",
		slideshowSpeed: 5000,
		animationSpeed: 1000,
		
		pauseOnAction: false,
		mousewheel:true
	});
});

// // SWIPE NOT FINISHED (testing)
// $(document).on('swiperight', document, function(){ //on swiperight
	
// 	// var current_page = $('input.current_page_listing').val(); // in listing there are hidden inputs 
// 	// var total_pages  = $('input.total_page_listing').val();
// 	// var query = location.href; // complete url
// 	// query = query.replace("?page="+current_page,""); // parse string to remove search string
 	
//  // 	alert(query+" "+total_pages+" "+current_page);
//  // 	// controls swipe, not to go above last page
//  // 	if(total_pages > current_page){
//  // 		current_page++;	
//  // 		window.location.replace(query+"?page="+current_page);
//  // 	}
//  // 	
 

//   // Alter the url according to the anchor's href attribute, and
//   // store the data-foo attribute information with the url
//   $.mobile.navigate( this.attr( "href" ), {
//     foo: this.attr("data-foo")
//   });
//  });

// $(document).on('swipeleft', document, function(){ 
// 	var current_page = $('input.current_page_listing').val(); // in listing there are hidden inputs 
// 	var total_pages  = $('input.total_page_listing').val();
// 	var query = location.href; // complete url
// 	query = query.replace("?page="+current_page,""); // parse string to remove search string
 	
//  	alert(query);
//  	// controles swipe, not to go below first page, 
//  	// and if it is first one removes search query string
//  	if(current_page != 1){
//  		if(current_page == 2){
//  			current_page--;	
//  			window.location.replace(query);
//  		}else{
//  			current_page--;	
//  			window.location.replace(query+"?page="+current_page);	
//  		}
 		
//  	}
//  });

// Set the country code if is set on general.country
// Whatsapp number input could appear on register and edit profile page (user custom field)
if ($('input#cf_whatsapp').length) {
        console.log('yo');
    if ($("input#cf_whatsapp").attr('data-country-code') && !$('input#cf_whatsapp').val()) {
        var country_code = $('input#cf_whatsapp').data('country-code');
        $('input#cf_whatsapp').val('00'+country_code);
    }
}
