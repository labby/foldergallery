/**
 *  @module         foldergallery
 *  @version        see info.php of this module
 *  @author         Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe
 *  @copyright      2009-2018 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */
 
$(document).ready(function(){ 
	$(function() { 
		$("#dragableTable ul").sortable({ opacity: 0.6, cursor: 'move', update: function() { 
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent_id='+the_parent_id; 
			$.post(LEPTON_URL+"/modules/foldergallery/reorderDND.php", order, function(theResponse){ 
				$("#dragableResult").html(theResponse); 
			}); 
		} 
		}); 
	}); 
 }); 
 
$(document).ready(function(){ 
	$(function() { 
		$("#dragableCategorie ul").sortable({ opacity: 0.6, cursor: 'move', update: function() { 
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent_id='+the_parent_id; 
			$.post(LEPTON_URL+"/modules/foldergallery/reorderCNC.php", order, function(theResponse){ 
				$("#dragableResult").html(theResponse); 
			}); 
		} 
		}); 
	}); 
 });
 
// Remember to invoke within jQuery(window).load(...)
// If you don't, Jcrop may not initialize properly

	var settingsRatio;
	// if(typeof settingsRatio == "undefined") var settingsRatio = "1";
	// console.log("hallo: "+settingsRatio);
	$('#cropbox').Jcrop({
		onChange: showPreview,
		onSelect: updateCoords,
		aspectRatio: settingsRatio // was 16/9 == 1.777777777777
	});

function showPreview(coords)
{
	var imgWidth = $("#cropbox").width();
	var scale = relWidth / imgWidth;
	
	if  (settingsRatio > 1) {
		var rx = thumbSize / coords.w;
		var ry = thumbSize / settingsRatio / coords.h;
	}
	else {
		var rx = thumbSize * settingsRatio / coords.w;
		var ry = thumbSize / coords.h;
	}
	
	$('#preview').css({
		width: Math.round(rx * relWidth / scale) + 'px',
		height: Math.round(ry * relHeight / scale) + 'px',
		marginLeft: '-' + Math.round(rx * coords.x) + 'px',
		marginTop: '-' + Math.round(ry * coords.y) + 'px'
	});

};


function updateCoords(c)
{
	var imgWidth = $("#cropbox").width();
	var scale = relWidth / imgWidth;

	$('#x').val(c.x * scale);
	$('#y').val(c.y * scale);
	$('#w').val(c.w * scale);
	$('#h').val(c.h * scale);
};

function checkCoords()
{
	if (parseInt($('#w').val())) return true;
	alert('Please select a crop region then press submit.');
	return false;
};
