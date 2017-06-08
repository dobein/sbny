	var url = "get_category.php?code1=";

	function handleHttpResponse(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('name');


				for(i=0; i<total_counts.length; i++)
				{
					var name = xmlDocument.getElementsByTagName('name').item(i).firstChild.data;
					var code2 = xmlDocument.getElementsByTagName('code2').item(i).firstChild.data;


					var idx = category.Category2.length;

					if(i == total_counts.length-1)
					{
						category.Category3.length += 1;
						category.Category3.options[0].text = name;
						category.Category3.options[0].value = code2;
					}
					else
					{
					category.Category2.length += 1;
					category.Category2.options[idx].text = name;
					category.Category2.options[idx].value = code2;
					}

				}


				isWorking = false;
			}
		}

	}

	function handleHttpResponse2(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('name');


				for(i=0; i<total_counts.length; i++)
				{
					var name = xmlDocument.getElementsByTagName('name').item(i).firstChild.data;
					var code2 = xmlDocument.getElementsByTagName('code2').item(i).firstChild.data;


					var idx = category.Category3.length;

					category.Category3.length += 1;
					category.Category3.options[idx].text = name;
					category.Category3.options[idx].value = code2;

				}


				isWorking = false;
			}
		}

	}


	var isWorking = false;

	function go_change(tf,flag){


		if(flag == 'first')
		{

			category.Category2.length = null;
			category.Category3.length = null;

			if(tf == 0) return;

			// ajax start
			if(!isWorking && http){

				http.open("GET",url + escape(tf),true);

				http.onreadystatechange = handleHttpResponse;
				isWorking = true;

				http.send(null);

			}

		}
		else if(flag == 'second')
		{

			category.Category3.length = null;

			// ajax start
			if(!isWorking && http){

				http.open("GET",url + escape(tf) + '&flag=' + flag,true);

				http.onreadystatechange = handleHttpResponse2;
				isWorking = true;

				http.send(null);

			}

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