/**
 *  @module         foldergallery
 *  @version        see info.php of this module
 *  @author         cms-lab (initiated by Jürg Rast)
 *  @copyright      2010-2018 cms-lab 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */


/* Tooltipp Funktionen */
 /*
wmtt = null; 
document.onmousemove = updateWMTT;
 
function updateWMTT(e) {
  if (wmtt != null) {
    x = (document.all) ? window.event.x + wmtt.offsetParent.scrollLeft : e.pageX;
    y = (document.all) ? window.event.y + wmtt.offsetParent.scrollTop  : e.pageY;
    wmtt.style.left = (x + 20) + "px";
    wmtt.style.top   = (y + 20) + "px";
  }
}

function showWMTT(id) {
  wmtt = document.getElementById(id);
  wmtt.style.display = "block"
}
 
function hideWMTT() {
  wmtt.style.display = "none";
}
*/
/* Kategorieanzeige Funktionen */
 /*
function toggle_visibility(id) {
	if (document.getElementById(id).style.display == "block") {
		document.getElementById(id).style.display = "none";
	}
	else {
		document.getElementById(id).style.display = "block";
	}
}



function toggle_plus_minus(id){
	var plus = new Image;
	plus.src = LEPTON_URL+"/modules/lib_lepton/backend_images/plus_16.png";
	var minus = new Image;
	minus.src = LEPTON_URL+"/modules/lib_lepton/backend_images/minus_16.png";

	var img_src = document.images['plus_minus_' + id].src;
	if (img_src == plus.src) {
		document.images['plus_minus_' + id].src = minus.src;		
	}
	else {
		document.images['plus_minus_' + id].src = plus.src;
	}
}
*/

/**
 *  New by aldus
 *
 */
function fg_toggle_categorie( aImgRef, aChildIDList )
{
    var _plus = LEPTON_URL+"/modules/lib_lepton/backend_images/plus_16.png";
    var _minus = LEPTON_URL+"/modules/lib_lepton/backend_images/minus_16.png";
    var state = "table-row";
    
    if(aImgRef.src == _plus)
    {
        aImgRef.src = _minus;
        
    } else {
        aImgRef.src = _plus;
        state = "none";
    }
    
    var list = aChildIDList.split(",");
    for( var i=0; i < list.length; i++ )
    {
        document.getElementById("cat_item_"+list[ i ]).style.display = state;
        // console.log("hello "+list[i]);
    }
} 