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
    }
} 