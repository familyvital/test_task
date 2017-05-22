
$(function() {
	$("#bithday").datepicker({
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: "yy-mm-dd"
	    });
if(document.getElementById(document.cookie.split(';')[0].replace("=",""))) document.getElementById(document.cookie.split(';')[0].replace("=","")).checked = true;
$("input[name='account']").change(function (chek)
    {
    var token=document.getElementById('token').value;
    $.ajax
    	(
    	    {
    	    type: 'get',
    	    url: 'ajax/getlang.php?ajax=1&token='+token+'&lang='+chek.target.value,
    	    success: function (data) 
    	            {
    	            //alert(data);
    	            if(data)
    	        	{
    	        	document.cookie = "lang=; path=/test_task/; expires=-1";
			document.cookie = "lang="+chek.target.value+"; path=/test_task/;";
    	        	var b
    	        	var user = JSON.parse(data);
    	        	for(b in user)
    	        	    {
    	        	    if(b=='window_title')
    	        		{
    	        		document.title=user[b];
    	        		continue;
    	        		}
    	        	    if(document.getElementById(b).getAttribute("placeholder"))
    	        		{
    	        		document.getElementById(b).setAttribute("placeholder", user[b]['title']);
    	        		}
    	        	    if(document.getElementById(b).getAttribute("titleMY"))
    	        		{
    	        		document.getElementById(b).setAttribute("titleMY", '<b>'+user[b]['title']+'</b><br>'+user[b]['comment']+'<br>'+(user[b]['required']?'<b>'+user[b]['required']+'</b>':''));
    	        		}
    	        	    ret=document.getElementById(b);
    	        	    if(ret['nodeName']=='H1') ret.innerHTML=user[b];
    	        	    if(ret['nodeName']=='INPUT' && ret.getAttribute("type")=='submit') ret.value=user[b]['title'];
    	        	    if(ret['nodeName']=='SELECT') 
    	        		{
    	        		var i=0;
    	        		while(i<ret.options.length)
    	        		    {
    	        		    ret.options[i].innerHTML=user[b]['list'][i];
    	        		    i++;
    	        		    }
    	        		}
    	        	    }
    	    		}
    	            }
    	    }
    	);
    });
    
    
//	if($(obj).css("background-color")!='rgb(252, 140, 153)') obj.setAttribute('falval',$(obj).css("background-color"));
//	$(obj).css("background-color",'#fc8c99');
    
$("[falval]").attr('falval',$("[falval]").css("background-color"));
$("[falval]").css("background-color",'#fc8c99');
//$("[titleMY]").mouseover(function(e){ShowComm(e);});
$("[titleMY]").hover(function(e){ShowComm(e);});
$("[titleMY]").focus(function(e){ShowComm(e);});
$("[titleMY]").blur(function(e){ShowComm(e);});
$("[validator]").blur(function(e){ValidateFields(e.target);});
});


function ShowComm(elid)
    {
    //alert(event.type);
    var rt=(elid.type.match('mouse')?'M':'F');
    var fl=((elid.type=='mouseleave' || elid.type=='blur')?2:1);
    var smesh=(rt=='M'?-353:322);
    if(fl==1)
    {
    document.getElementById('tableON'+rt).style.visibility='visible';
    document.getElementById('tableON'+rt).style.top=elid.target.offsetTop-(elid.target.nodeName=='TEXTAREA'?28:42);
    document.getElementById('tableON'+rt).style.left=elid.target.offsetLeft-0+smesh;
    document.getElementById('helpboxON'+rt).innerHTML=elid.target.getAttribute("titleMY");
    }
    else
    {
    document.getElementById('tableON'+rt).style.visibility='hidden';
    $('.triangle-right').css("border-left",'40px solid #1cccf2');
    }
    return false;
    }


function ValidateForm(form)
    {
    var b=0;
    var retcur=true;
    while(b<form.elements.length)
    {
    if(form.elements[b].getAttribute("validator"))
	{
	if(!ValidateFields(form.elements[b])) retcur=false;
	}
//    temp+=b+"--"+form.elements[b];
    b++;
    }
    //alert(temp);
    return retcur;
    }

function ValidateFields(obj)
    {
    var valid=obj.getAttribute("validator");
    //var rez_fun=eval(valid+"('"+obj.value+"')");
    if(eval(valid+"('"+obj.value+"')"))
	{
	//$(obj).focus();
	//$('.triangle-right').css("border-left",'40px solid #1cccf2');
	if(obj.getAttribute('falval'))
	{ 
	$(obj).css("background-color",obj.getAttribute('falval'));
	obj.removeAttribute('falval');
	//alert("TRUUUUU=="+$(obj).css("background-color")+'===='+obj.getAttribute('falval'));
	}
	return true;
	}
	else
	{
	fal_obj={type:"mouseenter",target:obj};
	ShowComm(fal_obj);
	$('.triangle-right').css("border-left",'40px solid red');
	if($(obj).css("background-color")!='rgb(252, 140, 153)') obj.setAttribute('falval',$(obj).css("background-color"));
	$(obj).css("background-color",'#fc8c99');
	return false;
	//alert("FALSEEEE=="+$(obj).css("background-color"));
//	alert("FALSEEEE");rgb(252, 140, 153)
	//alert("FALSEEE=="+$(obj).css("background-color")+'===='+obj.getAttribute('falval'));
	}
    }

function email_valid(mail)   
    {  
     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail) || !mail)  
       {  
           return true;
	}  
//    alert("You have entered an invalid email address!")  
         return false;
     } 
     
function passw_valid(pasw)   
    {  
     if (pasw.length>5 || !pasw)  
       {  
           return true;
	}  
//    alert("You have entered an invalid email address!")  
         return false;
     } 

function photo_valid(photo)   
    {  
    var allowedFiles = [".jpg", ".gif", ".png", ".jpeg"];
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
    if(regex.test(photo.toLowerCase()) || !photo) {
         return true;
        }
        else
        {
        return false;
        }
    } 


    
function phone_valid(phone)  
{  
    var regser = /^\+?([0-9]{2})\)?[\(]?([0-9]{3})[\)]?([0-9]{3})[-]?([0-9]{2})[-]?([0-9]{2})$/;
    if(phone.match(regser) || !phone)  
            {  
             return true;  
            }  
            else  
            {  
//            alert("BAD PHONE");  
            return false;
            }  
}  

