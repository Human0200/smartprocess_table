<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
	'PARAMETERS' => [
		'CONTRACTS_ENTITY_TYPE_ID' => [
			'PARENT' => 'BASE',
			'NAME' => 'ID Смарт-процесса договоров',
			'TYPE' => 'STRING',
			'DEFAULT' => '',
		],
		'CONTRACTORS_ENTITY_TYPE_ID' => [
			'PARENT' => 'BASE',
			'NAME' => 'ID Смарт-процесса подрядчиков',
			'TYPE' => 'STRING',
			'DEFAULT' => '',
		],
		'PROJECT_ID' => [
			'PARENT' => 'BASE',
			'NAME' => 'ID Проекта',
			'TYPE' => 'STRING',
			'DEFAULT' => '',
		],
	],
];
?>
