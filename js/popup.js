jQuery(document).ready(function() {	

  var lang="en_US";
  
  var boxes='<div class="cookdboxes">  <div class="window cookd-popup">   <a href="#" class="close"></a>  <iframe style="width: 100%; height: 550px; border: none;margin: 0;padding: 0;" src2load="http://cookd.it/manage/framed.php?lang='+lang+'&recipe="/>  </div> <div class="mask"></div></div>'; 
  jQuery('body').append(boxes);
  var mask=jQuery('.mask').detach();
  jQuery('body').append(mask);


	//select all the a tag with name equal to modal
	jQuery('a[name="modal"]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//hide Flash		
		jQuery('object, embed, iframe').addClass('cookdmask');
		jQuery('.cookdboxes iframe').removeClass('cookdmask');
				

		//Get the A tag
		var id = jQuery(this).attr('href');
		var recipe = jQuery(this).attr('recipe');
	
        var src2load=jQuery('iframe',id).attr('src2load');
        jQuery('iframe',id).attr('src',src2load+recipe);
		
		//Get the screen height and width
		var maskHeight = jQuery(document).height();
		var maskWidth = jQuery(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		jQuery('.mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		//jQuery('.mask').fadeIn(1000);	
		jQuery('.mask').fadeTo("fast",0.8);	
	
		//Get the window height and width
		var winH = jQuery(window).height();
		var winW = jQuery(window).width();
              
		//Set the popup window to center
		jQuery(id).css('top',  winH/2-jQuery(id).height()/2);
		jQuery(id).css('left', winW/2-jQuery(id).width()/2);
	
		//transition effect
		//jQuery(id).fadeIn(2000); 
		jQuery(id).fadeIn(2); 
	
	});
	
	//if close button is clicked
	jQuery('.cookdboxes .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		jQuery('.cookd-bar').each( function() {
      var id=jQuery(this).attr('id');
      var lang=jQuery(this).attr('lang');
      jQuery(this).load('http://cookd.it/embed/frame.php',{'recipe':id, 'lang': lang});
		});
		
		
		jQuery('.cookdmask').removeClass('cookdmask');
		
		jQuery('.mask').hide();
		jQuery('.window').hide();
	});	

	//if mask is clicked
	//jQuery('.mask').click(function () {
	//	jQuery(this).hide();
	//	jQuery('.window').hide();
	//});			
	

	jQuery(window).resize(function () {
	 
 		var box = jQuery('.cookdboxes .window');
 
        //Get the screen height and width
        var maskHeight = jQuery(document).height();
        var maskWidth = jQuery(window).width();
      
        //Set height and width to mask to fill up the whole screen
        jQuery('.mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = jQuery(window).height();
        var winW = jQuery(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});	
	
});
