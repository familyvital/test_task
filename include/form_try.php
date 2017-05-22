<?php

$reqMAS['en']="Required field";
$reqMAS['ru']="Обязательное поле";

$this->form=array
(
'method'=>'post',
'htid'=>'title_form',
'title'=>array
	(
	'ru'=>'Форма регистрации',
	'en'=>'Registration form',
	),
'fields'=>array
	(
	'name'=>array
	    (
	    'required'=>$reqMAS,
	    'title'=>array
		(
		'ru'=>'Имя',
		'en'=>'Name',
		),
	    'comment'=>array
		(
		'ru'=>'Введите Ваше имя',
		'en'=>'Write Your name',
		),
	    ),
	'lastname'=>array
	    (
#	    'required'=>$reqMAS,
	    'title'=>array
		(
		'ru'=>'Фамилия',
		'en'=>'Lastname/Family name',
		),
	    'comment'=>array
		(
		'ru'=>'Введите Вашу фамилию',
		'en'=>'Write Your Lastname/Family name',
		),
	    ),
	'midname'=>array
	    (
	    'title'=>array
		(
		'ru'=>'Отчество',
		'en'=>'Patronymic/Middle name',
		),
	    'comment'=>array
		(
		'ru'=>'Введите Ваше отчество',
		'en'=>'Write Your Patronymic/Middle name',
		),
	    ),

	'email'=>array
	    (
	    'validator'=>'email_valid',
	    'required'=>$reqMAS,
	    'title'=>array
		(
		'ru'=>'Электронная почта',
		'en'=>'Email',
		),
	    'comment'=>array
		(
		'ru'=>'Email будет логином для регистрации в системе',
		'en'=>'Mail will be login for registration in the system',
		),
	    ),
	'password'=>array
	    (
	    'required'=>$reqMAS,
	    'control'=>'password',
	    'validator'=>'passw_valid',
	    'title'=>array
		(
		'ru'=>'Пароль',
		'en'=>'Password',
		),
	    'comment'=>array
		(
		'ru'=>'Пароль для регистрации в системе<br>Требуемая длина пароля не меньше 6 символов',
		'en'=>'Password for registration in system<br>Required min length 6 characters',
		),
	    ),

	'number'=>array
	    (
#	    'control'=>'readonly',
	    'validator'=>'phone_valid',
	    'required'=>$reqMAS,
	    'title'=>array
		(
		'ru'=>'Номер телефона',
		'en'=>'Phone number',
		),
	    'comment'=>array
		(
		'ru'=>'Номер телефона в формате<br>+XX(XXX)XXX-XX-XX',
		'en'=>'Phone number in format<br>+XX(XXX)XXX-XX-XX',
		),
	    ),
	'photo'=>array
	    (
	    'control'=>'file',
	    'size'=>'1000000',
	    'upload_path'=>'images/photos/',
	    'accept'=>'image/jpeg,image/png,image/gif',
	    'validator'=>'photo_valid',
	    'required'=>$reqMAS,
	    'title'=>array
		(
		'ru'=>'Фотография',
		'en'=>'Photo',
		),
	    'comment'=>array
		(
		'ru'=>'Файл в формате gif, jpg, png<br>Максимальный размер 1Мb',
		'en'=>'File in format gif, jpg, png<br>Max size 1Mb',
		),
	    ),
	'gender'=>array
	    (
	    'title'=>array
		(
		'ru'=>'Пол',
		'en'=>'Gender',
		),
	    'comment'=>array
		(
		'ru'=>'Выбирите Пол',
		'en'=>'Select Gender',
		),
	    'control'=>'select',
	    'list'=>array
		(
		'0'=>array
		    (
		    'ru'=>'Выбирите Пол',
		    'en'=>'Select Gender',
		    ),
		'1'=>array
		    (
		    'ru'=>'муж',
		    'en'=>'man',
		    ),
		'2'=>array
		    (
		    'ru'=>'жен',
		    'en'=>'fem',
		    ),
		),
	    ),
	'notes'=>array
	    (
	    'required'=>$reqMAS,
	    'control'=>'textarea',
	    'title'=>array
		(
		'ru'=>'Домашний адрес',
		'en'=>'Home address',
		),
	    'comment'=>array
		(
		'ru'=>'Укажите свой адрес проживания в формате:<br>Индекс, Страна, Город, Улица, номер дома<br>Адрес необходим для доставки товаров',
		'en'=>'Enter your address in the format:<br>ZipCode, Country, City, Street, house number<br>Address is necessary for the delivery of goods',
		),
	    ),
	'bithday'=>array
	    (
#	    'control'=>'date',
	    'title'=>array
		(
		'ru'=>'Дата рождения',
		'en'=>'Date of Birth',
		),
	    'comment'=>array
		(
		'ru'=>'Компания дарит подарки на дни рождения своих клиентов',
		'en'=>'Our company gives gifts for customers`s birthdays',
		),
	    ),
	'registrBUT'=>array
	    (
	    'title'=>array
		(
		'ru'=>'Зарегистрироваться',
		'en'=>'Registration',
		),
	    'comment'=>array
		(
		'ru'=>'Нажать для регистрации',
		'en'=>'Push for registration',
		),
	    'control'=>'submit',
	    ),
	),
);

?>
