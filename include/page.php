<?php

$this->page=array
	(
	'title'=>array
	    (
	    'ru'=>'<title>Форма регистрации</title>',
	    'en'=>'<title>Registaration Form</title>',
	    ),
	'head'=>array
	    (
	    'meta'=>array
		(
		"http-equiv='Content-Type' content='text/html; charset=utf-8'",
		),
	    'link'=>array
		(
		"href='style/index.css' type='text/css' rel='stylesheet'",
		"href='style/jquery-ui.css' rel='stylesheet' type='text/css'",
		),
	    'script'=>array
		(
		"src='scripts/jquery-1.12.4.js'",
		"src='scripts/jquery-ui.js'",
		"language='javascript' src='scripts/common.js'",
		),

	    ),

	'body'=>array
	    (
	    'top'=>"<div class='testbox'>",
	    'langbox'=>"<div class='accounttype'>
    			<input type='radio' value='en' id='langen' name='account' checked/>
    			<label for='langen' class='radio' >English</label>
    			<input type='radio' value='ru' id='langru' name='account'' />
    			<label for='langru' class='radio'>Russian</label>
		    </div>
		    <hr>",
	    'bottom'=>"</div>",
	    )
	);

?>
