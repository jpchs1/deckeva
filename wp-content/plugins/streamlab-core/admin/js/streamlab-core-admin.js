(function( $ ) {
	'use strict';
	
	 window.checked = [];
	 window.response = [];
	 Array.prototype.remove = function() {
	    var what, a = arguments, L = a.length, ax;
	    while (L && this.length) {
	        what = a[--L];
	        while ((ax = this.indexOf(what)) !== -1) {
	            this.splice(ax, 1);
	        }
	    }
	    return this;
	};
	 var youtube = function()
	 {
	 	jQuery('.search-youtube').on('click',function(){
	 		
	 		if(!streamlab_obj.youtube_api_key)
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Api key Is Required</p></div>');
        return;
      }
      var video_name = jQuery('[name="video_name"]').val();
      if(!video_name)
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Video Search Keyword Is Required</p></div>');
        return;
      }
      else
      {
        jQuery('.gen-import-notice').html('');
      }
      console.log(streamlab_obj.youtube);
	 		var ele = jQuery(this);
             jQuery.ajax({
              url: streamlab_obj.youtube+video_name,
              type: 'GET',
              crossDomain: true,
              dataType: 'jsonp',
              data: {},
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
              	var res = data.items;
              	response = data.items;
                console.log(data);
                if (data) {
                	var table = '';
                	table += `<thead>
                			<th><input type="checkbox" class="gen-check-all"></th>
                			<th>Image</th>
                			<th>Title</th>
                			<th>Channel</th>
                      <th>Release Date</th>
                		</thead>`;
                	
                	res.forEach(function(arr,index){
                		table += `<tr>
                		<td><input class="gen-checkbox" type="checkbox"  data-key="`+index+`"></td>
                		<td><img src="`+arr.snippet.thumbnails.default.url+`"/></td>
                		<td>`+arr.snippet.title+`</td>
                		<td>`+arr.snippet.channelTitle+`</td>
                    <td>`+arr.snippet.publishedAt+`</td>
                		</tr>
                		`;
                		
                	});
                	jQuery('.youtube-videos').html(table);
                	
                  
                } else {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Somthing Went Wrong</p></div>');
                }
                jQuery('.gen-loading-icon').hide();
                
              }
            });
	 	});
	 },
	 vimoe_search = function (){
	 	jQuery('.search-vimoe').on('click',function(){
	 		
	 		if(!streamlab_obj.vimoe_api_key)
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Api key Is Required</p></div>');
        return;
      }
      var video_name = jQuery('[name="video_name"]').val();
      if(!video_name)
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Video Search Keyword Is Required</p></div>');
        return;
      }
      else
      {
        jQuery('.gen-import-notice').html('');
      }
     
	 		var ele = jQuery(this);
             jQuery.ajax({
              url: streamlab_obj.vimeo+video_name,
              type: 'GET',
              crossDomain: true,
              dataType: 'json',
               headers: {
                        "Authorization": 'Bearer '+streamlab_obj.vimoe_api_key 
                    },
              data: {},
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
              	response = data.data;
              	
              	var res = data.data;

              	console.log(data);
              
                if (data) {
                	var table = '';
                	table += `<thead>
                			<th><input type="checkbox" class="gen-check-all"></th>
                			<th>Image</th>
                			<th>Title</th>
                      <th>Release Date</th>
                		</thead>`;
                	
                	res.forEach(function(arr,index){
                		table += `<tr>
                		<td><input class="gen-checkbox" type="checkbox"  data-key="`+index+`"></td>
                		<td><img src="`+arr.pictures.sizes[1].link+`"/></td>
                		<td>`+arr.name+`</td>
                    <td>`+arr.release_time+`</td>
                		
                		</tr>
                		`;
                		
                	});
                	jQuery('.vimoe-videos').html(table);
                	
                  
                } else {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Somthing Went Wrong</p></div>');
                }
                jQuery('.gen-loading-icon').hide();
                
              }
            });
	 	});
	 },
	 youtube_check_data = function()
	 {
	 	jQuery(document).on('change' , '.gen-checkbox' , function(){
	 	     
	 		if (jQuery(this).prop('checked')) {
			 	checked.push(jQuery(this).data('key'));
			 }
			 else
			 {
			 	checked.remove(jQuery(this).data('key'));
			 }
           
	 	});
	 	jQuery(document).on('change' , '.gen-check-all' , function(){
	 		jQuery('input:checkbox').not(this).prop('checked', this.checked);
	 		jQuery('.gen-checkbox').each(function(){
	 			if (jQuery(this).prop('checked')) {
			 	checked.push(jQuery(this).data('key'));
			 }
			 else
			 {
			 	checked.remove(jQuery(this).data('key'));
			 }
	 		});
	 	});
	 	
	 },
	 import_youtube_data = function (){
	 	 
	 	jQuery('.youtube-import').on('click' ,function(){
	 		var ele = jQuery(this);
	 		 var temp = [] ;
	 	   var obj = response;
        if(response.length == 0)
       {
        jQuery('.gen-import-notice').show();
          jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>No Data To Import</p></div>');
            return;
       }

       if(checked.length > 0)
       {
          checked.forEach(function(cur_val, index, arr){
                temp.push(obj[parseInt(cur_val)]);
            });
       }
       else
       {
          jQuery('.gen-import-notice').show();
          jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Select At least One Video</p></div>');
          return;
       }
            
            obj = temp;
            console.log(obj);
	 		var data = {
            'action': 'import_data_from_youtube',
            'response': obj,
            
          };
	 		 jQuery.ajax({
              url: streamlab_obj.ajaxurl,
              type: 'POST',
              data: data,
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
              	data = JSON.parse(data);
                if (data.code == 200) {
                  jQuery('.gen-import-notice').show();
                	jQuery('.gen-import-notice').html('<div class="notice notice-success"><p>'+data.messagge+'</p></div>');
                	location.reload()
                  
                } else {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>'+data.messagge+'</p></div>');
                }
               jQuery('.gen-loading-icon').hide();
              }
            });
	 	});
	 },

   import_vimeo_data = function (){
     
    jQuery('.vimoe-import').on('click' ,function(){
      var ele = jQuery(this);
       var temp = [] ;
       var obj = response;
        if(response.length == 0)
       {
          jQuery('.gen-import-notice').show();
          jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>No Data To Import</p></div>');
            return;
       }

             if(checked.length > 0)
             {
                checked.forEach(function(cur_val, index, arr){
                      temp.push(obj[parseInt(cur_val)]);
                  });
             }
             else
             {
              jQuery('.gen-import-notice').show();
                jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Select At least One Video</p></div>');
                return;
             }
            obj = temp;
            console.log(obj);
      var data = {
            'action': 'import_data_from_vimeo',
            'response': obj,
            
          };

       jQuery.ajax({
              url: streamlab_obj.ajaxurl,
              type: 'POST',
              data: data,
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
                data = JSON.parse(data);
                if (data.code == 200) {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-success"><p>'+data.messagge+'</p></div>');
                  location.reload()
                  
                } else {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>'+data.messagge+'</p></div>');
                }
               jQuery('.gen-loading-icon').hide();
              }
            });
    });
   }
   ,
	 save_api_key = function()
	 {
	 	jQuery('.gen-save-api-key').on('click' ,function(e){
	 		
	 		var ele = jQuery(this);
	 		e.preventDefault();
	 		var type = jQuery('[name="api_key"]').data('type');
	 		var data = {
            'action': 'save_api_key',
            'api_key': jQuery('[name="api_key"]').val(),
            'type': type,
          };
	 		      jQuery.ajax({
              url: streamlab_obj.ajaxurl,
              type: 'POST',
              data: data,
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
                data = JSON.parse(data);
                if (data.code == 200) {
                  jQuery('.gen-import-notice').show();
                	jQuery('.gen-import-notice').html('<div class="notice notice-success"><p>'+data.messagge+'</p></div>');
                  location.reload()
                  
                } else {
                  
                }
                jQuery('.gen-loading-icon').hide();
              }
            });
	 	});
	 }
	 ;
	 jQuery(document).ready(function () {
	 	jQuery('.gen-loading-icon').hide();
	 	youtube();
	 	youtube_check_data();
	 	import_youtube_data();
	 	save_api_key();
	 	vimoe_search();
    import_vimeo_data();

    jQuery('.gen-tab-wrapper nav a').on('click' , function(e){
      e.preventDefault();
        jQuery('.gen-tab-wrapper nav a').removeClass('nav-tab-active');
        jQuery(this).addClass('nav-tab-active');

        var href = jQuery(this).attr('href');

       
        jQuery('.tab-content').removeClass('active');

        jQuery(href).addClass('active');
    });

    jQuery('.gen-movie-type-select').on('click' , function(e){
      var val = jQuery('.gen-movie-type-select').val();
      if(val == 'imdbid')
      {
        jQuery('[name="gen-movie-id-title"]').attr('placeholder' , 'IMDb ID (e.g. tt1285016)')
      }
      else if(val == 'title')
      {
        jQuery('[name="gen-movie-id-title"]').attr('placeholder' , 'Movie title to search for (e.g. The Godfather)')
      }
      else
      {
        jQuery('[name="gen-movie-id-title"]').attr('placeholder' , val) 
      }
    });

    jQuery('.gen-movie-id-title-btn').on('click' , function(){

        if(!streamlab_obj.omdb_api_key)
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Api key Is Required</p></div>');
        return;
      }
     
      else
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('');
      }

      var id_title = jQuery('.gen-movie-type-select').val();
      var query_string = jQuery('[name="gen-movie-id-title"]').val();
      var query = '';

      if(id_title === 'Select Search Preference')
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Select Your Search Preference</p></div>');
        return;
      }
      if(query_string.length ==0)
      {
        jQuery('.gen-import-notice').show();
        jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Enter Your Related Search Preference</p></div>');
        return; 
      }
      if(id_title == 'imdbid')
      {
        query += 'i='+query_string;
      }
      else if(id_title == 'title')
      {
        query += 't='+query_string;
      }
      else if(id_title == 'keyword')
      {
        query += 's='+query_string;
      }



      
      
      var ele = jQuery(this);
             jQuery.ajax({
              url: streamlab_obj.omdb+query,
              type: 'GET',
              crossDomain: true,
              dataType: 'json',
              data: {},
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
              if(data.Response === 'True')
              {
                  if(id_title == 'keyword')
                  {

                    response = data.Search;
                    var res;
                    res = data.Search;
                    var table = '';
                    table += `<thead>
                        <th><input type="checkbox" class="gen-check-all"></th>
                        <th>Image</th>
                        <th>Title</th>
                        
                      </thead>`;
                    
                    res.forEach(function(arr,index){
                           table += `<tr>
                      <td><input class="gen-checkbox" type="checkbox"  data-key="`+index+`"></td>
                      <td><img src="`+arr.Poster+`"/></td>
                      <td>`+arr.Title+`</td>
                     
                      
                      </tr>
                      `;
                    });  

                    jQuery('.omdb-videos').html(table);

                  }
                    else
                    {


                      response = data;
                    
                      var table = '';
                      table += `<thead>
                          <th>
                          <th>Image</th>
                          <th>Title</th>
                          <th>Genre</th>
                          <th>Released</th>
                        </thead>`;
                      
                     
                        table += `<tr>
                        <td></td>
                        <td><img src="`+data.Poster+`"/></td>
                        <td>`+data.Title+`</td>
                        <td>`+data.Genre+`</td>
                        <td>`+data.Released+`</td>
                        
                        </tr>
                        `;
                        
                      
                      jQuery('.omdb-videos').html(table);
                      
                      
                    

                  }
              }
              else {
                jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Somthing Went Wrong</p></div>');
                }
                
               
                jQuery('.gen-loading-icon').hide();
                
              }
            });

    });

    jQuery('.gen-movie-id-title-import-btn').on('click' , function(){
       var ele = jQuery(this);
       var temp = [] ;
       var obj = response;
       var id_title = jQuery('.gen-movie-type-select').val();
       var action = 'import_movie_from_omdb';

       if(response.length == 0)
       {
        jQuery('.gen-import-notice').show();
          jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>No Data To Import</p></div>');
            return;
       }

       if(id_title == 'keyword')
       {
          if(checked.length == 0)
          {
            jQuery('.gen-import-notice').show();
            jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>Select Atleast One Video</p></div>');
            return;
          }
          checked.forEach(function(cur_val, index, arr){
            temp.push(obj[parseInt(cur_val)]);
          }); 
         obj = temp;
         action = 'import_search_omdb_data';
       }
       
            
      var data = {
            'action': action,
            'response': obj
          };

       jQuery.ajax({
              url: streamlab_obj.ajaxurl,
              type: 'POST',
              data: data,
              beforeSend: function beforeSend() {
               ele.find('.gen-loading-icon').show();
              },
              success: function success(data , index) {
                data = JSON.parse(data);
                
                if (data.code == 200) {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-success"><p>'+data.messagge+'</p></div>');
                  location.reload()
                  
                } else {
                  jQuery('.gen-import-notice').show();
                  jQuery('.gen-import-notice').html('<div class="notice notice-error"><p>'+data.messagge+'</p></div>');
                }
               jQuery('.gen-loading-icon').hide();
              }
            });
    });
	 	
	 });
})( jQuery );
