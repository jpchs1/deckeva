/*
 +=====================================================================+
 |     _   _ _        _       ____                                     |
 |    | \ | (_)_ __  (_) __ _/ ___|  ___ __ _ _ __  _ __   ___ _ __    |
 |    |  \| | | '_ \ | |/ _` \___ \ / __/ _` | '_ \| '_ \ / _ \ '__|   |
 |    | |\  | | | | || | (_| |___) | (_| (_| | | | | | | |  __/ |      |
 |    |_| \_|_|_| |_|/ |\__,_|____/ \___\__,_|_| |_|_| |_|\___|_|      |
 |                 |__/                                                |
 |                                                                     |
 | (c) NinTechNet ~ https://nintechnet.com/                            |
 +=====================================================================+
*/

var nscan_interval = 0;
var nscan_error = 0;
var nscan_init = 0;
if (typeof nscani18n === 'undefined') {
	var nscani18n = '{""}';
}
var nscan_all_cleared = '<tr style="background-color:#F9F9F9;height:30px">' +
	'<td class="ns-icon">' +
	'<span class="dashicons dashicons-marker ns-ok-file-icon"></span>' +
	'</td>' +
	'<td class="ns-file-centered">'+ nscani18n.no_problem +'</td>' +
	'</tr>';
// =====================================================================
// Start a scan.

function nscanjs_start_scan( nscan_key, nscan_milliseconds = 1500, first_run = 0 ) {

	// Change buttons status
	jQuery('#start-scan').prop('disabled', true);
	// Hide report
	jQuery('#nscan-report-div').fadeOut();
	// Hide Summary div
	jQuery('#last-scan-div').slideUp();
	// Show progress bar
	jQuery('#scan-progress-div').slideDown();
	// Hide potential messages
	jQuery('#summary-message').slideUp();
	// Show running notice
	jQuery('#summary-running').slideDown();

	var data = {
		'action': 'nscan_startscan',
		'nscan_key': nscan_key,
		'first_run': first_run,
	};
	// Test if eveything is working
	jQuery.ajax( {
		type: "POST",
		url: ajaxurl,
		data: data,
		dataType: 'json',
		success: function( response ) {
			if (typeof response === 'undefined') {
				nscanjs_cancel_scan( nscan_key, 0, 'nscan_startscan: response == undefined' );
				alert( nscani18n.unknown_error );
				return;
			}
			if ( response.status != 'success' ) {
				nscanjs_cancel_scan( nscan_key, 0, 'nscan_startscan: response != success' );
				alert( nscani18n.error +' '+ response.message );
				jQuery('#summary-message').html( '<p>'+ response.message +'</p>' );
				jQuery('#summary-message').slideDown();
				return;
			}
			// Show the cancel button here only, when we are back from
			// the blocking socket and its 4-second pause
			jQuery('#cancel-scan').prop('disabled', false);
			jQuery('#scan-progress-text').html( nscani18n.initialising );
			// It's all good, check the status
			nscan_interval = setInterval( nscanjs_is_running.bind( null, nscan_key ), nscan_milliseconds );
		},
		// Display non-200 HTTP response
		error: function( xhr, status, err ) {
			// Make sure there was really an error, otherwise we would cancel
			// the running scan if the user moved away from the current page
			if ( err != '' ) {
				// Try to cancel it anyway
				nscanjs_cancel_scan( nscan_key, 0, 'nscan_startscan: response == err' );
				// If the site or wp-admin is password-protected, we inform the user
				// that they can enter their username/password in the settings page:
				if ( xhr.status == 401 ) {
					jQuery('#summary-message').html( '<p>'+ nscani18n.http_error +' '+ xhr.status +' '+ err +'.<br />'+ nscani18n.http_auth +'</p>' );
					jQuery('#summary-message').slideDown();
				// HTTP error
				} else if ( xhr.status != 0 ) {
					jQuery('#summary-message').html( '<p>'+ nscani18n.http_error +' '+ xhr.status +' '+ err +'.</p>' );
					jQuery('#summary-message').slideDown();

				} else {
					// error: timeout etc ?
					jQuery('#summary-message').html( '<p>'+ nscani18n.unknown_error +' '+ err +'.</p>' );
					jQuery('#summary-message').slideDown();
				}
			}
			return;
		}
	});
}

// =====================================================================
// Check and return the scanner's status

function nscanjs_is_running( nscan_key ) {

	var data = {
		'action': 'nscan_check_status',
		'nscan_key': nscan_key,
	};
	jQuery.ajax( {
		type: "POST",
		url: ajaxurl,
		data: data,
		dataType: 'json',
		success: function( response ) {
			if (typeof response === 'undefined') {
				nscanjs_cancel_scan( nscan_key, 0, 'nscan_check_status: response == undefined' );
				alert( nscani18n.unknown_error );
				return;
			}

			// Scanning process has stopped
			if ( response.status == 'stopped' ) {
				if ( nscan_interval != 0 ) {
					clearInterval( nscan_interval );
				}
				// Reload interface and display report
				var string = window.location.href;
				if ( string.indexOf( '&view-report=1' ) !== -1 ) {
					// Remove the "section=x" so that we load the first page of the report:
					window.history.replaceState({}, document.title, window.location.href.replace( /&section=\d+/, '&section=1' ) );
					window.location.href = window.location.href;
				} else {
					window.location.href = window.location.href + '&view-report=1';
				}
				return;
			}
			// Error
			if ( response.status != 'success' ) {

				console.log("NinjaScanner error:\nresponse.status == '"+ response.status +"'\nresponse.message == '"+ response.message +"'\n");

				nscanjs_cancel_scan( nscan_key, 0, 'nscan_check_status: response != success' );
				jQuery('#summary-message').html( '<p>'+ response.message +'</p>' );
				jQuery('#summary-message').slideDown();
				return;
			}

			// We're using a non-blocking socket so we're trying to catch issues
			// during the initialisation of the scan
			if ( response.last == 'init' ) {
				++nscan_init;
				if ( nscan_init > 20 ) {
					nscanjs_cancel_scan( nscan_key, 0, 'nscan_check_status: response == init' );
					jQuery('#summary-message').html( '<p>'+ nscani18n.cannot_start +' '+nscani18n.http_auth +'</p>' );
					jQuery('#summary-message').slideDown();
					nscan_init = 0;
				}
			}

			// Scan is running: display progress bar
			if ( response.current_step > response.total_steps ) {
				// Last step
				response.current_step = response.total_steps;
			}
			var percent = parseInt( response.current_step * (100 / response.total_steps) );
			jQuery('#ns-span-progress').css('width', percent + '%');
			jQuery('#ns-div-progress').html( nscani18n.step + ' ' + response.current_step + '/' + response.total_steps );
			jQuery('#scan-progress-text').text( response.message + '...' );
		},
		// Display non-200 HTTP response
		error: function( xhr, status, err ) {
			// Make sure there was really an error, otherwise we would cancel
			// the running scan if the user moved away from the current page
			if ( err != '' ) {
				// If the site or wp-admin is password-protected, we inform the user
				// that they can enter their username/password in the settings page:
				if ( xhr.status == 401 ) {
					jQuery('#summary-message').html( '<p>'+ nscani18n.http_error +' '+ xhr.status +' '+ err +'.<br />'+ nscani18n.http_auth +'</p>' );
					jQuery('#summary-message').slideDown();
				// HTTP error
				} else if ( xhr.status != 0 ) {
					jQuery('#summary-message').html( '<p>'+ nscani18n.http_error +' '+ xhr.status +' '+ err +'.</p>' );
					jQuery('#summary-message').slideDown();
				} else {
					// error: timeout etc ?
					jQuery('#summary-message').html( '<p>'+ nscani18n.unknown_error +' '+ err +'.</p>' );
					jQuery('#summary-message').slideDown();
				}
				nscanjs_cancel_scan( nscan_key, 0, 'nscan_check_status: response == err' );
			}
			return;
		}
	});
}

// =====================================================================
// Cancel a scan.

function nscanjs_cancel_scan( nscan_key, prompt = false, message = '' ) {

	// Request comes from the dashboard
	if ( prompt == true ) {
		if (! confirm( nscani18n.cancel_scan ) ) {
			return false;
		}
	}

	// Clear timer:
	if ( nscan_interval != 0 ) {
		clearInterval( nscan_interval );
	}

	// Send a cancel request:
	var data = {
		'action': 'nscan_cancel',
		'nscan_key': nscan_key,
		'message': message
	};
	jQuery.ajax( {
		type: "POST",
		url: ajaxurl,
		data: data,
		dataType: 'json',
		success: function( response ) {
			if (typeof response === 'undefined') {
				alert( nscani18n.unknown_error );
			} else {
				if ( response.status != 'success' ) {
					alert( nscani18n.error +' '+ response.message );
				}
			}
			// Show Summary div
			jQuery('#last-scan-div').slideDown();
			// Hide progress bar
			jQuery('#scan-progress-div').slideUp();
			// Hide running notice
			jQuery('#summary-running').slideUp();
			// Change buttons status
			jQuery('#start-scan').prop('disabled', false);
			jQuery('#cancel-scan').prop('disabled', true);
			// Reinitiliaze ribon and message status
			jQuery('#scan-progress-text').text( nscani18n.wait );
			jQuery('#ns-span-progress').css('width', '0%');
			jQuery('#ns-div-progress').html( '' );
		}
	});
}

// =====================================================================
// Scan report functions.

// Roll-up/unroll tables:
function nscanjs_roll_unroll( id ) {

	if ( jQuery('#table-report-' + id).css('display') == 'none' ) {
		jQuery('#table-report-' + id).slideDown();
	} else {
		jQuery('#table-report-' + id).slideUp();
	}
}

// View file info:
function nscanjs_file_info( id, name ) {

	if ( jQuery('#file-info-' + id).css('display') == 'none' ) {
		if ( jQuery('#div-all-rows-'+name).height()  == 72 ) {
			jQuery('#div-all-rows-'+name).animate({'height': '155px'}, 400);
		}
		jQuery('#file-info-' + id).slideDown();
	} else {
		jQuery('#file-info-' + id).slideUp();
		if ( jQuery('#div-all-rows-'+name).height()  == 155 ) {
			jQuery('#div-all-rows-'+name).animate({'height': '72px'}, 400);
		}
	}
}

// View file content:
function nscanjs_file_operation( file, what, nonce, id, table_id, signature, fileinode ) {

	// View/compare file:
	if ( what == 'view' || what == 'compare' ) {

		// Note: "file" is already base64-encoded.
		var url = "?page=NinjaScanner&nscanop="+ what +"&file="+ encodeURIComponent( file )
					+"&nscanop_nonce="+ nonce + "&fileinode="+ fileinode;

		// Highlight signature:
		if ( what == 'view' && typeof signature !== 'undefined' ) {
			url += '&signature=' + encodeURIComponent( signature );
		}
		win =	window.open( url, 'nscanop');

	// Move the file to the quarantine folder:
	} else if ( what == 'quarantine' ) {

		var data = {
			'action': 'nscan_quarantine',
			'nscanop_nonce': nonce,
			'file': file,
			'fileinode': fileinode
		};
		jQuery.post(ajaxurl, data, function(response) {

			response = jQuery.trim( response );
			if ( response == 'success' || response == '404' ) {
				jQuery('#hide-row-' + id).css('background-color', '#F08F8F');
				jQuery('#hide-row-' + id).fadeOut( 400 );
				var total_items = jQuery('#total-items-row-' + table_id).html();
				if ( total_items > 0 ) {
					jQuery('#total-items-row-' + table_id).html( --total_items );
				}
				if ( total_items < 1 ) {
					jQuery('#table-all-rows-' + table_id).hide().html( nscan_all_cleared ).fadeIn('slow');
					jQuery('#div-all-rows-' + table_id).css('height','41px');
					jQuery('#div-all-rows-' + table_id).css('resize','none');
				}

			} else {
				alert( response );
			}

		});

	// Restore the original file (core, plugin or theme):
	} else if ( what == 'restore' ) {

		var data = {
			'action': 'nscan_restore',
			'nscanop_nonce': nonce,
			'file': file
		};
		jQuery.post(ajaxurl, data, function(response) {

			response = jQuery.trim( response );
			if ( response == 'success' ) {
				jQuery('#hide-row-' + id).css('background-color', '#8FF08F');
				jQuery('#hide-row-' + id).fadeOut( 400 );
				var total_items = jQuery('#total-items-row-' + table_id).html();
				if ( total_items > 0 ) {
					jQuery('#total-items-row-' + table_id).html( --total_items );
				}
				if ( total_items < 1 ) {
					jQuery('#table-all-rows-' + table_id).hide().html( nscan_all_cleared ).fadeIn('slow');
					jQuery('#div-all-rows-' + table_id).css('height','41px');
					jQuery('#div-all-rows-' + table_id).css('resize','none');
				}

			} else {
				alert( response );
			}
		});

	// Ignore file:
	} else if ( what == 'ignore' ) {

		var data = {
			'action': 'nscan_ignore',
			'nscanop_nonce': nonce,
			'file': file
		};
		jQuery.post(ajaxurl, data, function(response) {

			response = jQuery.trim( response );
			if ( response == 'success' || response == '404' ) {
				jQuery('#hide-row-' + id).css('background-color', '#8FC9F0');
				jQuery('#hide-row-' + id).fadeOut( 400 );
				var total_items = jQuery('#total-items-row-' + table_id).html();
				if ( total_items > 0 ) {
					jQuery('#total-items-row-' + table_id).html( --total_items );
				}
				if ( total_items < 1 ) {
					jQuery('#table-all-rows-' + table_id).hide().html( nscan_all_cleared ).fadeIn('slow');
					jQuery('#div-all-rows-' + table_id).css('height','41px');
					jQuery('#div-all-rows-' + table_id).css('resize','none');
				}

			} else {
				alert( response );
			}
		});

	} else {
		alert( nscani18n.unknown_action );
	}
}

// View post/pages:
function nscanjs_view_post( post_id, dashboard_url ) {

	var url = dashboard_url + 'post.php?post=' + post_id + '&action=edit';
	win =	window.open( url, 'nscanop' );
}

// =====================================================================
// Settings page JS functions.

function nscanjs_toggle_settings(what) {
	if ( what == 1) {
		jQuery("#nscan-advanced-settings").slideDown();
		jQuery("#nscan-show-advanced-settings").hide();
		jQuery("#nscan-show-nerds-settings").show();
	} else {
		jQuery("#nscan-nerds-settings").slideDown();
		jQuery("#nscan-show-nerds-settings").hide();
	}
}

function nscanjs_slow_scan_enable(what) {
	if ( document.getElementById(what).checked == true ) {
		if ( confirm( nscani18n.slow_down_scan_enable ) ) {
			return true;
		}
		return false;
	}
}

function nscanjs_restore_settings() {
	if ( confirm( nscani18n.restore_settings ) ) {
		return true;
	}
	return false;
}

function nscanjs_clear_cache() {
	if ( confirm( nscani18n.clear_cache_now ) ) {
		return true;
	}
	return false;
}

// Verify the validity of the user's Google API key:
function nscanjs_gsb_check_key( apikey, nonce ) {

	if (! apikey ) {
		alert( nscani18n.empty_apikey );
		jQuery('#nsgsb').focus();
		return false;
	}
	if (! nonce ) {
		return false;
	}

	jQuery('#nsgsb-button').hide();
	jQuery('#nsgsb-gif').show();

	var data = {
		'action': 'nscan_checkapikey',
		'nscanop_nonce': nonce,
		'api_key': apikey
	};
	jQuery.post(ajaxurl, data, function(response) {

		response = jQuery.trim( response );
		if ( response == 'success' ) {
			alert( nscani18n.success_apikey );

		} else {
			alert( response );
			jQuery('#nsgsb').select();
		}

		jQuery('#nsgsb-gif').hide();
		jQuery('#nsgsb-button').show();

	});
	return true;
}

// =====================================================================
// Quarantine page.

function nscanjs_quarantine_form(what) {

	if ( document.getElementById('qf').selectedIndex == -1 ) {
		alert( nscani18n.select_elements );
		return false;
	}

	// Permanently delete files:
	if ( what == 1 ) {
		if ( confirm( nscani18n.permanently_delete ) ) {
			return true;
		}
	// Restore quarantined files:
	} else {
		if ( confirm( nscani18n.restore_file ) ) {
			return true;
		}
	}
	return false;
}

// =====================================================================
// Ignored files list page.

function nscanjs_remove_ignored() {

	if ( document.getElementById('if').selectedIndex == -1 ) {
		alert( nscani18n.select_elements );
		return false;
	}
}

// =====================================================================
// Filter the debugging log.

function nscanjs_filter_log() {

	// Create bitmask:
	var bitmask = 0;
	if ( document.nscanlogform.info.checked == true ) { bitmask += 1; }
	if ( document.nscanlogform.warn.checked == true ) { bitmask += 2; }
	if ( document.nscanlogform.error.checked == true ) { bitmask += 4; }
	if ( document.nscanlogform.debug.checked == true ) { bitmask += 8; }

	// Clear the textarea:
	document.nscanlogform.nscantxtlog.value = '';

	// Browser through our array and return only selected verbosity:
	var nscan_count = 0;
	for ( i = 0; i < nscan_array.length; ++i ) {
		var line = decodeURIComponent( nscan_array[i] );
		var line_array = line.split( '~~', 2 );
		if ( line_array[0] & bitmask ) {
			document.nscanlogform.nscantxtlog.value += line_array[1];
			++nscan_count;
		}
	}
	if ( nscan_count == 0 ) {
		document.nscanlogform.nscantxtlog.value = '\n  > ' + nscani18n.empty_log;
	}
}

// =====================================================================
// Highlight code.

function nscanjs_highlight() {

	var nscan_content = document.getElementById('nscan-highlight').innerHTML;
	nscan_content = nscan_content.replace(/NSCANFOO/g, '<font style="background-color:yellow">');
	nscan_content = nscan_content.replace(/NSCANBAR/g, '</font>');
	document.getElementById('nscan-highlight').innerHTML = nscan_content;

}
// =====================================================================
// EOF
