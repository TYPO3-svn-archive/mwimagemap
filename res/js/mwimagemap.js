/* All functions within this script need to be there.
If they lack, javascript errors will occur. */

function mwimagemap_showCBox(_elm) {
	document.getElementById(_elm).style.display = 'block';
}

function mwimagemap_hideCBox(_elm) {
	document.getElementById(_elm).style.display = 'none';
}

function mwimagemap_changearea(_elm1,_elm2) {
	document.getElementById(_elm1).src = document.getElementById(_elm2).src;
}

function mwimagemap_resetarea(_elm,_pic) {
	document.getElementById(_elm).src = _pic;
}

function mwimagemap_cboxover(_elm) {
	//document.getElementById(_elm).style.display='block';
}

function mwimagemap_cboxout(_elm) {
	//document.getElementById(_elm).style.display='none';
}