<?php
    include_once('../include/class_try.php');
    

class Ajax extends CreatePage
{
function __construct()
    {
    $this->LoadFile();
    $this->CheckReq();
    }

public function  JsonAjax()
    {
    $dann=$this->lang;
    if($this->lang)
	{
	$dann='{"window_title":"'.strip_tags($this->page['title'][$this->lang]).'",';
	$dann.='"'.$this->form['htid'].'":"'.$this->form['title'][$this->lang].'"';
	foreach($this->form['fields'] as $id=>$val)
	    {
	    $dann.=',"'.$id.'":{';
	    if(isset($val['title'])) $dann.='"title":"'.$val['title'][$this->lang].'"';
	    if(isset($val['comment'])) $dann.=',"comment":"'.$val['comment'][$this->lang].'"';
	    if(isset($val['required'])) $dann.=',"required":"'.$val['required'][$this->lang].'"';
	    if(isset($val['list']))
		{ 
		$dann.=',"list":{';
		foreach($val['list'] as $opid=>$opval)
		    {
		    $dann.=($opid?',"':'"').$opid.'":"'.$opval[$this->lang].'"';
		    }
		$dann.='}';
		}
	    $dann.='}';
	    }
	$dann.='}';
	}
    return $dann;
    }
}

    
$port=new Ajax();
echo $port->JsonAjax();
?>