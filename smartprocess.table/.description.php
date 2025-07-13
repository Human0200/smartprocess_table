<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
	"NAME" => "Smart Process Table", // Название компонента
	"DESCRIPTION" => "Компонент для вывода элементов смарт-процесса в таблицу с возможностью добавления записей",
	"COMPLEX" => "N", // Не сложный компонент
	"PATH" => array(
		"ID" => "custom",
		"NAME" => "Пользовательские компоненты",
	),
	"CACHE_PATH" => "N", // Разрешить кэширование
);