<?php



class DressHtml
{
var $form;
var $lang;
var $errors;
var $conf;
private function common_elem($opt,$name,$key)
    {
    $common_elem['value']=(isset($opt['value'])?"value='".$opt['value']."'":"");
    $common_elem['atrib']=" ".($opt['control']=='file'?"accept='".$opt['accept']."'":"")."  ".(isset($this->errors[$name])?"falval":"")." placeholder='".$opt['title'][$this->lang]."' name='".$name."' id='".$name."' ".(isset($opt['required'])?'required':'')." ".(isset($opt['validator'])?"validator='".$opt['validator']."'":'')."  titleMY='<b>".$opt['title'][$this->lang]."</b><br>".$opt['comment'][$this->lang].".<br><b>".(isset($opt['required'])?$opt['required'][$this->lang]:'')."</b>'";
    $common_elem['reqclas']=(isset($opt['required'])?'required':'unrequired');
    return $common_elem[$key];
    }
function __construct($form,$lang,$error,$conf)
    {
    $this->form=$form;
    $this->lang=$lang;
    $this->errors=$error;
    $this->conf=$conf;
    }

function DressForm()
    {
    $cont_form="<table style='visibility: hidden;position: absolute;' id='tableONF'><tr><td><div class='triangle-left'></div></td><td><div class='infofield22' id='helpboxONF'></div></td></tr></table>";
    $cont_form.="<table style='visibility: hidden;position: absolute;' id='tableONM'><tr><td><div class='infofield22' id='helpboxONM'></div></td><td><div class='triangle-right'></div></td></tr></table>";
    $cont_form.="<h1 id='".$this->form['htid']."'>".$this->form['title'][$this->lang]."</h1><hr>";
    $cont_form.="<form action='' method='".$this->form['method']."' enctype='multipart/form-data' onsubmit='return ValidateForm(this)'>";
    $cont_form.="<input type='hidden' id='token' name='token' value='".crypt($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'],$this->conf['mySalt'])."'>";
    foreach($this->form['fields'] as $field=>$options)
	{
	$func="Dress_".(isset($options['control'])?$options['control']:'');
	$func=(method_exists(get_class($this),$func)?$func:"Dress_def");
	$cont_form.=$this->$func($field,$options);
	}
    $cont_form.="</form>";
    return $cont_form;
    }
    
private function Dress_def($name,$opt)
    {
    $opt['control']=(isset($opt['control'])?$opt['control']:'text');
    $dres="<input ".$this->common_elem($opt,$name,'atrib')." ".$this->common_elem($opt,$name,'value')."  type='".$opt['control']."'  ".($opt['control']=='submit'?"class='button' value='".$opt['title'][$this->lang]."'":" class='fields ".$this->common_elem($opt,$name,'reqclas')."'").">";
    return $dres;
    }
    
private function Dress_readonly($name,$opt)
    {
	return "<div class='infofield' ><b>".$opt['title'][$this->lang].":</b><br>".$opt['value']."</div>";
    }
    
private function Dress_textarea($name,$opt)
    {
    $dres="<textarea ".$this->common_elem($opt,$name,'atrib')." class='textarea ".$this->common_elem($opt,$name,'reqclas')."' >".(isset($opt['value'])?$opt['value']:"")."</textarea>";
    return $dres;

    }

private function Dress_select($name,$opt)
    {
    $sel="<select ".$this->common_elem($opt,$name,'atrib')." class='selectMY ".$this->common_elem($opt,$name,'reqclas')."'>";
    foreach($opt['list'] as $id=>$val)
        {
        $sel.="<option value='".$id."' ".(isset($opt['value']) && $id==$opt['value']?"selected":"")."  >".$val[$this->lang]."</option>";
        }
    $sel.="</select>";
    return $sel;
    }
}
?>

