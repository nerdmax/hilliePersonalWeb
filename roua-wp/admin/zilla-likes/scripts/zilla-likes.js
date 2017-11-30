jQuery(document).ready(function($){

	$('.zilla-likes').live('click',
	    function() {
    		var link = $(this);
    		if(link.hasClass('active')) return false;
		
    		var id = $(this).attr('id'),
    			postfix = link.find('.zilla-likes-postfix').text();
			
    		$.post(zilla_likes.ajaxurl, { action:'zilla-likes', likes_id:id, postfix:postfix }, function(data){
    			link.html(data).prepend('<i class="fa fa-heart"></i>').addClass('active').attr('title','You already like this.');
    		});
		
    		return false;
	});
	
	if( $('body.ajax-zilla-likes').length ) {
        $('.zilla-likes').each(function(){
    		var id = $(this).attr('id');
    		$(this).load(zilla_likes.ajaxurl, { action:'zilla-likes', post_id:id }, function(){
                $(this).prepend('<i class="fa fa-heart-o"></i>');
                if( $(this).hasClass('active') ) {
                    $(this).find('i').removeClass('fa-heart-o').addClass('fa-heart');
                }
            });
    	});
	}

    if( $('.zilla-likes').hasClass('active') ) {
        $('.zilla-likes.active > i').removeClass('fa-heart-o').addClass('fa-heart');
    }

});