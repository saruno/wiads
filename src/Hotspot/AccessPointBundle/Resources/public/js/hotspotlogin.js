var blur = 0;
var starttime = new Date();
var startclock = starttime.getTime();
var mytimeleft = 0;

function popUp(URL) {
	if (self.name != wifihotspot_popup) {
		wifihotspot_popup = window.open(URL,'wifihotspot_popup','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=375');
	}
}

function doOnLoad(result, URL, userurl, redirurl, timeleft) {
	if (timeleft) {
		mytimeleft = timeleft;
	}

	if ((result == 1) && (self.name == wifihotspot_popup)) {
		doTime();
	}

	if ((result == 1) && (self.name != wifihotspot_popup)) {
		wifihotspot_popup = window.open(URL,'wifihotspot_popup','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=375');
	}

	if ((result == 2) || (result == 5)) {
		;/*document.form2.UserName.focus();*/
	}

	if ((result == 2) && (self.name != wifihotspot_popup)) {
		wifihotspot_popup = window.open('','wifihotspot_popup','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400,height=200');
		wifihotspot_popup.close();
	}

	if ((result == 12) && (self.name == wifihotspot_popup)) {

		doTime();

		if (redirurl) {
			opener.location = redirurl;
		} else if (opener.home) {
			opener.home();
		} else {
			opener.location = "about:home";
		}

		self.focus();
		blur = 0;
	}


	if ((result == 13) && (self.name == wifihotspot_popup)) {
		self.focus();
		blur = 1;
	}
}


function doOnBlur(result) {
	if ((result == 12) && (self.name == wifihotspot_popup)) {
		if (blur == 0) {
			blur = 1;
			self.focus();
	        }
	}
}