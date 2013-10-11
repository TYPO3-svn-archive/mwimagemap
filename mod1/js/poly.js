function add_point()
{
	if ( reg.exec(document.getElementById('xpos0').value) == null ) return;
	if ( reg.exec(document.getElementById('ypos0').value) == null ) return;
	var pos = document.getElementById('pos').selectedIndex;
	var real_pos = (pos==0?(akt_polynum+1):pos);
	var td = document.createElement('td');
	rename_pt_tbl(real_pos);
	akt_polynum += 1;
	document.getElementById('polynum').value = akt_polynum;
	
	var xid = document.createAttribute("id");
  xid.nodeValue = 'p_'+real_pos;
	td.setAttributeNode(xid);
	td.style.border = "1px solid #FF0000";
	td.style.padding = "5px";
	td.style.width = "20%";
	td.style.backgroundColor = "#EDE9E5";
	td.onmouseover = function(){tbg_ov3(this);}
  td.onmouseout = function(){tbg_out3(this);}
  
	if ( jg_ie )
	{
    var str = '<input name="hidden" type="hidden" id="persistent'+real_pos+'" value="0" />'
    +'<div id="pt_div'+real_pos+'" style="padding-bottom:7px;font-weight:bold;">'+pt_num_txt+real_pos+':</div>'
    +'<div style="padding-bottom:5px;white-space:nowrap;"> <img src="img/pencil.gif" id="rpoly'+real_pos+'" width="14" height="14" onClick="myrpoly('+real_pos+'); objs[selectedid].reset_dom();">&nbsp;&nbsp;&nbsp;&nbsp;'
    +'<input id="del'+real_pos+'" type="checkbox" name="del'+real_pos+'" value="1" onClick="del_click('+"'"+real_pos+"'"+'); build_pos_sel(); objs[selectedid].reset_dom();" /> '
    +'<img src="img/garbage.gif" width="11" height="12" alt="'+pt_del_txt+'" title="'+pt_del_txt+'">'
	  +'</div>'
    +pt_x_txt+'<input type="text" id="xpos'+real_pos+'" name="xpos'+real_pos+'" value="'+document.getElementById('xpos0').value+'" size="4" onChange="objs[selectedid].reset_dom();" /><br />'
    +pt_y_txt+'<input type="text" id="ypos'+real_pos+'" name="ypos'+real_pos+'" value="'+document.getElementById('ypos0').value+'" size="4" onChange="objs[selectedid].reset_dom();" />';
		
		td.innerHTML = str;
	} else {
		var el = document.createElement('input');
		var at = document.createAttribute('type');
		at.nodeValue = 'hidden';
		el.setAttributeNode(at);
		at = document.createAttribute('id');
		at.nodeValue = 'persistent'+real_pos;
		el.setAttributeNode(at);
		at = document.createAttribute('value');
		at.nodeValue = '0';
		el.setAttributeNode = (at);
		td.appendChild(el);
		el = document.createElement('div');
		at = document.createAttribute('id');
		at.nodeValue = 'pt_div'+real_pos;
		el.setAttributeNode(at);
		at = document.createAttribute('style');
		at.nodeValue = "padding-bottom:7px;font-weight:bold;";
		el.setAttributeNode(at);
		el.appendChild( document.createTextNode(pt_num_txt+real_pos+':') );
		td.appendChild( el );
		el = document.createElement('div');
		at = document.createAttribute('style');
		at.nodeValue ="padding-bottom:5px;white-space:nowrap;";
		el.setAttributeNode(at);
		elsub = document.createElement('img');
		at = document.createAttribute('src');
		at.nodeValue = "img/pencil.gif";
		elsub.setAttributeNode(at);
		at = document.createAttribute('id');
		at.nodeValue = "rpoly"+real_pos;
		elsub.setAttributeNode(at);
		at = document.createAttribute('onclick');
		at.nodeValue = 'myrpoly("'+real_pos+'"); objs[selectedid].reset_dom();';
		elsub.setAttributeNode(at);
		
		el.appendChild( elsub );
		
		var st = String.fromCharCode(160);
		el.appendChild( document.createTextNode(st+st+st+st) );
		
		elsub = document.createElement('input');
		at = document.createAttribute('type');
		at.nodeValue = 'checkbox';
		elsub.setAttributeNode(at);
		at = document.createAttribute('id');
		at.nodeValue = 'del'+real_pos;
		elsub.setAttributeNode(at);
		at = document.createAttribute('onclick');
		at.nodeValue = 'del_click('+real_pos+'); build_pos_sel(); objs[selectedid].reset_dom();';
		elsub.setAttributeNode(at);
		el.appendChild( elsub );
		el.appendChild( document.createTextNode(st) );
		
		elsub = document.createElement('img');
		at = document.createAttribute('src');
		at.nodeValue = "img/garbage.gif";
		elsub.setAttributeNode(at);
		at = document.createAttribute('alt');
		at.nodeValue = pt_del_txt;
		elsub.setAttributeNode(at);
		at = document.createAttribute('title');
		at.nodeValue = pt_del_txt;
		elsub.setAttributeNode(at);
		el.appendChild( elsub );

		td.appendChild(el);
		
		td.appendChild( document.createTextNode(pt_x_txt) );
		
		el = document.createElement('input');
		at = document.createAttribute('type');
		at.nodeValue = 'text';
		el.setAttributeNode(at);
		at = document.createAttribute('name');
		at.nodeValue = 'xpos'+real_pos;
		el.setAttributeNode(at);
		at = document.createAttribute('id');
		at.nodeValue = 'xpos'+real_pos;
		el.setAttributeNode(at);
		at = document.createAttribute('size');
		at.nodeValue = '4';
		el.setAttributeNode(at);
		at = document.createAttribute('value');
		at.nodeValue = document.getElementById('xpos0').value;
		el.setAttributeNode(at);
		at = document.createAttribute('onchange');
		at.nodeValue = 'objs[selectedid].reset_dom();';
		el.setAttributeNode(at);
		td.appendChild(el);
		td.appendChild( document.createElement('br') );
		td.appendChild( document.createTextNode(pt_y_txt) );
		el = document.createElement('input');
		at = document.createAttribute('type');
		at.nodeValue = 'text';
		el.setAttributeNode(at);
		at = document.createAttribute('name');
		at.nodeValue = 'ypos'+real_pos;
		el.setAttributeNode(at);
		at = document.createAttribute('id');
		at.nodeValue = 'ypos'+real_pos;
		el.setAttributeNode(at);
		at = document.createAttribute('size');
		at.nodeValue = '4';
		el.setAttributeNode(at);
		at = document.createAttribute('value');
		at.nodeValue = document.getElementById('ypos0').value;
		el.setAttributeNode(at);
		at = document.createAttribute('onchange');
		at.nodeValue = 'objs[selectedid].reset_dom();';
		el.setAttributeNode(at);
		td.appendChild(el);
	}
	
	document.getElementById('xpos0').value = '';
	document.getElementById('ypos0').value = '';
	
	var tr = document.getElementById('poly_tbl').firstChild;
	var td1 = tr.firstChild;
	if ( real_pos > 1 )
	{
		for ( pos = real_pos - 1; pos; --pos )
		{
			while ( td1 && td1.nodeName != 'TD' ) td1 = td1.nextSibling;
			if ( ! td1 )
			{
				tr = tr.nextSibling;
				while ( tr && tr.nodeName != 'TR' ) tr = tr.nextSibling;
				if ( !tr ) break;
				td1 = tr.firstChild;
				while ( td1 && td1.nodeName != 'TD' ) td1 = td1.nextSibling;
				if ( !td1 ) break;
			}
			td1 = td1.firstChild;
			while ( td1 && ( td1.nodeName != 'INPUT' || ( td1.nodeName == 'INPUT' && td1.getAttribute('type').toLowerCase() != 'checkbox' ) ) ) td1 = td1.nextSibling;
			if ( ! td1 ) break;
			if ( td1.checked )
			{
				++pos;
				++real_pos;
			}
			td1 = td1.parentNode.nextSibling;
		}
	}

	tr = document.getElementById('poly_tbl').firstChild;
	while ( tr && tr.nodeName != 'TR' ) tr = tr.nextSibling;
	var tr_pos = Math.floor((real_pos - 1) / obj_per_tr)
	var last_col = tr.getAttribute('bgcolor');
	while ( tr_pos )
	{
		--tr_pos;
		while ( tr.nextSibling && tr.nextSibling.nodeName != 'TR' ) tr = tr.nextSibling;
		if ( tr.nextSibling ) {
			tr = tr.nextSibling;
			last_col = tr.getAttribute('bgcolor');
		} else {
			tr = document.createElement('tr');
			at = document.createAttribute('bgcolor');
			if ( last_col == col1 )
				at.nodeValue = col2;
			else
				at.nodeValue = col1;
			tr.setAttributeNode(at);
			document.getElementById('poly_tbl').appendChild(tr);
			break;
		}
	}
	

	for(i=1;i<(akt_polynum);i++) {
	  if(i != real_pos) {
		  document.getElementById('p_'+i).style.borderColor = '#999999';
		}
	}
	
	var td_pos = real_pos % obj_per_tr;
	if ( td_pos == 0 ) td_pos = obj_per_tr;
	var td_count;
	while ( td )
	{
		td_count = count_tds( tr );
		insert_td_into_tr( td, tr, td_pos );
		if ( td_count < obj_per_tr )
			return;
		td = tr.lastChild;
		tr.removeChild(td);
		td_pos = 1;
		last_col = tr.getAttribute('bgcolor');
		tr = tr.nextSibling;
		if ( ! tr )
		{
			tr = document.createElement('tr');
			at = document.createAttribute('bgcolor');
			if ( last_col == col1 )
				at.nodeValue = col2;
			else
				at.nodeValue = col1;
			tr.setAttributeNode(at);
			document.getElementById('poly_tbl').appendChild(tr);
		}
	}
	document.getElementById('points').style.display = "block";
}

function rename_pt_tbl( pos )
{
	var i = akt_polynum;
	var el;
	while ( i >= pos )
	{
		if ( jg_ie ) {
      var str = '<td id="p_'+(i+1)+'" style="border:1px solid #999999;padding:5px;width:20%;background-color:#EDE9E5" onMouseOver="Javascript:tbg_ov3(this)" onMouseOut="Javascript:tbg_out3(this)">'
      +'<input name="hidden" type="hidden" id="persistent'+(i+1)+'" value="'+document.getElementById('persistent'+i).value+'" />'
      +'<div id="pt_div'+(i+1)+'" style="padding-bottom:7px;font-weight:bold;">'+pt_num_txt+(i+1)+':</div>'
      +'<div style="padding-bottom:5px;white-space:nowrap;"> <img src="img/pencil.gif" id="rpoly'+(i+1)+'" width="14" height="14" onClick="myrpoly('+(i+1)+'); objs[selectedid].reset_dom();">&nbsp;&nbsp;&nbsp;&nbsp;'
      +'<input id="del'+(i+1)+'" type="checkbox" name="del'+(i+1)+'" value="1" onClick="del_click('+"'"+(i+1)+"'"+'); build_pos_sel(); objs[selectedid].reset_dom();" '+(document.getElementById('del'+i).checked?' checked':'')+' /> '
      +'<img src="img/garbage.gif" width="11" height="12" alt="'+pt_del_txt+'" title="'+pt_del_txt+'">'
	    +'</div>'
      +pt_x_txt+'<input type="text" id="xpos'+(i+1)+'" name="xpos'+(i+1)+'" value="'+document.getElementById('xpos'+i).value+'" size="4" onChange="objs[selectedid].reset_dom();" /><br />'
      +pt_y_txt+'<input type="text" id="ypos'+(i+1)+'" name="ypos'+(i+1)+'" value="'+document.getElementById('ypos'+i).value+'" size="4" onChange="objs[selectedid].reset_dom();" />'
      +'</td>';
	
			var el = document.getElementById('persistent'+i).parentNode;
			el.innerHTML = str;
		} else {
			document.getElementById('persistent'+i).setAttribute('id', 'persistent'+(i+1));
			document.getElementById('rpoly'+i).setAttribute('onclick', 'myrpoly('+(i+1)+'); objs[selectedid].reset_dom();');
			document.getElementById('rpoly'+i).setAttribute('id', 'rpoly'+(i+1));
			document.getElementById('del'+i).setAttribute('onclick', 'del_click('+(i+1)+'); build_pos_sel(); objs[selectedid].reset_dom();');
			document.getElementById('del'+i).setAttribute('name', 'del'+(i+1));
			document.getElementById('del'+i).setAttribute('id', 'del'+(i+1));
			document.getElementById('xpos'+i).setAttribute('name', 'xpos'+(i+1));
			document.getElementById('xpos'+i).setAttribute('id', 'xpos'+(i+1));
			document.getElementById('ypos'+i).setAttribute('name', 'ypos'+(i+1));
			document.getElementById('ypos'+i).setAttribute('id', 'ypos'+(i+1));
			el = document.getElementById('pt_div'+i);
			el.setAttribute('id', 'pt_div'+(i+1));
			while ( el.hasChildNodes() ) el.removeChild(el.firstChild);
			el.appendChild( document.createTextNode(pt_num_txt+(i+1)+':') );
		}
		i -= 1;
	}
}

function rename_tbl_pt( i, i1 )
{
try {
	if ( jg_ie ) {
    var str = '<td id="p_'+i1+'" style="border:1px solid #999999;padding:5px;width:20%;background-color:#EDE9E5" onMouseOver="Javascript:tbg_ov3(this)" onMouseOut="Javascript:tbg_out3(this)">'
    +'<input name="hidden" type="hidden" id="persistent'+i1+'" value="1" />'
    +'<div id="pt_div'+i1+'" style="padding-bottom:7px;font-weight:bold;">'+pt_num_txt+i1+':</div>'
    +'<div style="padding-bottom:5px;white-space:nowrap;"> <img src="img/pencil.gif" id="rpoly'+i1+'" width="14" height="14" onClick="myrpoly('+i1+'); objs[selectedid].reset_dom();">&nbsp;&nbsp;&nbsp;&nbsp;'
    +'<input id="del'+i1+'" type="checkbox" name="del'+i1+'" value="1" onClick="del_click('+"'"+i1+"'"+'); build_pos_sel(); objs[selectedid].reset_dom();" '+(document.getElementById('del'+i).checked?' checked':'')+' /> '
    +'<img src="img/garbage.gif" width="11" height="12" alt="'+pt_del_txt+'" title="'+pt_del_txt+'">'
	  +'</div>'
    +pt_x_txt+'<input type="text" id="xpos'+i1+'" name="xpos'+i1+'" value="'+document.getElementById('xpos'+i).value+'" size="4" onChange="objs[selectedid].reset_dom();" /><br />'
    +pt_y_txt+'<input type="text" id="ypos'+i1+'" name="ypos'+i1+'" value="'+document.getElementById('ypos'+i).value+'" size="4" onChange="objs[selectedid].reset_dom();" />'
    +'</td>';
		
		var el = document.getElementById('persistent'+i).parentNode;
		el.innerHTML = str;
	} else {
		document.getElementById('persistent'+i).setAttribute('id', 'persistent'+i1);
		document.getElementById('rpoly'+i).setAttribute('onclick', 'myrpoly('+i1+'); objs[selectedid].reset_dom();');
		document.getElementById('rpoly'+i).setAttribute('id', 'rpoly'+i1);
		document.getElementById('del'+i).setAttribute('name', 'del'+i1);
		document.getElementById('del'+i).setAttribute('onclick', 'del_click("'+i1+'"); build_pos_sel(); objs[selectedid].reset_dom();');
		document.getElementById('del'+i).setAttribute('id', 'del'+i1);
		document.getElementById('xpos'+i).setAttribute('name', 'xpos'+i1);
		document.getElementById('xpos'+i).setAttribute('id', 'xpos'+i1);
		document.getElementById('ypos'+i).setAttribute('name', 'ypos'+i1);
		document.getElementById('ypos'+i).setAttribute('id', 'ypos'+i1);
		el = document.getElementById('pt_div'+i);
		el.setAttribute('id', 'pt_div'+i1);
		while ( el.hasChildNodes() ) el.removeChild(el.firstChild);
		el.appendChild( document.createTextNode(pt_num_txt+i1+':') );
	}
} catch ( e ) { alert ( 'fehler:'+i + ' '+ i1+ ' ' +e ); }
}

function disable_tbl_pt( i )
{
  try {
	  document.getElementById('rpoly'+i).setAttribute('disabled', true);
	  document.getElementById('xpos'+i).setAttribute('disabled', true);
	  document.getElementById('ypos'+i).setAttribute('disabled', true);
	  el = document.getElementById('pt_div'+i);
	  while ( el.hasChildNodes() ) el.removeChild(el.firstChild);
	  el.appendChild( document.createTextNode(pt_deleted_txt) );
  } catch ( e ) { alert ( 'fehler:'+i + ' ' +e ); }
}

function enable_tbl_pt( i )
{
  try {
	  document.getElementById('rpoly'+i).removeAttribute('disabled');
	  document.getElementById('xpos'+i).removeAttribute('disabled');
	  document.getElementById('ypos'+i).removeAttribute('disabled');
  } catch ( e ) { alert ( 'fehler:'+i + ' ' +e ); }
}

function insert_td_into_tr( td, tr, td_pos )
{
	for ( var i = tr.firstChild; i; i = i.nextSibling )
	{
		if ( i.nodeName != 'TD' ) continue;
		if ( td_pos == 1 )
		{
			tr.insertBefore( td, i );
			return;
		}
		td_pos -= 1;
	}
	tr.appendChild( td );
}

function count_tds( tr )
{
	var ret = 0;
	for ( var i = tr.firstChild; i; i = i.nextSibling )
		if ( i.nodeName == 'TD' ) { ret += 1; }
	return ret;
}

function build_pos_sel()
{
	var i;
	var pos = document.getElementById('pos');
	var opt;
	if ( pos.firstChild )
	{
		opt = 0;
		for ( i = pos.firstChild; i && opt < 2; i = i.nextSibling ) if ( i.nodeName == 'OPTION' ) opt += 1;
		while ( i )
		{
			opt = i;
			i = i.nextSibling;
			pos.removeChild(opt);
		}
	}
	for ( i = 1; i < akt_polynum; ++i )
	{
		opt = document.createElement('option');
		opt.appendChild( document.createTextNode((i+1)+pos_opt_txt) );
		pos.appendChild(opt);
	}
	pos.selectedIndex = 0;
}


function del_click( num )
{
	var i;
	if ( document.getElementById('del'+num).checked )
	{
		if ( document.getElementById('rpoly'+num).checked ) { myrpoly(0); }
		num = parseInt(num);
		akt_polynum -= 1;
		document.getElementById('polynum').value = akt_polynum;
		if ( document.getElementById('persistent'+num).value == 0 )
		{
			var el = document.getElementById('persistent'+num);
			while ( el.nodeName != 'TD' ) el = el.parentNode;
			var el1 = el.parentNode;
			var el2;
			el1.removeChild(el);
			el = el1;
			el1 = el.nextSibling;
			while ( el1 && el1.nodeName != 'TR' ) el1 = el1.nextSibling;
			while ( el1 )
			{
				el2 = el1.firstChild;
				el1.removeChild(el2);
				el.appendChild(el2);
				if ( count_tds(el1) == 0 )
				{
					el1.parentNode.removeChild(el1);
					break;
				}
				el = el1;
				el1 = el1.nextSibling;
				while ( el1 && el1.nodeName != 'TR' ) e11 = el1.nextSibling;
			}
			if ( num < akt_polynum + 1 ) {
				for ( i = num + 1; i < akt_polynum + 2; ++i ) { rename_tbl_pt(i, i-1); }
      }
			build_pos_sel();
			objs[selectedid].reset_dom();
		} else {
			deleted_pts += 1;
			rename_tbl_pt(num, 'del'+deleted_pts);
			disable_tbl_pt('del'+deleted_pts);
			if ( num < akt_polynum + 1 ) {
				for ( i = num + 1; i < akt_polynum + 2; ++i ) { rename_tbl_pt(i, i-1); }
      }
		}
	} else {
		var el = document.getElementById('del'+num);
		while ( el.nodeName != 'TD' ) el = el.parentNode;
		while ( 1 )
		{
			if ( ! el.previousSibling )
			{
				while ( el.nodeName != 'TR' ) el = el.parentNode;
				el = el.previousSibling;
				while( el && el.nodeName != 'TR' ) el = el.previousSibling;
				if ( ! el ) break;
				el = el.lastChild;
				while ( el.nodeName != 'TD' ) el = el.previousSibling;
			} else
				el = el.previousSibling;
			if ( el.nodeName != 'TD' ) { continue; }
			el1 = el.firstChild;
			while ( el1.nodeName != 'INPUT' || ( el1.nodeName == 'INPUT' && el1.getAttribute('type').toLowerCase() != 'hidden' )) { el1 = el1.nextSibling; }
			if ( el1.checked == false ) { break; }
		}
		if ( !el ) new_num = 1;
		else {
			reg.exec(el1.getAttribute('id'));
			new_num = parseInt(RegExp.$1) + 1;
		}
		for ( i = akt_polynum; i >= new_num; --i ) { rename_tbl_pt(i, i+1); }
		akt_polynum += 1;
		document.getElementById('polynum').value = akt_polynum;
		rename_tbl_pt(num, new_num);
		enable_tbl_pt(new_num);
	}
}


function myrpoly( num )
{
  pchecked = num;
  if(num != 0) {
	  document.getElementById('rpoly').checked = false;
    document.getElementById('p_'+num).style.borderColor = "#FF0000";
	  document.getElementById('actpoint').value = num;
	  pchecked = num;
    for ( i=1; i<=akt_polynum; ++i ) {
	    if(i != num) { document.getElementById('p_'+i).style.borderColor = "#999999"; }
	  }
	}
	else {
    for ( i=1; i<=akt_polynum; ++i ) {
	    if(i != num) { document.getElementById('p_'+i).style.borderColor = "#999999"; }
	  } 
	}
}

function imgonclick(Event)
{
	var xelem;
	var yelem;
	var posx = -1;
	var posy = -1;
	
	if ( jg_ie )
	{
		posx += 1;
		posy += 1;
	}

	if ( wrong_coord )
	{
		posx = wx;
		posy = wy;
	}

	if ( is_a_obj(Event) ) { return; }

	try {
		if ( typeof Event.layerX == 'undefined' ) { throw("bla");	}
		if(navigator.appName == 'Microsoft Internet Explorer' && (navigator.appVersion.indexOf('MSIE 10') != -1 || navigator.appVersion.indexOf('MSIE 9') != -1)) {
			posx += window.event.offsetX;
			posy += window.event.offsetY;
		}
		else {
			posx += Event.layerX;
			posy += Event.layerY;
		}
	} catch(e) {
		try {
			posx += window.event.offsetX;
			posy += window.event.offsetY;
		} catch(e) {
			try {
				posx += Event.layerX;
				posy += Event.layerY;
			}
			catch(e) {
				alert(e+" Onclick functionality not supported!"); return 1;
			}
		}
	}
	try {
		document.getElementById("xpos"+pchecked).value = posx;
		document.getElementById("ypos"+pchecked).value = posy;
		if ( pchecked != 0 ) { objs[selectedid].reset_dom(); }
		else {
		  if(document.getElementById("rpoly").checked == true) {
			  add_point();
			  build_pos_sel();
			  objs[selectedid].reset_dom();
			}
		}		
	} catch (e)  { alert(e); }
}