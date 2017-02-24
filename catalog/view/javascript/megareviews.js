var MegaReviews = function(){ };

MegaReviews.prototype = {
	text_minreqleft:"Minimum required characters left: ",
	text_minreached:" Minimum reached ",
	_options:null,
	_box:null,
	optdata:null,
	optbox:null,
	data:null,
	busy:false,
	page:1,
	sort:"r.date_added",
	order:"DESC",
	limit:"5",
	start:"0",
	
	init:function(options){
		
		this._options=options;
		this._box=$(options.box);
		//this.optbox=box.find('#mr_options');
		
		this.initData();
		this.initPagination(false);
		this.initSorting();
		this.initListeners();
		this.initGalleries();
		this.initUpload();
	},
	supportUpload:function(){
		
	  return supportFileAPI() && supportAjaxUploadProgressEvents() && supportFormData();
	
	  // Is the File API supported?
	  function supportFileAPI() {
	    var fi = document.createElement('INPUT');
	    fi.type = 'file';
	    return 'files' in fi;
	  };
	
	  // Are progress events supported?
	  function supportAjaxUploadProgressEvents() {
	    var xhr = new XMLHttpRequest();
	    return !! (xhr && ('upload' in xhr) && ('onprogress' in xhr.upload));
	  };
	
	  // Is FormData supported?
	  function supportFormData() { 
	    return !! window.FormData;
	  }
	},
	initSorting:function(){
		var self=this;
		$('.mr-sort').filter(function(){ return $(this).attr('sort')===self.sort+"|"+self.order;}).addClass('mr-sort-active');
		
		$('.mr-sort').click(function(e) {
			e.preventDefault();
			var vals=$(this).attr('sort').split('|');
	        self.page=1;
	        self.sort=vals[0];
	        self.order=vals[1];
	        self.loadReviews();
	        $('.mr-sort').removeClass('mr-sort-active');
	        $('.mr-sort').filter(function(){ return $(this).attr('sort')===self.sort+"|"+self.order;}).addClass('mr-sort-active');
		
	    });
	},
	initPagination:function(reload){
		var pages=parseInt(this._options.pages),visible=5,html='',self=this,page=self.page,start,finish;
		if(pages<2)return false;
		if(pages<visible) visible=pages;
		if(page!=1)html+='<a href="#" class="mr-page-left"></a>';
		html+='<a href="#" class="mr-page">1</a>';
		if(page-3>1){
			html+=' ... ';
		}
		start=page-2>1 ? page-2 : 2;
		finish=page+2<pages ? page+2 : pages-1;
		
		if(page-start<2 && finish+2-page+start<pages) finish+=2-page+start;
		if(finish-page<2 && start-2+page-finish>1) start-=2+page-finish;
		
		for(i=start;i<=finish;i++){
			html+='<a href="#" class="mr-page">'+i+'</a>';
		}
		if(page+3<pages){
			html+=' ... ';
		}
		html+='<a href="#" class="mr-page">'+pages+'</a>';
		if(page!=pages)html+='<a href="#" class="mr-page-right"></a>';
		
		$('#mr-pagination').html(html);
		$('.mr-page').filter(function(){ return $(this).text()===page+"";}).addClass('mr-page-active');
		$('.mr-page').click(function(e) {
			e.preventDefault();
	        self.page=parseInt($(this).text());
	        self.initPagination(true);
	    });
	    $('.mr-page-left').click(function(e) {e.preventDefault();self.page-=1;self.initPagination(true);});
	    $('.mr-page-right').click(function(e) {e.preventDefault();self.page+=1;self.initPagination(true);});
	    if(reload){
	    	self.loadReviews();
	    }
	},
	loadReviews:function(){
		var data={'sort':this.sort,'order':this.order,'start':((this.page-1)*this._options.perpage),'limit':this._options.perpage,'product_id':this._options.product_id};
		var loader='<div class="mr-progressbar" ><img src="'+$('#path').val()+'/image/mr/loader.gif"></div>';
		$('#mr-list').append("<div style='position:absolute;top:0;left:0;width:100%;height:100%;opacity:0.5;background:white;'>"+loader+"</div>");
		
		$.post( self._options.loadLink,data, function( data ) {				
				$('html,body').animate({scrollTop:$('#mr-list').offset().top},500);
				//$.scrollTo({ top: $('#mr-list').offset().top }, 500);
				$('#mr-list').html(data);	
				self.initGalleries();						 	
			});
	},
	initListeners:function(){
		self=this;
		$('#addreviewform').submit(function(event) {
	    	var loader='<div class="mr-progressbar" ><img src="'+$('#path').val()+'/image/mr/loader.gif"></div>';
		$('#mr_new').append("<div style='position:absolute;top:0;left:0;width:100%;height:100%;opacity:0.5;background:white;'>"+loader+"</div>");
		
	    	$.post( self._options.validateLink,$('#addreviewform').serializeArray(), function( data ) {
				//alert(data);
				self.validate(JSON.parse(data));
			 	
			});
	    	return false;
	    });
	    
	    if(self._options.counter){
	    	
	    	//var ta_plus=$('#addreviewform').find('textarea[name="text_plus"]');
	    	//var ta_minus=$('#addreviewform').find('textarea[name="text_minus"]');
	    	//var ta=$('#addreviewform').find('textarea[name="text"]');
	    	//var message_plus=ta_plus.parent().find('p').text();
	    	//var message_minus=ta_minus.parent().find('p').text();
	    	var ta=$('#addreviewform').find('textarea');
	    	var message=ta.parent().find('p').text();
	    	
	    	ta.bind('input propertychange', function() {
	    		
	    		//var left=self._options.textcount-ta.val().length;
	    		var left=self._options.textcount-$(this).val().length;
	    		
	    		if(left==self._options.textcount) $(this).parent().find('p').html(message); else
	    		if(left<1) $(this).parent().find('p').html('<img src="'+$('#path').val()+'/image/mr/check.png" width="12">'+self.text_minreached); else
	    		$(this).parent().find('p').html(self.text_minreqleft+left); 	 
			
	    	});
	    }
	    $('.mr-addbutton').on('click',function() {
	    	$('#mr_new').css('height','auto');
	    	$('html,body').animate({scrollTop:$('#mr_new').offset().top},500);
	    });
	    $('#mr-list').on('click','.mr-list-vote a',function() {
	    	
        	var id=$(this).parent().attr('for'),vote,item=$(this);
        	if($(this).hasClass('mr-upvote')) vote=1;else vote=0;
        	$.post( self._options.voteLink,{id:id,vote:vote}, function( data ) {
				
				var obj=JSON.parse(data);
				
				if(obj.status=='1'){
					item.find('span').text(parseInt(item.find('span').text())+1);
					 item.parent().find('a').addClass('mr-vote-disabled');
					item.removeClass('mr-vote-disabled').addClass('mr-vote-active');
				}else if(obj.status=='0'){
					item.parent().find('a').removeClass('mr-vote-disabled').removeClass('mr-vote-active');
					item.find('span').text(parseInt(item.find('span').text())-1);
				}
			 	
			});
    	});
    	

	},
	initGalleries:function(){
		$('.popup-gallery').each(function() { // the containers for all your galleries
    	
	    	$(this).magnificPopup({
			  delegate: 'a',
	          tLoading: 'Loading image #%curr%...',
	          gallery: {
	            enabled: true,
	            navigateByImgClick: true,
	            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
	          },
	          image: {
	            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
	            titleSrc: function(item) {
	            	if(item.el.attr('title')=='')return '';
	              return item.el.attr('title');
	            }
	          },
	          iframe: {
	     		markup: '<div class="mfp-iframe-scaler">'+
	                '<div class="mfp-close"></div>'+
	                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
	                '<div class="mfp-title" style="position:absolute;">Some caption</div>'+
	              '</div>'
			  },
			  callbacks: {
			    markupParse: function(template, values, item) {
			     values.title = item.el.attr('title');
			    },
			    open: function() {
			     $(".mfp-container").touchwipe({
				     wipeLeft: function() { $(".mfp-container").find('.mfp-arrow-right').trigger('click'); },
				     wipeRight: function() { $(".mfp-container").find('.mfp-arrow-left').trigger('click'); },
				     
				     min_move_x: 50,
				     min_move_y: 50,
				     preventDefaultEvents: true
				});
			    }
			  }
	      });
	   });
	   
	},
	initRating:function(){
		var self=this,def="",selection;
		$('#rating').parent().append('<input type="hidden" name="rating" value="-1"/>');
		    
		$('#rating').ratings(5).bind('starover', function(event, data) {
			selection=$(this).parent().parent().find('#opt-selection');
		    selection.text(self.data.rating.split(',')[data.rating-1]);
		  }).bind('ratingchanged', function(event, data) {
		  	$('#rating').parent().find("input").val(data.rating);
		    def=self.data.rating.split(',')[data.rating-1];
		  }).mouseleave(function() {
		  	selection=$(this).parent().parent().find('#opt-selection');
			selection.text(def);
		});
	},
	
	initData:function(){
		var self=this;
		
		$.post( this._options.optionsLink, function( data ) {
			
		 	self.data=JSON.parse(data); 
		 	self.initOptions();
			self.initRating();
		});
	},
	
	initOptions:function(){
		
		var self=this,obj=self.data;
				
		
		$.each(obj.options, function(i, option) {
		    var row,optid,values,ind;
		    optid=option.option_id;
		    row=self._box.find('.mr-row[opt-id="'+optid+'"]');
		    values=option.values.split(',');
		    ind=values.length;
		    row.find('.optslider').parent().append('<input type="hidden" name="options['+optid+']" value="-1"/>');
		    
		    row.find('.optslider').slider({
		      value:(ind-1)/2,
		      min: 0,
		      max: ind-1,
		      step: 1,
		      slide: function( event, ui ) {
		      	row.find("input").val(ui.value);
		        row.find("#opt-selection").text(values[ui.value])
		      }
		    });
		});	
	},
	
	initUpload: function(){
		var self=this,abc=0,lasttype;
		 if(!this.supportUpload()) $('.mr-cell #file').parent().html("Please, update your browser to the latest version to be able to upload photos");
		
		//following function will executes on change event of file input to select different file	
		$('body').on('change', '#file', function(){
		            if (this.files && this.files[0]) {
		            	
		            	var fsize = this.files[0].size;
        				var ftype = this.files[0].type;
        				if(ftype==''){
        					ext=this.files[0].name.split('.');
        					if(ext[ext.length-1]=='jpg')ftype='image/jpeg'; else
        						ftype='image/'+ext[ext.length-1];
        				}
        				this.files[0].type=ftype; 
        				lasttype=ftype;
        				switch(ftype)
					        {
					            case 'image/png':
					            case 'image/gif':
					            case 'image/jpeg':
					            case 'image/pjpeg':
					                
					                break;
					            default:
					                $(this).parent().parent().append("<span class='mr-file-error'>This file format is not supported!</span>").find('span').delay(4000).fadeOut(500,function(){$(this).remove();});return 0;break;
					        }
					     if(fsize/1000>self._options.maxsize){
					        $(this).parent().append("<span class='mr-file-error'>File is too big!</span>").find('span').delay(4000).fadeOut(500,function(){$(this).remove();});return 0;}
		                 abc = $(this).parent().parent().find('#filediv').length; //increementing global variable by 1
						if(abc>self._options.maxnumber){
					 		$(this).parent().parent().append("<span class='mr-file-error'>Too many pictures!</span>").find('span').delay(4000).fadeOut(500,function(){$(this).remove();});return 0;
					 		return 0;
					 	}
						$(this).parent().parent().prepend('<div id="filediv" class="filemain"><input name="file[]" type="file" id="file"/><label for="file" class="filebtn">UPLOAD ONE MORE FILE</label><br/></div>');
						var z = abc - 1;
		                var x = $(this).parent().find('#previewimg' + z).remove();
		                $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src='"+$('#path').val()+"/image/mr/loader.gif'/></div>");
		               
					    var reader = new FileReader();
		                reader.onload = imageIsLoaded;
		                reader.readAsDataURL(this.files[0]);
		               
					    $(this).parent().find('label').remove();
					    $(this).parent().removeClass("filemain");
		                $("#abcd"+ abc).append($("<img/>", {id: 'img', src: $('#path').val()+'/image/mr/x.png', alt: 'delete'}).click(function() {
		                $(this).parent().parent().remove();
		                abc=abc-1;
		                 
		                }));
		                
		            }
		        });
		
		//To preview image     
		    function imageIsLoaded(e) {
		       
		        var img = new Image;
		            img.onload = function() {
		            	
		              if(img.width<self._options.minwidth || img.height<self._options.minwidth){
				     		$('#previewimg' + abc).parent().parent().append("<span class='mr-file-error'>Make sure that width and height are bigger then"+self._options.minwidth+"px!</span>").find('span').delay(4000).fadeOut(500,function(){$(this).parent().remove();});
				    		$('#previewimg' + abc).parent().remove();
				    		abc -= 1;
				    	}else{
				    		 $('#previewimg' + abc).attr('src', img,src);
				    	}
		            };
		            img.src = e.target.result.replace('base64',lasttype+';base64');
		            $('#previewimg' + abc).attr('src', e.target.result.replace('base64',lasttype+';base64'));
		        	
		        
		    };

    
	},
	
	validate:function (data){
	
	if(data.status=='0'){
		var progressbar = $( ".mr-progressbar" ).parent();
  		progressbar.remove();
		$('.mr-error-wrapper').html('');
		$('.mr-message-wrapper').html('');
		$.each(data.error, function(i, t) {
			var div=$('<div/>',{class:'mr-error'}).text(t).appendTo('.mr-error-wrapper[for="'+i+'"]'); 
			
		});
		$('html,body').animate({scrollTop:$('.mr-message-wrapper').offset().top},500);
	
		var div=$('<div/>',{class:'mr-main-error'}).html('<img src="'+$('#path').val()+'/image/mr/x.png" width="30"> '+data.message).appendTo('.mr-message-wrapper');
	}else{
		$('.mr-message-wrapper').html('');
		var form = document.getElementById('addreviewform');
		var formData = new FormData(form);
		
		//console.log(form.serializeArray());
    	var action = $('#addreviewform').attr('action');
    	
		var div=$('<div/>',{class:'mr-success'}).html('<img src="'+$('#path').val()+'/image/mr/check.png" width="30"> '+data.message).appendTo('.mr-message-wrapper').hide(); 
		
	     	    
		this.sendXHRequest(formData, action);
	}
		
},
	
	sendXHRequest:function(formData, uri){
		
		  var xhr = new XMLHttpRequest(), self=this;
		
		  xhr.addEventListener('readystatechange', onreadystatechangeHandler, false);
			
		  // Set up request
		  xhr.open('POST', uri, true);
			console.log(formData);
		  // Fire!
		  xhr.send(formData);
		
		// Handle the response from the server
		function onreadystatechangeHandler(evt) {
		  var status, text, readyState;
		
		  try {
		    readyState = evt.target.readyState;
		    text = evt.target.responseText;
		    status = evt.target.status;
		  }
		  catch(e) {
		    return;
		  }
		
		  if (readyState == 4) {
		  	$('html,body').animate({scrollTop:$('.mr-message-wrapper').offset().top},500);
			
		    var progressbar = $( ".mr-progressbar" ).parent();
		  	progressbar.remove();
		  	if(self._options.publish==0)self.loadReviews();
		  	if(status=='200')formSuccess();
		  	
		  }
		}
	}
}






function formSuccess(){
	$('.mr-success').show();
	$('#addreviewform').animate({'height':'0','opacity':'0'},500,function(){$(this).remove()});
}

var abc = 0; //Declaring and defining global increement variable
function getFormData(form){
	var obj=form.serializeArray(),result=new Array();
	result['options']=new Array();
	result['ays']=new Array();
	$.each(obj, function(i, p) {
		var reg=/(.*)\[(.*)\]/g,found = reg.exec( p.name ); 
		if(found)
			result[found[1]][found[2]]=p.value; else
		result[p.name]=p.value;
	});
	
	return result;
}

$(document).ready(function() {
	
   
});



//Star rating

jQuery.fn.ratings = function(stars, initialRating) {

  //Save  the jQuery object for later use.
  var elements = this;
  
  //Go through each object in the selector and create a ratings control.
  return this.each(function() {
  
    //Make sure intialRating is set.
    if(!initialRating)
      initialRating = 0;
      
    //Save the current element for later use.
    var containerElement = this;
    
    //grab the jQuery object for the current container div
    var container = jQuery(this);
    
    //Create an array of stars so they can be referenced again.
    var starsCollection = Array();
    
    //Save the initial rating.
    containerElement.rating = initialRating;
    
    //Set the container div's overflow to auto.  This ensure it will grow to
    //hold all of its children.
    container.css('overflow', 'auto');
    
    //create each star
    for(var starIdx = 0; starIdx < stars; starIdx++) {
      
      //Create a div to hold the star.
      var starElement = document.createElement('div');
      
      //Get a jQuery object for this star.
      var star = jQuery(starElement);
      
      //Store the rating that represents this star.
      starElement.rating = starIdx + 1;
      
      //Add the style.
      star.addClass('jquery-ratings-star');
      
      //Add the full css class if the star is beneath the initial rating.
      if(starIdx < initialRating) {
        star.addClass('jquery-ratings-full');
      }
      
      //add the star to the container
      container.append(star);
      starsCollection.push(star);
      
      //hook up the click event
      star.click(function() {
        //When clicked, fire the 'ratingchanged' event handler.  Pass the rating through as the data argument.
        elements.triggerHandler("ratingchanged", {rating: this.rating});
        containerElement.rating = this.rating;
      });
      
      star.mouseenter(function() {
        //Highlight selected stars.
        elements.triggerHandler("starover", {rating: this.rating});
        for(var index = 0; index < this.rating; index++) {
          starsCollection[index].addClass('jquery-ratings-full');
        }
        //Unhighlight unselected stars.
        for(var index = this.rating; index < stars; index++) {
          starsCollection[index].removeClass('jquery-ratings-full');
        }
      });
      
      container.mouseleave(function() {
        //Highlight selected stars.
        for(var index = 0; index < containerElement.rating; index++) {
          starsCollection[index].addClass('jquery-ratings-full');
        }
        //Unhighlight unselected stars.
        for(var index = containerElement.rating; index < stars ; index++) {
          starsCollection[index].removeClass('jquery-ratings-full');
        }
      });
    }
  });
};