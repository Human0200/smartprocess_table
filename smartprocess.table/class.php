<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;

class SmartProcessTableComponent extends CBitrixComponent
{

	private array $fieldsMap = [
		'id' => 'ID',
		'title' => 'TITLE',
		'contractor_id' => 'PARENT_ID_1042',
		'order_number' => 'UF_CRM_25_1735032691207',
		'start_date' => 'UF_CRM_25_1735032547279',
		'end_date' => 'UF_CRM_25_1735032559559'
	];

	public function executeComponent()
	{
		if (!Loader::includeModule('crm')) {
			ShowError("Модуль CRM не установлен.");
			return;
		}

		$contractsEntityTypeId = $this->arParams['CONTRACTS_ENTITY_TYPE_ID'] ?? 1032;
		$contractorsEntityTypeId = $this->arParams['CONTRACTORS_ENTITY_TYPE_ID'] ?? 1042;


		$contractsFactory = Container::getInstance()->getFactory($contractsEntityTypeId);
		$contractorsFactory = Container::getInstance()->getFactory($contractorsEntityTypeId);

		if (!$contractsFactory) {
			ShowError("Смарт-процесс не найден.");
			return;
		}

		$contracts = $contractsFactory->getItems([
			'select' => array_values($this->fieldsMap),
			'filter' => [
				'PARENT_ID_163' => $this->arParams['PROJECT_ID'],
			],
			'order' => ['ID' => 'ASC'],
		]);

		$items = [];

foreach ($contracts as $contract) {
    $contractorId = $contract->get($this->fieldsMap['contractor_id']);

    $contractorName = 'Не указан';
    if ($contractorId !== null) {
        $contractor = $contractorsFactory->getItem($contractorId);
        if ($contractor) {
            $contractorName = $contractor->getTitle();
        } else {
            AddMessage2Log("Contractor not found for ID: " . $contractorId);
        }
    }

    $item = [];
    foreach ($this->fieldsMap as $key => $field) {
        $item[$key] = $contract[$field];
    }

    $item['contractor_name'] = $contractorName;

    $items[] = $item;
}


		$this->arResult['CONTRACTS_ENTITY_TYPE_ID'] = $this->arParams['CONTRACTS_ENTITY_TYPE_ID'];
		$this->arResult['CONTRACTORS_ENTITY_TYPE_ID'] = $this->arParams['CONTRACTORS_ENTITY_TYPE_ID'];
		$this->arResult['PROJECT_ID'] = $this->arParams['PROJECT_ID'];
		$this->arResult['ITEMS'] = $items;
		$this->includeComponentTemplate();
	}
}

?>
