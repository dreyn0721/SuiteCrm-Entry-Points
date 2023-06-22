






function seconds_to_text( the_sec ) {
    var sec_num = parseInt( the_sec ); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
}




function update_status_timer(  ){
	/*if ( jQuery( document ).find(".custom-ringba-act-container .time-status.unpaused").length > 0 ) {*/


    	seconds = parseInt( jQuery( document ).find(".main-cus.custom-ringba-act-container .time-status").attr('data-seconds') )+1;

    	jQuery( document ).find(".custom-ringba-act-container .time-status").text( seconds_to_text( seconds ) );
    	

    	jQuery( document ).find(".custom-ringba-act-container .time-status").attr('data-seconds', seconds);


	/*} else {
		//jQuery(".custom-ringba-act-container .time-status.paused").attr('data-seconds', "0");
	}*/
}






jQuery( document ).ready( function(){
	var seconds;
	var is_admin = false;
	var is_ringba_exist = false;



	

	if ( jQuery( document ).find(".custom-ringba-act-container .ringba-act-btn").length > 0 ) {

		var user_id = jQuery( document ).find(".main-cus.custom-ringba-act-container .ringba-act-btn").attr('data-current_user_id');




		
	//Api get time status total
	//Update Time status
		jQuery.ajax({
        async: false,
        method: "post",
        url: "https://scrm.coverageoneinsurance.com/index.php?entryPoint=webhook_timeStatus",
        data: {
            id: user_id
        },
        success: function( xhr, status, response ) {

            	jQuery(".custom-ringba-act-container .time-status").attr('data-seconds', parseInt(xhr));
            	jQuery( document ).find(".custom-ringba-act-container .time-status").text( seconds_to_text( parseInt(xhr) ) );

        },
        error: function(xhr, status, response) {
        },
        statusCode: {
            404: function(response) {
            },
            500: function(response) {
            }
        },
        complete: function( response ){
        }
        });














	//Is Pause/Paused
		jQuery.ajax({
        async: false,
        method: "post",
        url: "https://scrm.coverageoneinsurance.com/index.php?entryPoint=webhook_isPaused",
        data: {
            id: user_id
        },
        success: function( xhr, status, response ) {


        	if( xhr == "unpaused" || xhr == "onpaused" ){
        		is_ringba_exist = true;
        	}
            
            if( xhr == "unpaused" ){

            	//Button
				jQuery( ".custom-ringba-act-container .ringba-act-btn" ).text("Ready")
				jQuery( ".custom-ringba-act-container .ringba-act-btn" ).removeClass("onpaused");
				jQuery( ".custom-ringba-act-container .ringba-act-btn" ).addClass("unpaused");


				//Time
				jQuery(".custom-ringba-act-container .time-status").removeClass("onpaused");
				jQuery(".custom-ringba-act-container .time-status").addClass("unpaused");
            } else {

            	//Button
				jQuery( ".custom-ringba-act-container .ringba-act-btn" ).text("Paused")
				jQuery( ".custom-ringba-act-container .ringba-act-btn" ).removeClass("unpaused");
				jQuery( ".custom-ringba-act-container .ringba-act-btn" ).addClass("onpaused");


				//Time
				jQuery(".custom-ringba-act-container .time-status").removeClass("unpaused");
				jQuery(".custom-ringba-act-container .time-status").addClass("onpaused");
            }

        },
        error: function(xhr, status, response) {
        },
        statusCode: {
            404: function(response) {
            },
            500: function(response) {
            }
        },
        complete: function( response ){
        }
        });










	//Is admin
		jQuery.ajax({
        async: false,
        method: "post",
        url: "https://scrm.coverageoneinsurance.com/index.php?entryPoint=webhook_isAdmin",
        data: {
            id: user_id
        },
        success: function( xhr, status, response ) {
            
            if( xhr === "true" ){
                is_admin = true;
            }

        },
        error: function(xhr, status, response) {
        },
        statusCode: {
            404: function(response) {
            },
            500: function(response) {
            }
        },
        complete: function( response ){
        }
        });










	}




	// console.log( "is admin: "+is_admin );

	if( is_admin === false ){
		
		
		if( is_ringba_exist === true ){
			jQuery(".custom-ringba-act-container").show(); //Show only if not admin and ringba exists
		}










		jQuery( document ).on("click", ".ringba-act-btn.onpaused", function(e){
			e.preventDefault();
			var the_btn = jQuery( ".custom-ringba-act-container .ringba-act-btn" );

			//reset timer
			jQuery(".custom-ringba-act-container .time-status").attr('data-seconds', "0");





			//Continue time api
			
			jQuery.ajax({
	        async: false,
	        method: "post",
	        url: "https://scrm.coverageoneinsurance.com/index.php?entryPoint=webhook_onPaused",
	        data: {
	            id: user_id
	        },
	        success: function( xhr, status, response ) {

	        	if( xhr === "success" ){

					//Button
					jQuery( the_btn ).text("Ready")
					jQuery( the_btn ).removeClass("onpaused");
					jQuery( the_btn ).addClass("unpaused");


					//Time
					jQuery(".custom-ringba-act-container .time-status").removeClass("onpaused");
					jQuery(".custom-ringba-act-container .time-status").addClass("unpaused");

	        	} else {
	        		console.log( "On Paused act debug msg: "+xhr );
	        	}

	        },
	        error: function(xhr, status, response) {
	        },
	        statusCode: {
	            404: function(response) {
	            },
	            500: function(response) {
	            }
	        },
	        complete: function( response ){
	        }
	        });
	        

		});












		jQuery( document ).on("click", ".ringba-act-btn.unpaused", function(e){
			e.preventDefault();
			var the_btn = jQuery( ".custom-ringba-act-container .ringba-act-btn" );



			//reset timer
			jQuery(".custom-ringba-act-container .time-status").attr('data-seconds', "0");





			//Pause time api

			jQuery.ajax({
	        async: false,
	        method: "post",
	        url: "https://scrm.coverageoneinsurance.com/index.php?entryPoint=webhook_unPaused",
	        data: {
	            id: user_id
	        },
	        success: function( xhr, status, response ) {
				

				if( xhr === "success" ){

					//Button
					jQuery( the_btn ).text("Paused")
					jQuery( the_btn ).removeClass("unpaused");
					jQuery( the_btn ).addClass("onpaused");


					//Time
					jQuery(".custom-ringba-act-container .time-status").removeClass("unpaused");
					jQuery(".custom-ringba-act-container .time-status").addClass("onpaused");
					
	        	} else {
	        		console.log( "Un Paused act debug msg: "+xhr );
	        	}

				

	        },
	        error: function(xhr, status, response) {
	        },
	        statusCode: {
	            404: function(response) {
	            },
	            500: function(response) {
	            }
	        },
	        complete: function( response ){
	        }
	        });
		});










		//AJAX



		//Update time every second
		setInterval( function() { update_status_timer(  ); }, 1000 );




	}






});