<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Crm\Service;

class SmartProcessTableComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		if (!Loader::includeModule('crm')) {
			ShowError("Модуль CRM не установлен.");
			return;
		}

		// Получаем ID смарт-процесса из параметров
		$entityTypeId = $this->arParams['ENTITY_TYPE_ID'] ?? 0;

		// Проверяем наличие фабрики для смарт-процесса
		$factory = Service\Container::getInstance()->getFactory($entityTypeId);
		if (!$factory) {
			ShowError("Смарт-процесс с ID {$entityTypeId} не найден.");
			return;
		}

		// Получаем элементы смарт-процесса
		$items = $factory->getItems([
			'select' => ['ID', 'TITLE', 'CREATED_TIME'], // Поля для выборки
			'filter' => [], // Условия фильтрации
			'order' => ['ID' => 'ASC'], // Сортировка
		]);


		$this->arResult['ITEMS'] = [];
		foreach ($items as $item) {
			$this->arResult['ITEMS'][] = [
				'ID' => $item->getId(),
				'NAME' => $item->getTitle(),
				'CONTRACT_NUMBER' => '',
				'ORDER_NUMBER' => '',
				'START_DATE' => '',
				'END_DATE' => '',
			];
		}

		$this->includeComponentTemplate();
	}
}
