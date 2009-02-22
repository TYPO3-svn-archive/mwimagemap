var preid = "wzjs"; // Attention, if preid and id are both integers!
var reg = /(\d+)/;

var blinks = 1;
function make_blink_int(id)
{
	var el = document.getElementById(id);
	if ( blinks == 1 )
	{
		el.style.display = 'block';
		blinks = 0;
	} else {
		blinks = 1;
		el.style.display = 'none';
	}
}


/**********
 * Circle *
 **********/

function circle(x, y, r, id, col)
{
	this.xpos = x;
	this.ypos = y;
	this.radius = r;
	this.id = id;
	this.color = col;
	this.interval = false;

	this.drag = function(x1, y1, x2, y2)
	{
		var r = Math.floor( Math.sqrt( Math.pow( Math.abs(x1-x2), 2 ) + Math.pow( Math.abs(y1-y2), 2 ) ) / 2 );
		x1 += Math.ceil( (x2 - x1) / 2 );
		y1 += Math.ceil( (y2 - y1) / 2 );
		document.getElementById('radius').value = r;
		document.getElementById('xpos').value = x1;
		document.getElementById('ypos').value = y1;
		this.reset(x1, y1, r);
	}

	this.make_blink = function()
	{
		if ( ! this.interval ) {
			this.interval = window.setInterval('make_blink_int("'+preid+this.id+'")', 500);
		}
	}
	
	this.stop_blink = function()
	{
		if ( this.interval ) { window.clearInterval(this.interval); }
		this.interval = false;
		document.getElementById(preid+this.id).style.display = 'block';
	}
	
	
	this.paint = function()
	{
		jg.setID(preid+this.id);
		jg.setColor(this.color);
		jg.drawEllipse(this.xpos-this.radius, this.ypos-this.radius, this.radius*2-1, this.radius*2-1);
		jg.paint();
	}


	this.reset_dom = function(x, y, r)
	{
		var px, py, pr;
		if ( reg.exec(document.getElementById(x).value) == null ) {
			px = 0;
		}
		else {
			px = parseInt(RegExp.$1);
		}
		if ( reg.exec(document.getElementById(y).value) == null ) {
			py = 0;
		}
		else {
			py = parseInt(RegExp.$1);
		}
		if ( reg.exec(document.getElementById(r).value) == null ) {
			pr = 0;
		}
		else {
			pr = parseInt(RegExp.$1);
		}
		this.reset(px, py, pr);
	}


	this.reset = function(x, y, r)
	{
		this.xpos = x;
		this.ypos = y;
		this.radius = r;
		jg.removeItem(preid+this.id);
		this.paint();
	}


	this.is_in_obj = function(x, y)
	{
		if ( Math.sqrt( Math.pow( x - this.xpos, 2 ) + Math.pow( y - this.ypos, 2 ) ) <= this.radius ) {
			return true;
		}
		return false;
	}
	
	this.paint();
}




/*************
 * Rectangle *
 *************/

function rectangle( x, y, w, h, id, col )
{
	this.xpos = x;
	this.ypos = y;
	this.width = w;
	this.height = h;
	this.id = id;
	this.color = col;
	this.interval = false;

	
	this.drag = function(x1, y1, x2, y2)
	{
		var w = Math.abs(x1-x2);
		var h = Math.abs(y1-y2);
		if ( x2 < x1 && y2 > y1 )
		{
			x1 = x2;
		} else if ( y2 < y1 && x2 > x1 ) {
			y1 = y2;
		} else if ( y2 < y1 && x2 < x1 ) {
			x1 = x2;
			y1 = y2;
		}
		document.getElementById('xpos').value = x1;
		document.getElementById('ypos').value = y1;
		document.getElementById('xsize').value = w;
		document.getElementById('ysize').value = h;
		this.reset(x1, y1, w, h);
	}

	this.make_blink = function()
	{
		if ( ! this.interval )
			this.interval = window.setInterval('make_blink_int("'+preid+this.id+'")', 500);
	}
	
	this.stop_blink = function()
	{
		if ( this.interval )
			window.clearInterval(this.interval);
		this.interval = false;
		document.getElementById(preid+this.id).style.display = 'block';
	}
	
	
	this.paint = function()
	{
		jg.setID(preid+id);
		jg.setColor(this.color);
		jg.drawRect(this.xpos, this.ypos, this.width, this.height);
		jg.paint();
	}

	this.reset_dom = function( x, y, w, h )
	{
		var px, py, pw, ph;
		if ( reg.exec(document.getElementById(x).value) == null )
			px = 0;
		else
			px = parseInt(RegExp.$1);
		if ( reg.exec(document.getElementById(y).value) == null )
			py = 0;
		else
			py = parseInt(RegExp.$1);
		if ( reg.exec(document.getElementById(w).value) == null )
			pw = 0;
		else
			pw = parseInt(RegExp.$1);
		if ( reg.exec(document.getElementById(h).value) == null )
			ph = 0;
		else
			ph = parseInt(RegExp.$1);
	
		this.reset(px,py,pw,ph);
	}



	this.reset = function reset( x, y, w, h )
	{
		this.xpos = x;
		this.ypos = y;
		this.width = w;
		this.height = h;
	
		jg.removeItem(preid+this.id);
		this.paint();
	}


	this.is_in_obj = function( x, y )
	{
		if ( x >= this.xpos && x <= this.xpos+this.width &&
			 y >= this.ypos && y <= this.ypos+this.height )
			return true;
		return false;
	}

	this.paint();
}





/***********
 * Polygon *
 ***********/

function polygon( x, y, id, col, clo, ms, me )
{
	this.xarray = x;
	this.yarray = y;
	this.numpts = x.length;
	this.id = id;
	this.color = col;
	this.close_ = clo;
	this.markstart = ms;
	this.markend = me;
	this.interval = false;
	this.markedpt = -1;


	this.drag = function(x1, y1, x2, y2)
	{
	}

	this.make_blink = function()
	{
		if ( ! this.interval )
			this.interval = window.setInterval('make_blink_int("'+preid+this.id+'")', 500);
	}
	
	this.stop_blink = function()
	{
		if ( this.interval )
			window.clearInterval(this.interval);
		this.interval = false;
		document.getElementById(preid+this.id).style.display = 'block';
	}
	

	this.close_polygon = function( b )
	{
		this.close_ = b;
		jg.removeItem(preid+id);
		this.paint();
	}


	this.paint = function()
	{
		jg.setID(preid+this.id);
		jg.setColor(this.color);
		if ( this.xarray.length < 2 )
			return;
		if ( this.xarray.length == 2 )
		{
			jg.drawLine(this.xarray[0], this.yarray[0], this.xarray[1], this.yarray[1]);
		} else {
			if ( this.close_ )
			{
				jg.drawPolygon( this.xarray, this.yarray );
			} else {
				jg.drawPolyline( this.xarray, this.yarray );
			}
		}
		if ( this.markedpt > -1 )
		{
			jg.drawEllipse(this.xarray[this.markedpt]-2, this.yarray[this.markedpt]-2, 4, 4);
		}
		if ( this.markstart && this.markedpt != 0 )
		{
			jg.setColor("#00ff00");
			jg.drawEllipse(this.xarray[0]-2, this.yarray[0]-2, 4, 4);
		}
		if ( this.markend && this.markedpt+1 != this.numpts )
		{
			jg.setColor("#ff0000");
			jg.drawEllipse(this.xarray[this.xarray.length-1]-2, this.yarray[this.yarray.length-1]-2, 4, 4);
		}
		
		jg.paint();
	}


	this.reset_dom = function()
	{
	try {
		this.close_ = document.getElementById('close').checked;
		this.markend = document.getElementById('endpoint').checked;
		this.markstart = document.getElementById('startpoint').checked;
		this.numpts = akt_polynum;
		this.markedpt = -1;
		var _x, _y;


		this.xarray = new Array();
		this.yarray = new Array();

		for ( i = 1; i <= this.numpts; ++i )
		{
		  if(pchecked ==i)
			//if ( document.getElementById('rpoly'+i).checked )
				this.markedpt = i - 1;
			_x = document.getElementById('xpos'+i).value;
			_y = document.getElementById('ypos'+i).value;
			if ( reg.exec(_x) == null ) continue;
			_x = parseInt(RegExp.$1);
			if ( reg.exec(_y) == null ) continue;
			_y = parseInt(RegExp.$1);
			this.xarray.push(_x);
			this.yarray.push(_y);
		}

		jg.removeItem(preid+id);
		this.paint();
	} catch ( e ) { alert('error: '+e); }
	}


	this.is_in_obj = function( x, y )
	{
		if ( this.xarray.length == 0)
			return false;
	
		var ax = this.xarray[this.xarray.length - 1];
		// A ist der letzte Punkt vor B, der nicht ..
		var ay = this.yarray[this.yarray.length - 1];
		// .. mit dem Testpunkt auf gleicher Hoehe liegt.
		if ( ay == y ) ++y; // unschöner Bugfix
		var bx, by; // B ist der aktuelle Punkt
		var lx = ax; // L ist IMMER der letzte Punkt vor B (nur x ist von Belang)
	
		var zaehl = 0;
		var ignore = false;
		var zx;
	
		for (var i = 0; i < this.xarray.length; i++)
		{
			bx = this.xarray[i];
			by = this.yarray[i];
	
			if (!ignore)
			{
				if ((by == y) && (bx >= x))
				{
					if (bx == x)
						return true;
					ignore = true;
				} else {
					if ((ay < y) == (y < by))
					{
						if (x < Math.min(ax, bx))
							zaehl++;
						else if (x > Math.max(ax, bx));
						else if (x < (zx = ((bx - ax) * (y - ay) / (by - ay)) + ax))
							zaehl++;
						else if (zx == x)
							return true;
					}
					ax = bx;
					ay = by;
				}
			}
			else
			{
				if (by == y)
				{
					if (((lx < x) == (x < bx)) || (bx == x))
						return true;
				}
				else
				{
					if ((ay < y) == (y < by))
						zaehl++;
					ignore = false;
					ax = bx;
					ay = by;
				}
			}
			lx = bx;
		}
		if ((zaehl & 1) > 0)
			return true;
		else
			return false;
	}

	this.paint();
}