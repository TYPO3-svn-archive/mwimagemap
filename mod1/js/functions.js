// Display/Hide panes
function a_toggle(elm) {
  disp  = (document.getElementById(elm).style.display == "none") ? "block" : "none";
  img   = (document.getElementById(elm).style.display == "none") ? "minus" : "plus";
  alt   = (document.getElementById(elm).style.display == "none") ? hideoptions : showoptions;
  title = (document.getElementById(elm).style.display == "none") ? hideoptions : showoptions;
  document.getElementById(elm+'toggle').src   = 'img/'+img+'.gif';
  document.getElementById(elm+'toggle').title = title;
  document.getElementById(elm+'toggle').alt   = alt;
  document.getElementById(elm).style.display  = disp;
}

// Mouseover change of pane background colors
function tbg_ov(obj) { obj.style.backgroundColor = '#E3E2E2'; }
function tbg_out(obj) { obj.style.backgroundColor = '#EFEFF4'; }

function tbg_ov2(obj,picid,pictype) {
  tbg_ov(obj);
  document.getElementById(picid).src = 'img/'+pictype+'_2.gif';
}
function tbg_out2(obj,picid,pictype) {
  tbg_out(obj);
  document.getElementById(picid).src = 'img/'+pictype+'_1.gif';
}

function tbg_ov3(obj) { obj.style.backgroundColor = '#E3E2E2'; }
function tbg_out3(obj) { obj.style.backgroundColor = '#EDE9E5'; }

// color related functions
function addcol() {
  _addcols     = document.getElementById('addcols').value;
	_addcolnames = document.getElementById('addcolnames').value;
	_addcols     = (_addcols.length == 0) ? document.getElementById('be_col').value : _addcols+","+document.getElementById('be_col').value;
	_addcolnames = (_addcolnames.length == 0) ? document.getElementById('be_colname').value : _addcolnames+","+document.getElementById('be_colname').value;
	document.getElementById('addcols').value = _addcols;
	document.getElementById('addcolnames').value = _addcolnames;
	addcolOption(document.getElementById('be_col').value,document.getElementById('be_colname').value);
	document.getElementById('be_col').value = '';
	document.getElementById('be_colname').value = '';
	document.getElementById('be_col_but').style.backgroundColor = '#FFFFFF';
	document.getElementById('sel_col').options[(document.getElementById('sel_col').options.length-1)].selected = true;
	change_color();
	changes = 1;
}

function removecolOption(color,colname)
{
  var elSel = document.getElementById('sel_col');
  var i;
  for (i = elSel.length - 1; i>=0; i--) {
	  if(i > (ocols-1)) {
      if (elSel.options[i].value == color && elSel.options[i].text == colname) {
        elSel.remove(i);
      }
	  }
  }
}

function addcolOption(color,colname)
{
  var elOptNew = document.createElement('option');
  elOptNew.text = colname;
  elOptNew.value = color;
  var elSel = document.getElementById('sel_col');

  try { elSel.add(elOptNew, null); }
  catch(ex) { elSel.add(elOptNew); }
}

function delCol() {
  delconf = confirm(coldelmsg);
	if(delconf == true) {
    dcol            = document.getElementById('sel_col').options[document.getElementById('sel_col').selectedIndex].value;
	  dcolname        = document.getElementById('sel_col').options[document.getElementById('sel_col').selectedIndex].text;
    if(document.getElementById('addcols').value.length != 0) {
      _addcols        = document.getElementById('addcols').value.split(",");
	    _addcolnames    = document.getElementById('addcolnames').value.split(",");
	    _newaddcols     = new Array();
	    _newaddcolnames = new Array();
	    for(i=0;i<_addcols.length;i++) {
	      if(_addcols[i] != dcol && _addcolnames[i] != dcolname) {
		      _newaddcols.push(_addcols[i]);
			    _newaddcolnames.push(_addcolnames[i]);
		    }
	    }
	    _newcols     = _newaddcols.join(",");
	    _newcolnames = _newaddcolnames.join(",");
		  document.getElementById('addcols').value = _newcols;
		  document.getElementById('addcolnames').value = _newcolnames;
    }
		
    _delcols     = document.getElementById('delcols').value;
	  _delcolnames = document.getElementById('delcolnames').value;
	  _delcols     = (_delcols.length == 0) ? dcol : _delcols+","+dcol;
	  _delcolnames = (_delcolnames.length == 0) ? dcolname : _delcolnames+","+dcolname;
		
		document.getElementById('delcols').value = _delcols;
		document.getElementById('delcolnames').value = _delcolnames;

	  removecolOption(dcol,dcolname);
	  change_color();
	  changes = 1;
	}
}

//test for valid hex scheme input: 6 characters, 0-9, a-f, A-F
function validateColor(elm1,elm2,elm3) {
  i = 0
  j = 1
  val = 0	//if val=1, proceed; else, prompt for valid input
  textVal = document.getElementById(elm1).value;
	
 if (textVal.substring(i,j) != "#"){ textVal = "#" + textVal}	//add # if it's not there already
 while (j < textVal.length){
	  i++
	  j++
	  if ((textVal.length == 7) && ((textVal.substring(i,j) == 0) || (textVal.substring(i,j) == 1) || (textVal.substring(i,j) == 2) || (textVal.substring(i,j) == 3) || (textVal.substring(i,j) == 4) || (textVal.substring(i,j) == 5) || (textVal.substring(i,j) == 6) || (textVal.substring(i,j) == 7) || (textVal.substring(i,j) == 8) || (textVal.substring(i,j) == 9)) || ((textVal.substring(i,j) == "A") || (textVal.substring(i,j) == "a") || (textVal.substring(i,j) == "B") || (textVal.substring(i,j) == "b") || (textVal.substring(i,j) == "C") || (textVal.substring(i,j) == "c") || (textVal.substring(i,j) == "D") || (textVal.substring(i,j) == "d") || (textVal.substring(i,j) == "E") || (textVal.substring(i,j) == "e") || (textVal.substring(i,j) == "F") || (textVal.substring(i,j) == "f"))){
	    document.getElementById(elm2).style.backgroundColor = textVal;
	  }
	  else { textVal = "#000000"; }
  }
  document.getElementById(elm2).style.backgroundColor = textVal;
	document.getElementById(elm1).value = textVal;
	if(elm3.length != 0 && document.getElementById(elm3).value.length == 0) { document.getElementById(elm3).value = textVal; }
}

// Frame related functions
function checkvisible() {
  var d2 = document.getElementById("fe_visible2");
  var d3 = document.getElementById("fe_visible3");
  var scol = document.getElementById('s_bcol').value;
  var sbd  = document.getElementById('s_bthc').value;
  if(d2.checked == true || d3.checked == true) {
    if(scol.length != 0) {
      document.getElementById('fe_bcol').value = scol;
      document.getElementById('fe_bcol_but').style.backgroundColor = scol;
    }
    else {
      var selcol = document.getElementById('sel_col').options[document.getElementById('sel_col').selectedIndex].value;
      document.getElementById('fe_bcol').value = selcol;
      document.getElementById('fe_bcol_but').style.backgroundColor = selcol;
      document.getElementById('s_bcol').value = selcol;
      document.getElementById('s_bthc').value = sbd;
    }
		//if(sbd != document.getElementById('fe_borderthickness').value) { sbd = document.getElementById('fe_borderthickness').value; }
    if(sbd.length == 0 || isNaN(sbd) || sbd == 0) { sbd = 1; }
    document.getElementById('fe_borderthickness').value = sbd;
  }
  else {
	  if(sbd != document.getElementById('fe_borderthickness').value) { document.getElementById('s_bthc').value = document.getElementById('fe_borderthickness').value; }
    document.getElementById('fe_bcol').value = "";
    document.getElementById('fe_bcol_but').style.backgroundColor = "#FFFFFF";
		document.getElementById('fe_borderthickness').value = "";
  }
}

function additionalcolorFunction(flag,color) {
  if(flag == 1) { document.getElementById('s_bcol').value = color; }
}

// List view related functions
function setLborder(aid) {
  if(document.getElementById("x_area_"+aid)) {
    document.getElementById("x_area_"+aid).style.borderColor = "#FF0000";
  }
}

var clflag = 0;
var xtc = 0;
function goClick(num,url,flag) {
	if(flag == 1) { clflag = 1; }
	else {
	  if(clflag == 0) { location.href = url; }
	}
	xtc = setTimeout("resetFlag()",200);
}
function resetFlag() {
  clearTimeout(xtc);
	clflag = 0;
	xtc = 0;
}


function togglePos() {
  newpos = (tpos == "u") ? "d" : "u";
	document.getElementById(newpos).appendChild(document.getElementById("mpos"));
	document.getElementById("mposimg").src   = "img/"+tpos+".gif";
	document.getElementById("mposimg").alt   = m_toggle[tpos];
	document.getElementById("mposimg").title = m_toggle[tpos];
	tbg_out(document.getElementById("mpos"));
	tpos = newpos;
}

imgonclick = function() {;}