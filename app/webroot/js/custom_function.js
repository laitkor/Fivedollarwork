
	/*####################################*/
  function limitChars(textid, limit, infodiv) {
	 var text = jQuery('#'+textid).val(); 
	 var textlength = text.length;
	 if(textlength > limit) {
	 	jQuery('#' + infodiv).html('You cannot write more then '+limit+' characters!');
	  	jQuery('#'+textid).val(text.substr(0,limit));
	  	return false;
	  }else{
	  	jQuery('#' + infodiv).html('You have '+ (limit - textlength) +' characters left.');
	  	return true;
	  }
  }
 
	/*####################################*/
	function checkEmail(email) {
        // email validation logic
		if(email == "") return 1;	
        var validateEmail = jQuery('#validateEmail');
		  validateEmail.html('<img src="/images/ajax-loader.gif" height="16" width="16" /> checking availability...'); 
		  
		   jQuery.ajax({
					url: '/user/checkEmail/'+ email,
					data: 'email=' + email,
					dataType: "json",
					type: 'post',
					success: function (j) {
						// put the 'msg' field from the $resp array from check_username (php code) in to the validation message
						validateEmail.html(j.msg);	
						document.getElementById('submit_button').disabled = j.ok;						
						
					}
                 }); 
    }
	
	/*###########  Custom Ajax Function #########################*/
	function callAjaxFunc(calltourl,msgDiv) {        
		
        var validateEmail = jQuery(msgDiv);
		  validateEmail.html('<img src="/images/ajax-loader.gif" height="16" width="16" />'); 
		  
		   jQuery.ajax({
					url: calltourl,					
					dataType: "json",
					type: 'get',
					success: function (j) {						
						validateEmail.html(j.msg);
						setTimeout(function(){
								  validateEmail.fadeOut("slow");
						}, 5000);
						
					}
                 }); 
    }
	
	/*####################################*/
	function checkUserName(usr) {
        // Username validation logic	
		if(usr.length<4) return 1;
        var validateUsername = jQuery('#validateUsername');
		  validateUsername.html('<img src="/images/ajax-loader.gif" height="16" width="16" /> checking availability...'); 
		  
		   jQuery.ajax({
					url: '/user/ajaxCheckUsername/'+ usr,
					data: 'username=' + usr,
					dataType: "json",
					type: 'post',
					success: function (j) {
						// put the 'msg' field from the $resp array from check_username (php code) in to the validation message
						validateUsername.html(j.msg);	
						document.getElementById('submit_button').disabled = j.ok;						
						
					}
                 }); 
    }
	
	/*###########  Custom Ajax Function #########################*/
	function callAjaxFunc(calltourl,msgDiv) {        
		
        var validateUsername = jQuery(msgDiv);
		  validateUsername.html('<img src="/images/ajax-loader.gif" height="16" width="16" />'); 
		  
		   jQuery.ajax({
					url: calltourl,					
					dataType: "json",
					type: 'get',
					success: function (j) {						
						validateUsername.html(j.msg);
						setTimeout(function(){
								  validateUsername.fadeOut("slow");
						}, 5000);
						
					}
                 }); 
    }
	
	// ########### Get Video Rating for adding the style  ############
	function getStarRating(videoid){
			
			jQuery.ajax({
				type: "GET",
				url: "/rating/getrate/"+videoid,
				data: "do=getrate",
				cache: false,
				async: false,
				dataType: "json",
				success: function(j) {
					// apply star rating to element
					jQuery("#current-rating-"+videoid).css({ width: "" + j.result + "%" });
					if(j.showvoting ==0){
						// remove #ratelinks element to prevent another rate
						jQuery("#ratelinks-"+videoid).remove();
					}
				},
				error: function(result) {
					alert("some error occured, please try again later");
				}
			});
		}
		
	// Load More video for latest search
		function loadMore() {
			
			//More Button
			jQuery('.morevideos').live("click",function() {
				var ID = jQuery('.loadmore').attr("id"); //page ID
				//alert("/search/loadMorevideo/"+id+"/"+ID);
				if(ID !=''){
					
					jQuery("#morevideos-"+ID).html('<td></td><td colspan="2" align="center"><img src="/images/ajax-loader.gif" height="16" width="16" /></td>');
					
					jQuery.ajax({
						type: "GET",
						url: "/users/loadMore/"+ID,
						data: "page="+ ID, 
						cache: false,
						success: function(html){									
									jQuery("#updates").append(html);
									
									jQuery("#morevideos-"+ID).remove();
								},
						error: function(result) {
								//alert("some error occured, please try again later");
							}		
					});
				}
				else
				{
				jQuery(".morevideos").remove();				
				}
				return false;
				
			});
		}
		
		
		
		// Load More video for search
		function loadMorevideo(keyword) {
			
			//More Button
			jQuery('.morevideos').live("click",function() {
				var ID = jQuery('.loadmore').attr("id"); //page ID
				//alert("/search/loadMorevideo/"+id+"/"+ID);
				if(ID !=''){
					
					jQuery("#morevideos-"+ID).html('<td></td><td colspan="2" align="center"><img src="/images/ajax-loader.gif" height="16" width="16" /></td>');
					
					jQuery.ajax({
						type: "GET",
						url: "/search/loadMorevideo/"+keyword+"/"+ID,
						data: "page="+ ID, 
						cache: false,
						success: function(html){									
									
									jQuery("#updates").hide().append(html).fadeIn('slow');
									
									jQuery("#morevideos-"+ID).remove();
								},
						error: function(result) {
								//alert("some error occured, please try again later");
							}		
					});
				}
				else
				{
				jQuery(".morevideos").remove();				
				}
				return false;
				
			});
		}


// Load More video for latest search
		function loadMoredonation() {
			
			//More Button
			jQuery('.morevideos').live("click",function() {
				var ID = jQuery('.loadmore').attr("id"); //page ID
				//alert("/search/loadMorevideo/"+id+"/"+ID);
				if(ID !=''){
					
					jQuery("#morevideos-"+ID).html('<td></td><td colspan="2" align="center"><img src="/images/ajax-loader.gif" height="16" width="16" /></td>');
					
					jQuery.ajax({
						type: "GET",
						url: "/search/loadMoredonation/"+ID,
						data: "page="+ ID, 
						cache: false,
						success: function(html){									
									jQuery("#updates").hide().append(html).fadeIn('slow');
									
									jQuery("#morevideos-"+ID).remove();
								},
						error: function(result) {
								//alert("some error occured, please try again later");
							}		
					});
				}
				else
				{
				jQuery(".morevideos").remove();				
				}
				return false;
				
			});
		}
		
		
		
	