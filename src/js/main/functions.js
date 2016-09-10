/*
* @$skop = scope variable
* @orig = original values
* @tmp = temporay value for fiedl edit
* field = object__element pattern in String
*/
function fieldEditor($skop, orig, tmp, field){
	var e = field.substring(field.indexOf("__")+2);
	tmp[e] = orig[e];
	$skop[field] = true;
	$skop[field+"_invalid"] = false;
}

/*
* @$skop = angular scope variable
* @$http = angular http variable
* @orig = original values
* @tmp = temporay value for fiedl edit
* field = object__element pattern in String
* action = object data
*/
function fieldEditorUpdate($http, $skop, orig, tmp, field, action){
	console.log(field);
	//invalid input
	if($skop[field+'_invalid'] === true){
		return
	}
	var e = field.substring(field.indexOf("__")+2);
	//Clean leading and trailing spaces
	tmp[e] = $.trim(tmp[e]);
	//Empty new data entry
	if(tmp[e].length <= 0){
		$skop[field+'_invalid'] = true;
	}
	else{
		$skop[field+'invalid'] = false;
		$skop[field] = false;
		if(orig[e] !== tmp[e]){
			orig[e] = tmp[e];
			action[e] = tmp[e];
			//console.log(action);
			httpProcess($http, action, false, false);
		}
	}
}

/*
*@$http = ($http) http dependency
*@reqObj = (object) array post request
*@reload = (bool) reload page on success
*@retReq = (bool) return $http request function
*/
function httpProcess($http, reqObj, reload, retReq){
	//console.log(reqObj);
	if(reqObj !== null && typeof reqObj === 'object'){

		var httpRequest = $http.post('php/process.php', $.param(reqObj), {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
		success(function (data) {
			if(data !== null && typeof data === 'object' && 'error' in data){
				if(reqObj.action === 'login'){
					reqObj.submitted = true;
				}
				else if(reqObj.action === 'register'){
					if(data.error == 'Duplicate error.'){
						jQuery('#view-reg div.intro-message').css({'display':'block'});
						jQuery(".reg-loader").remove();
						reqObj.emailExist = true;
					}
				}
				else{
					location.reload();
				}
			}
			else if(reload){
				location.reload();
			}
			else{
				return data;
			}
			//console.log(data);
		}).error(function(data) {
			alert("Error contacting server. Please contact Dev CS.");
		});

		if(retReq){ //Return request function
			return httpRequest;
		}

	}
}

function primaryLoader(cls,msg){
	return '<span class="ajax-loader '+cls+'">'+msg+' <img src="img/blue-cube.gif" /></span>';
}

function isValidEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}