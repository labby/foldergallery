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
function fg_toggle_categorie( aRef, aChildIDList )
{
    var folder_open     = "large icon folder open green";
    var folder_closed   = "large icon folder green";
    
    var state = "table-row";
    
    var current_class = aRef.getAttribute("class");
    
    if(current_class == folder_closed) {
        aRef.setAttribute("class", folder_open);
    } else {
        aRef.setAttribute("class", folder_closed);
        state = "none";
    }
    
    var list = aChildIDList.split(",");
    for( var i=0; i < list.length; i++ )
    {
        document.getElementById("cat_item_"+list[ i ]).style.display = state;
        if(state == "none") {
            hideChilds( list[ i ] );
        }
    }
}

function hideChilds( aID ) {

    var ref = document.getElementById("sub_item_"+aID);
    if(ref) {
        //
        var test = ref.getAttribute("onclick");
        var reg = /\'.*\'/;
        //console.log("ref-> "+ reg.exec(test) );
        var s = reg.exec(test);
        var s = s[0].replace(/\'/g, "");
        var s2 = s.split(",");
        // console.log("ref-> "+ s2 );
        for( var i=0; i < s2.length; i++) {
            document.getElementById("cat_item_"+s2[ i ]).style.display = "none";
        }
        
        ref.setAttribute("class", "large icon folder green");
    }
}

function fg_modifyThumb( aRef, aID, aLink) {
    var form = document.getElementById( "fg_list_thumbnails");
    form.action = aLink;
    
    var e = document.createElement("input");
    e.name = "edit";
    e.value = aID;
    form.appendChild( e );
    form.submit();
}