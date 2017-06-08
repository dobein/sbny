	var url = "get_size.php?code1=";

	function handleHttpResponse(){
	
		alert('ok');

		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('color');

				alert(total_counts);

				for(i=0; i<total_counts.length; i++)
				{
					var color = xmlDocument.getElementsByTagName('color').item(i).firstChild.data;
					var size = xmlDocument.getElementsByTagName('size').item(i).firstChild.data;


					var idx = item_view.this_size.length;

					item_view.this_size.length += 1;
					item_view.this_size.options[idx].text = size;
					item_view.this_size.options[idx].value = color;

				}


				isWorking = false;
			}
		}
	}

	var isWorking = false;

	function go_size(tf,itemCode){

			go_img2(tf);

			if(tf == 'nos')
			{
				return;
			}

			//go_img2(item_view.this_color.selectedIndex-1);

			item_view.this_size.length = null;

			// ajax start
			if(!isWorking && http){

				http.open("GET",url + escape(tf) + "&itemCode=" + itemCode,true);

				http.onreadystatechange = handleHttpResponse;
				isWorking = true;

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