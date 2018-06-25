/*********检查身份证号码格式 2015-06-08********/
function isIdCardNo(num) {
    var factorArr = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1);
    var parityBit = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2");
    var varArray = new Array();
    var intValue;
    var lngProduct = 0;
    var intCheckDigit;
    var intStrLen = num.length;
    var idNumber = num;
    // initialize
    if ((intStrLen != 15) && (intStrLen != 18)) {
        return false;
    }
    // check and set value
    for (i = 0; i < intStrLen; i++) {
        varArray[i] = idNumber.charAt(i);
        if ((varArray[i] < '0' || varArray[i] > '9') && (i != 17)) {
            return false;
        } else if (i < 17) {
            varArray[i] = varArray[i] * factorArr[i];
        }
    }
    if (intStrLen == 18) {
        //check date
        var date8 = idNumber.substring(6, 14);
        if (isDate8(date8) == false) {
            return false;
        }
        // calculate the sum of the products
        for (i = 0; i < 17; i++) {
            lngProduct = lngProduct + varArray[i];
        }
        // calculate the check digit
        intCheckDigit = parityBit[lngProduct % 11];
        // check last digit
        if (varArray[17] != intCheckDigit) {
            return false;
        }
    }
    else {        //length is 15
        //check date
        var date6 = idNumber.substring(6, 12);
        if (isDate6(date6) == false) {
            return false;
        }
    }
    return true;
}
function isDate6(sDate) {
    if (!/^[0-9]{6}$/.test(sDate)) {
        return false;
    }
    var year, month, day;
    year = sDate.substring(0, 4);
    month = sDate.substring(4, 6);
    if (year < 1700 || year > 2500) return false
    if (month < 1 || month > 12) return false
    return true
}

function isDate8(sDate) {
    if (!/^[0-9]{8}$/.test(sDate)) {
        return false;
    }
    var year, month, day;
    year = sDate.substring(0, 4);
    month = sDate.substring(4, 6);
    day = sDate.substring(6, 8);
    var iaMonthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
    if (year < 1700 || year > 2500) return false
    if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)) iaMonthDays[1] = 29;
    if (month < 1 || month > 12) return false
    if (day < 1 || day > iaMonthDays[month - 1]) return false
    return true
}

/*********检查长时间格式 2008-09-09 22:22:22********/
function strDateTime(str) 
{ 
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/; 
	var r = str.match(reg); 
	if(r==null)return false; 
	var d= new Date(r[1], r[3]-1,r[4],r[5],r[6],r[7]); 
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]&&d.getHours()==r[5]&&d.getMinutes()==r[6]&&d.getSeconds()==r[7]); 
}

/*********检查长时间 2008-09-09 ********/
function strDate(str) 
{ 
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/; 
	var r = str.match(reg); 
	if(r==null)return false; 
	var d= new Date(r[1],r[3]-1,r[4]); 
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]); 
}

//检查空格
function isWhiteWpace(s)
{
  var whitespace = " \t\n\r";
  var i;
  for (i = 0; i < s.length; i++){   
     var c = s.charAt(i);
     if (whitespace.indexOf(c) >= 0) {
		  return false;
	  }
   }
   return true;
}

//英文字符
function isSsnString (ssn)
{
	var re=/^[0-9a-z][\w-.]*[0-9a-z]$/i;
	if(re.test(ssn))
	return true;
	else
	return false;
}

function checkEmail(email)
{
	//var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	var reg = /^(?:\w+\.?)*\w+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	//var reg =/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
	flag = reg.test(email);
	if (!flag) {
		return false;
	}
	return true
}

//检查价格格式
function isMoney(s){ 

	var regex = /^-?\d[\d,]*([.]\d+)?$/; // 123,456.0129 or -123456 or -1,23,,,45,6.0909 or 123456,,,,,.09
	if (!s.match(regex)) {
		return false;
	}
	return true;
	//var regu = "^[0-9]+[\.?][0-9?]{0,2}$";
	//var re = new RegExp(regu);
	//if (re.test(s)) {
	//	return true;
	//} else {
	//	return false;
	//}
}

//检查价格格式
function isMoneyDims(s){ 
	
	var regex = /^-\d[-\d,]*([.]\d+)?$/;  // 123,456.0129 or -123456 or -1,23,,,45,6.0909 or 123456,,,,,.09
	if (!s.match(regex)) {
		return false;
	}
	return true;
	//var regu = "^[0-9]+[\.?][0-9?]{0,2}$";
	//var re = new RegExp(regu);
	//if (re.test(s)) {
	//	return true;
	//} else {
	//	return false;
	//}
}

//检查价格格式
function isMoneyNums(s){ 

	var regex = /^\d[\d,]*([.]\d+)?$/; // 123,456.0129 or -123456 or -1,23,,,45,6.0909 or 123456,,,,,.09
	if (!s.match(regex)) {
		return false;
	}
	return true;
	//var regu = "^[0-9]+[\.?][0-9?]{0,2}$";
	//var re = new RegExp(regu);
	//if (re.test(s)) {
	//	return true;
	//} else {
	//	return false;
	//}
}

//检查是否数字
function isNumber(s){   
	var regu = /^[0-9]+$/;
    if (!regu.test(s)) {
        return false;
    } 
    return true;
    // var regu = "^[0-9]+$";
    // var re = new RegExp(regu);
	// if (s.search(re) != -1) {
	// 	return true;
	// } else {
	// 	return false;
	// }
}

function isMobile(phone){
	var num = phone;
	var partten = /^1[3,4,5,7,8]\d{9}$/;
	if(partten.test(num)){
		return true;
	}else{
		return false;
    }
}

function itemShow(itemName,showId,num,bgItemName,clsName){ 
  var clsNameArr=new Array(2)
  if(clsName.indexOf("|")<=0){
    clsNameArr[0]=clsName
    clsNameArr[1]=""
  }else{
    clsNameArr[0]=clsName.split("|")[0]
    clsNameArr[1]=clsName.split("|")[1]
  }
  
  for(i=1;i<=num;i++){
    if(document.getElementById(itemName+i)!=null)
      document.getElementById(itemName+i).style.display="none"
    if(document.getElementById(bgItemName+i)!=null)
      document.getElementById(bgItemName+i).className=clsNameArr[1]
    if(i==showId){
      if(document.getElementById(itemName+i)!=null)
        document.getElementById(itemName+i).style.display=""
      else
        $.dialog.alert("未找到您请求的内容！")
      if(document.getElementById(bgItemName+i)!=null)
        document.getElementById(bgItemName+i).className=clsNameArr[0]
    }
  }
}
/*********iframe自适应高********/
function iframeHeight(iframeName) {
	var pTar = null;
	if (document.getElementById){
		pTar = document.getElementById(iframeName);
	}
	else{
		document.getElementById('pTar = ' + iframeName + ';');
	}
	if (pTar && !window.opera){
		pTar.style.display="block"
		if (pTar.contentDocument && pTar.contentDocument.body.offsetHeight)
		{
			pTar.height = pTar.contentDocument.body.offsetHeight+FFextraHeight;
		}else if (pTar.Document && pTar.Document.body.scrollHeight)
		{
			pTar.height = pTar.Document.body.scrollHeight;
		}
	}
}
function allselect()
{
	$("input[name='selected']").attr("checked",true);
}


