/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         cms-lab (initiated by Jürg Rast)
 *  @copyright      2009-2017 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */

/* Tooltipp Funktionen */
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

/* Kategorieanzeige Funktionen */
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