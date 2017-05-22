<?php
class PMySql 
{
var $last_error;
var $link;
var $affected_rows;
var $insert_id;

function Connect($host,$user,$pass,$db)
    {
    if($this->link = @mysqli_connect($host,$user,$pass))
	{
	if(!@mysqli_select_db($this->link,$db)) return false;
	}
	else
	{
	return false;
	}
    return $this->link;
    }

function Execute($sql)
    {
    if($this->link)
	{
	$res = @mysqli_query($this->link,$sql);
	if(@mysqli_error($this->link)) return false;
	if($res)
	    {
	    $this->affected_rows = @mysqli_affected_rows($this->link);
	    $this->insert_id = @mysqli_insert_id($this->link);
	    }
	}
	else
	{
	return false;
	}
	return $res;
    }

function Next($res)
    {
    return @mysqli_fetch_assoc($res);
    }
}
?>

