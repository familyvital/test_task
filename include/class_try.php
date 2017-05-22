<?php
include_once('mysql.php');
include_once('DressHTML.php');
class CreatePage
{
var $form;
var $page;
var $content;
var $lang;
var $conf;
var $errors;
function __construct()
    {
    $this->LoadFile();
    $this->GetLang();
    $this->CheckReq();
    $this->DressPage();
    }
    

 function LoadFile()
    {
    include_once('form_try.php');
    include_once('page.php');
    include_once('config.php');
    }

function DressPage()
    {
    $this->content="<html><head>";
    foreach($this->page['head'] as $tag=>$cont)
	{
	foreach($cont as $cont_line)
	    {
	    $this->content.="<".$tag." ".$cont_line.">\n".($tag=='script'?"</script>":"");
	    }
	}
    $this->content.=$this->page['title'][$this->lang];
    $this->content.="</head><body>";
    $this->content.=$this->page['body']['top'];
    $this->content.=$this->page['body']['langbox'];
    $cont_form=new DressHtml($this->form,$this->lang,$this->errors,$this->conf);
    $this->content.=$cont_form->DressForm();
    $this->content.=$this->page['body']['bottom'];
    $this->content.="</body></html>";
    echo $this->content;
    }

 function GetLang()
    {
    if(isset($_COOKIE["lang"]) && $_COOKIE["lang"])
	{
	$this->lang=$_COOKIE["lang"];
	}
	else
	{
	setcookie("lang", $this->conf['lang_def']);
	$this->lang=$this->conf['lang_def'];
	}
	
    }


 function checkVAL($val)
    {
    $val=str_replace(array("\r","\n", chr(10))," ",$val);
    $val = trim(strip_tags($val));
    $val = htmlspecialchars($val);
    $val = @mysql_real_escape_string($val);
    return $val;
    }


function CheckReq()
    {
    $error_temp=array();
    $_temp_form=array();
    if(isset($_REQUEST['token']) && $_REQUEST['token']==crypt($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'],$this->conf['mySalt']))
	{
	if(isset($_REQUEST['registrBUT']) && $_REQUEST['registrBUT'])
	    {
	    foreach($this->form['fields'] as $per=>$val)
		{
		if(isset($val['control']) && $val['control']=='submit') continue;
		if($this->__checkFields($per,$val))
		    {
		    $this->form['fields'][$per]['value']=(isset($val['control']) && $val['control']=='file'?$val['upload_file']:$val['value']);
		    $_temp_form[$per]=$val;
		    $_temp_form[$per]['control']='readonly';
		    }
	    	    else
		    {
		    $error_temp[$per]=1;
		    }
		}
	    if(!count($error_temp))
		{
		if($this->MysqlWork($_temp_form))
		    {
		    $this->page['body']['langbox']="";
		    $this->form['fields']=$_temp_form;
		    }
		    else
		    {
		    if(!isset($this->errors['email'])) $this->form['title'][$this->lang]='BD Error.Write Admin';
		    }
		}
		else
		{
		$this->errors=$error_temp;
		}
	    }

	if(isset($_REQUEST['ajax']) && isset($_REQUEST['lang']) && $_REQUEST['lang'])
	    {
	    $this->lang=$this->checkVAL($_REQUEST['lang']);
	    }
	}
    }

}



class ActiveForm extends CreatePage
{

private function _UploadFile($file,&$opt)
    {
    if(isset($opt['accept']))
	{
	$type_file=explode(",",$opt['accept']);
	if(!in_array($file['type'],$type_file)) return false;
	}
	
	if(isset($opt['size']) && $file['size']>$opt['size']) return false;
	
    	$fval = time().$this->checkVAL($file['name']);
    if(!move_uploaded_file($file['tmp_name'],sprintf('./images/photos/%s',$fval))) return false;
	$opt['upload_file']=$fval;
	$opt['value']=$fval;
    return true;
    }

private function email_valid($val)
    {
    if(!filter_var($val, FILTER_VALIDATE_EMAIL)) return false;
    return true;
    }

private function passw_valid($val)
    {
    if(mb_strlen($val)<6) return false;
    return true;
    }

private function phone_valid($val)
    {
    if(!preg_match('/^\+?([0-9]{2})\)?[\(]?([0-9]{3})[\)]?([0-9]{3})[-]?([0-9]{2})[-]?([0-9]{2})$/', $val)) return false;
    return true;
    }



 function __checkFields($field,&$fmas)
    {
    $tval='';
    if(isset($_REQUEST[$field]))
	{
    	$tval = $this->checkVAL($_REQUEST[$field]);
	$fmas['value']=$tval;
	}
    if(isset($fmas['control']) && $fmas['control']=='file')
	{
	if(isset($_FILES[$field]))
	    {
	     $tval = $this->checkVAL($_FILES[$field]['name']);
	    if(!$this->_UploadFile($_FILES[$field],$fmas)) return false;
	    }
	}
	
    if(isset($fmas['required']))
	{
	if(isset($fmas['control']) && $fmas['control']=='file' && !isset($_FILES[$field]))
	    {
	    return false;
	    }
	    else
	    {
	    if(!$tval) return false;
	    }
	}
	if(isset($fmas['validator']) && method_exists(get_class($this),$fmas['validator']) && !$this->$fmas['validator']($tval)) return false;
    return true;
    }



function MysqlWork(&$mas)
    {
    $db=new PMySql();
    if(!$db->Connect($this->conf['host'],$this->conf['user'],$this->conf['pass'],$this->conf['BD'])) return false;
    $sel_query=sprintf("SELECT id FROM users WHERE email='%s'",$mas['email']['value']);
    if(!$res=$db->Execute($sel_query)) return false;
    if($sel_mas=$db->Next($res))
	{
	$answe['ru']="Этот Email уже зарегестрирован";
	$answe['en']="The Email was registred already";
	$this->form['fields']['email']['value']=$answe[$this->lang];
	$this->errors['email']=1;
        return false;
	}
    $ins_query="INSERT INTO users SET created=now()";
    foreach($mas as $k=>$t)
	{
	if($k=='password') $t['value']=crypt($t['value'],$this->conf['mySalt']);
	$ins_query.=sprintf(",".$k."='%s'",$t['value']);
	}
    if(!$db->Execute($ins_query)) return false;
    $id_user=$db->insert_id;
    $ins_query=sprintf("INSERT INTO options SET 
    created=now(),
    user_id=%d ,
    ip='%s',
    browser='%s',
    token='%s',
    lang='%s'",
    $id_user,
    $this->checkVAL($_SERVER['REMOTE_ADDR']),
    $this->checkVAL($_SERVER['HTTP_USER_AGENT']),
    crypt($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'],$this->conf['mySalt']),
    $this->lang
    );
    if(!$db->Execute($ins_query)) return false;
    $sel_query=sprintf("SELECT users.*,options.*,users.created as us_cr FROM users LEFT JOIN options on users.id=options.user_id WHERE users.id=%d",$id_user);
    if(!$res=$db->Execute($sel_query)) return false;
    if(!$sel_mas=$db->Next($res)) return false;
    foreach($mas as $k=>$dan)
	{
	$mas[$k]['value']=$sel_mas[$k];
	if($k=='photo') $mas[$k]['value']="<img class='infofield image' src='".$dan['upload_path'].$sel_mas[$k]."'>";
	if(isset($dan['list'])) $mas[$k]['value']=$dan['list'][$sel_mas[$k]][$this->lang];
	}
	$mas['options']['value']="<b>Created:</b> ".$sel_mas['us_cr']."<br><b>IP:</b> ".$sel_mas['ip']."<br><b>Languge:</b> ".$sel_mas['lang']."<br><b>BR:</b> ".$sel_mas['browser'];
	$mas['options']['control']="readonly";    
	$mas['options']['title']['ru']="Клиент инфо";    
	$mas['options']['title']['en']="User Info";
    return true;
    }
}


?>
