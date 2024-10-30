jQuery(document).ready(function() {	

  if (jQuery('.wherecookd').attr('last')=='top') {
    jQuery('input[name="wherecookd"][value="top"]').attr('checked','checked');
  }else{
    jQuery('input[name="wherecookd"][value="bottom"]').attr('checked','checked');
  }

  if (jQuery('.singleonly').attr('last')=='true') {
	  jQuery('input[name="singleonly"][value="true"]').attr('checked','checked');
  }else{
	  jQuery('input[name="singleonly"][value="false"]').attr('checked','checked');
  }
  
  jQuery('a.postcookd').click(function(){
    
    if (jQuery(this).attr('cookdopt')=='out') {
      jQuery(this).attr('cookdopt','in');
      jQuery.ajax('../wp-content/plugins/cookd/ajax.php?action=opt&id='+jQuery(this).attr('postid')+'&val=in');
      //jQuery('#post'+jQuery(this).attr('postid')).val('in');            
    } else {
      jQuery(this).attr('cookdopt','out');
      jQuery.ajax('../wp-content/plugins/cookd/ajax.php?action=opt&id='+jQuery(this).attr('postid')+'&val=out');
      //jQuery('#post'+jQuery(this).attr('postid')).val('out');
    }
  
    return false;
  
  });
  
  if (blog=jQuery('div.changes').attr('blog')) { 
    jQuery.ajax( "http://cookd.it/embed/ajax.php?action=blogger&blog="+blog+"&email="+jQuery('#email').val()+"&blogtag="+jQuery('#blogtag').val()+"&befirst="+jQuery('#befirst').val()+"&blogname="+jQuery('#blogname').val()+"&url="+jQuery('#url').val()+"&fbpage="+jQuery('#fbpage').val()+"&fbid="+jQuery('#fbid').val()+"&fbtag="+jQuery('#fbtag').val()+"&lang="+jQuery('#lang').val());
  }
  if (blog=jQuery('#cookdprofpic').attr('blog')) { 
    jQuery.ajax( "http://cookd.it/embed/ajax.php?action=bloggerpic&blog="+blog+"&foto="+jQuery('#cookdprofpic').attr('src'));
  }
  
	
});
