	var url = "get_address.php?address=";

	function handleHttpResponse(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('sido');

				for(i=0; i<total_counts.length; i++)
				{
					var sido = xmlDocument.getElementsByTagName('sido').item(i).firstChild.data;
					var zip = xmlDocument.getElementsByTagName('zip').item(i).firstChild.data;


					var idx = order.orAddress.length;

					order.orAddress.length += 1;
					order.orAddress.options[idx].text = sido;
					order.orAddress.options[idx].value = sido;

				}


				isWorking = false;
			}
		}
	}

	function handleHttpResponse2(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('sido');

				for(i=0; i<total_counts.length; i++)
				{
					var sido = xmlDocument.getElementsByTagName('sido').item(i).firstChild.data;
					var zip = xmlDocument.getElementsByTagName('zip').item(i).firstChild.data;


					var idx = order.shAddress.length;

					order.shAddress.length += 1;
					order.shAddress.options[idx].text = sido;
					order.shAddress.options[idx].value = sido;

				}


				isWorking = false;
			}
		}
	}

	var isWorking = false;
	var isWorking2 = false;

	function go_address(){

			tf = document.order.search_content.value;

			order.orAddress.length = null;

			// ajax start
			if(!isWorking && http){

				http.open("GET",url + tf,true);

				http.onreadystatechange = handleHttpResponse;
				isWorking = true;

				http.send(null);

			}

	}

	function go_address2(){

			tf = document.order.search_content2.value;

			order.shAddress.length = null;

			// ajax start
			if(!isWorking && http){

				http.open("GET",url + tf,true);

				http.onreadystatechange = handleHttpResponse2;
				isWorking2 = true;

				http.send(null);

			}

	}

	function getHTTPObject(){
		
		var xmlhttp;

	  /*@cc_on

	  @if (@_jscript_version >= 5)

		try {

		  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

		} catch (e) {

		  try {

			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

		  } catch (E) {

			xmlhttp = false;

		  }

		}

	  @else

	  xmlhttp = false;

	  @end @*/


		if(!xmlhttp && typeof XMLHttpRequest != 'underfined'){
			
			try{
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
	
	return xmlhttp;
	}

	var http = getHTTPObject();