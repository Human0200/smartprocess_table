<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\UI\Extension;

Extension::load("ui.grid");

global $APPLICATION;

$currentUrl = $APPLICATION->GetCurPageParam();

$parsedUrl = parse_url($currentUrl);

// Настройки колонок таблицы
$columns = [
	['id' => 'ID', 'name' => '#', 'default' => true],
	['id' => 'NAME', 'name' => 'Наименование', 'default' => true, 'sort' => 'NAME'],
	['id' => 'CONTRACT_NUMBER', 'name' => '№ договора', 'default' => true],
	['id' => 'ORDER_NUMBER', 'name' => '№ заказа (соглашения)', 'default' => true],
	['id' => 'START_DATE', 'name' => 'Дата начала', 'default' => true],
	['id' => 'END_DATE', 'name' => 'Дата окончания', 'default' => true],
];

$rows = [];
$contractsEntityTypeId = $arResult['CONTRACTS_ENTITY_TYPE_ID'];
$contractorsEntityTypeId = $arResult['CONTRACTORS_ENTITY_TYPE_ID'];
foreach ($arResult['ITEMS'] as $item) {
	$rows[] = [
		'id' => $item['ID'],
		'columns' => [
			'ID' => $item['id'],
			'NAME' => '<a href="/crm/type/' . $contractorsEntityTypeId . '/details/' . $item['contractor_id'] . '/" target="_blank">' . htmlspecialchars($item['contractor_name']) . '</a>',
			'CONTRACT_NUMBER' => '<a href="/crm/type/' . $contractsEntityTypeId . '/details/' . $item['id'] . '/" target="_blank">' . htmlspecialchars($item['title']) . '</a>',
			'ORDER_NUMBER' => htmlspecialchars($item['order_number'] ?? '-'),
			'START_DATE' => htmlspecialchars($item['start_date'] ?? '-'),
			'END_DATE' => htmlspecialchars($item['end_date'] ?? '-'),

		],
	];
}


// Настройки грид-таблицы
$gridParams = [
	'GRID_ID' => 'custom_smartprocess_grid',
	'COLUMNS' => $columns,
	'ROWS' => $rows,
	'AJAX_MODE' => 'Y',
	'AJAX_OPTION_JUMP' => 'N',
	'AJAX_OPTION_STYLE' => 'N',
	'SHOW_ROW_CHECKBOXES' => false,
	'SHOW_CHECK_ALL_CHECKBOXES' => false,
	'SHOW_GRID_SETTINGS_MENU' => true,
	'SHOW_NAVIGATION_PANEL' => false,
	'SHOW_PAGINATION' => false,
	'SHOW_TOTAL_COUNTER' => true,
	'SHOW_PAGESIZE' => false,
	'SHOW_ACTION_PANEL' => false,
	'ALLOW_SORT' => false,
	'ALLOW_COLUMNS_SORT' => false,
	'ALLOW_COLUMNS_RESIZE' => true,
	'ALLOW_HORIZONTAL_SCROLL' => false,
	'AJAX_ID' => CAjax::GetComponentID('bitrix:main.ui.grid', '.default', ''),
];
?>

<div class="contractors">
    <div class="contactors__inner">
        <h3 class="contractors__title ui-title-3">Подрядчики</h3>
        <div class="contractors__table">
			<?php
			$APPLICATION->IncludeComponent(
				'bitrix:main.ui.grid',
				'',
				$gridParams
			);

			?>


        </div>
    </div>

</div>



