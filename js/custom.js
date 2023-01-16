function ex_right(_value, _count){ return _value.substr((_count*-1)); }

function ex_left(_value, _count){	return _value.substr(0,_count);	}	

function ex_obj2array(_object){ var _array = new Array(); for(var name in _object){ _array[name] = _object[name]; } return _array; }
 
function ex_array2Obj(_array){ var _object = new Object(); for(var key in _array){ _object[key] = _array[key]; } return _object; }	

function ex_loading(_id,_size){ 
	_size = _size || '24';
	$(_id).html('&nbsp;&nbsp;<img src=\'../images/common/loading.gif\' style=\'width:'+_size+'px;height:'+_size+'px;\'>');
	$(_id).show();	
}   

function ex_isEmpty(_value){ 
	if(ex_isNull(_value)){return true;}
	if(ex_isBlank(_value)){return true;}
	return false;
} 

function ex_isBlank(_value){ return jQuery.trim(_value)===''?true:false; } 

function ex_isNull(_value){ return jQuery._value===null?true:false; } 

function ex_setErrors(_id,_value){
	$(_id).html(_value);
	$(_id).show();
}

function ex_hideErrors(_id){
	$(_id).html('');
	$(_id).hide();
}		

function ex_nl2br (str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function ex_escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function ex_randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
    	var randomPoz = Math.floor(Math.random() * charSet.length);
    	randomString += charSet.substring(randomPoz,randomPoz+1);
    }
    return randomString;
}

function ex_date2db(ddmmyyyy) {
	//dd/mm/yyyy => yyyy-mm-dd
	return ddmmyyyy.substr(6, 4)+'-'+ddmmyyyy.substr(3, 2)+'-'+ddmmyyyy.substr(0, 2); 
} 
function ex_date2ui(yyyymmdd) {
	//yyyy-mm-dd => dd/mm/yyyy
	return yyyymmdd.substr(8, 2)+'/'+yyyymmdd.substr(5, 2)+'/'+yyyymmdd.substr(0, 4); 
} 
function checkText(str,obj){
    var isText=true;
	
	var txt1 = "'";
	var txt2 = '"';	
	//var txt3 = '\\';
    var orgi_text=txt1+txt2;
    var chk_text=str.split("");
    chk_text.filter(function(s){        
        if(orgi_text.indexOf(s)!=-1){
            isText=false;
            obj.value=str.replace(RegExp(s, "g"),'');
        }           
    }); 
    return isText; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด*/
}

function IsEmail(email){
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (filter.test(email)) 
		return true;
	else 
		return false;
}

function ValidateIPaddress(ipaddress) {
 if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress))
  {
    return (true);
  }
	return (false);
}
