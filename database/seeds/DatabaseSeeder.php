<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Mark Montinola', 'email' => 'mark@me.com', 'type' => 'admin', 'password' => '$2y$10$O9V9d2P6Ju9xphUq7aEEWe1HsDIMhNd9rCxryPag5qIH/7XrffOYe'],
        ];
        DB::table('users')->insert($data);

        $data = [
            ['id' => 'FAV',  'description' => 'Favorites',                   'order' => 10100,    'icon' => 'fas fa-star',             'remarks' => ''],
            ['id' => 'SYS',  'description' => 'System Development',          'order' => 10200,    'icon' => 'fas fa-code',             'remarks' => ''],
            ['id' => 'ADM',  'description' => 'Administration',              'order' => 10300,    'icon' => 'fas fa-key',              'remarks' => ''],
            ['id' => 'EM',   'description' => 'Employee Manangement',        'order' => 10400,    'icon' => 'fas fa-user',             'remarks' => ''],
            ['id' => 'IM',   'description' => 'Inventory Management',        'order' => 10500,    'icon' => 'fas fa-truck',            'remarks' => ''],
            ['id' => 'AM',   'description' => 'Asset Management',            'order' => 10600,    'icon' => 'fas fa-dolly-flatbed',    'remarks' => ''],
            ['id' => 'GL',   'description' => 'General Ledger',              'order' => 10700,    'icon' => 'fas fa-columns',          'remarks' => ''],
        ];
        DB::table('kram_module')->insert($data);

        $data = [
            ['id' => 'SYS',     'description' => 'System',          'order' => 10000,    'icon' => 'fas fa-cog'         ],
            ['id' => 'MAI',     'description' => 'Maintenance',     'order' => 10100,    'icon' => 'fas fa-wrench'      ],
            ['id' => 'PRO',     'description' => 'Processing',      'order' => 10200,    'icon' => 'fas fa-sync-alt'    ],
            ['id' => 'TRA',     'description' => 'Transaction',     'order' => 10300,    'icon' => 'fas fa-file'        ],
            ['id' => 'REP',     'description' => 'Report',          'order' => 10300,    'icon' => 'fas fa-chart-bar'   ],
            ['id' => 'ANA',     'description' => 'Analytics',       'order' => 10300,    'icon' => 'fas fa-chart-pie'   ],
        ];
        DB::table('kram_category')->insert($data);

        $data = [
            ['id' => 'SYSMAI0001', 'description' => 'Modules',                  'module' => 'SYS',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 10100,    'icon' => '',      'route_vue' => '{}'],
            ['id' => 'SYSMAI0002', 'description' => 'Categories',               'module' => 'SYS',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 10200,    'icon' => '',      'route_vue' => '{}'],
            ['id' => 'SYSMAI0003', 'description' => 'Forms',                    'module' => 'SYS',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 10300,    'icon' => '',      'route_vue' => '{}'],
            ['id' => 'SYSMAI0004', 'description' => 'Form Tables',              'module' => 'SYS',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 10400,    'icon' => '',      'route_vue' => '{}'],
            ['id' => 'SYSMAI0005', 'description' => 'Form Fields',              'module' => 'SYS',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 10500,    'icon' => '',      'route_vue' => '{}'],
            ['id' => 'CMMAI00001', 'description' => 'Item',                     'module' => 'IM',   'category' => 'MAI', 'presentation_style' =>'Card',         'order' => 0,        'icon' => '',      'route_vue' => '{"add":"item_add", "edit":"item_edit", "delete":"item_delete"}'],
            ['id' => 'CMMAI00002', 'description' => 'Unit of Measure',          'module' => 'IM',   'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'CMMAI00003', 'description' => 'Item Category',            'module' => 'IM',   'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'EMMAI00001', 'description' => 'Employee',                 'module' => 'EM',   'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'ADMMAI0001', 'description' => 'Users',                    'module' => 'ADM',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'ADMMAI0002', 'description' => 'Users Access',             'module' => 'ADM',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'ADMMAI0003', 'description' => 'Settings',                 'module' => 'ADM',  'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'IMMAI00001', 'description' => 'Supplier',                 'module' => 'IM',   'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
            ['id' => 'GLMAI00001', 'description' => 'Currency',                 'module' => 'GL',   'category' => 'MAI', 'presentation_style' =>'Tab',          'order' => 0,        'icon' => '',      'route_vue' => '{}'],
        ];
        DB::table('kram_form')->insert($data);

        $data = [
            ['form_id' => 'SYSMAI0001', 'kdw' => 'KDW01', 'table' => 'kram_module',         'description' => 'Modules',            'presentation_style' => 'Freeform'],
            ['form_id' => 'SYSMAI0002', 'kdw' => 'KDW01', 'table' => 'kram_category',       'description' => 'Categories',         'presentation_style' => 'Freeform'],
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'table' => 'kram_form',           'description' => 'Forms',              'presentation_style' => 'Freeform'],
            ['form_id' => 'SYSMAI0004', 'kdw' => 'KDW01', 'table' => 'kram_form_tables',    'description' => 'Form Tables',        'presentation_style' => 'Freeform'],
            ['form_id' => 'SYSMAI0005', 'kdw' => 'KDW01', 'table' => 'kram_form_fields',    'description' => 'Form Fields',        'presentation_style' => 'Freeform'],
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'table' => 'item',                'description' => 'Item',               'presentation_style' => 'Freeform'],
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW02', 'table' => 'item_kit',            'description' => 'Item Kit',           'presentation_style' => 'Tabular'],
            ['form_id' => 'CMMAI00002', 'kdw' => 'KDW01', 'table' => 'uom',                 'description' => 'Unit of Measure',    'presentation_style' => 'Freeform'],
            ['form_id' => 'CMMAI00003', 'kdw' => 'KDW01', 'table' => 'item_category',       'description' => 'Item Category',      'presentation_style' => 'Freeform'],
            ['form_id' => 'EMMAI00001', 'kdw' => 'KDW01', 'table' => 'employees',           'description' => 'Employee',           'presentation_style' => 'Freeform'],
            ['form_id' => 'ADMMAI0001', 'kdw' => 'KDW01', 'table' => 'users',               'description' => 'Users',              'presentation_style' => 'Freeform'],
            ['form_id' => 'ADMMAI0002', 'kdw' => 'KDW01', 'table' => 'users_access',        'description' => 'Users Access',       'presentation_style' => 'Freeform'],
            ['form_id' => 'ADMMAI0003', 'kdw' => 'KDW01', 'table' => 'settings',            'description' => 'Settings',           'presentation_style' => 'Freeform'],
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'table' => 'supplier',            'description' => 'Supplier',           'presentation_style' => 'Freeform'],
            ['form_id' => 'GLMAI00001', 'kdw' => 'KDW01', 'table' => 'currency',            'description' => 'Currency',           'presentation_style' => 'Freeform'],
        ];
        DB::table('kram_form_tables')->insert($data);

        $data = [
            ['form_id' => 'SYSMAI0001', 'kdw' => 'KDW01', 'column_name' => 'active',                'icon' => null,       'field_properties_fm' => '{"optionID":"YesNo"}',                                     'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'SYSMAI0001', 'kdw' => 'KDW01', 'column_name' => 'order',                 'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'module',                'icon' => null,       'field_properties_fm' => '{"optionID":"KramModule"}',                                'field_properties' => '{"element":"multiselect", "optionID":"KramModule"}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'category',              'icon' => null,       'field_properties_fm' => '{"optionID":"KramCategory"}',                              'field_properties' => '{"element":"multiselect", "optionID":"KramCategory"}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'presentation_style',    'icon' => null,       'field_properties_fm' => '{"optionID":"FormPresentationStyle"}',                     'field_properties' => '{"element":"multiselect", "optionID":"FormPresentationStyle"}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'active',                'icon' => null,       'field_properties_fm' => '{"optionID":"YesNo"}',                                     'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'order',                 'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'has_parent',            'icon' => null,       'field_properties_fm' => '{"class":"d-none", "optionID":"YesNo"}',                   'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'parent_form_id',        'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'has_child',             'icon' => null,       'field_properties_fm' => '{"class":"d-none", "optionID":"YesNo"}',                   'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'child_form_id',         'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'icon',                  'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'menu',                  'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0003', 'kdw' => 'KDW01', 'column_name' => 'remarks',               'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'SYSMAI0004', 'kdw' => 'KDW01', 'column_name' => 'form_id',               'icon' => null,       'field_properties_fm' => '{"optionID":"FormID"}',                                    'field_properties' => '{"element":"multiselect", "optionID":"FormID", "customLabel":true}'], 
            ['form_id' => 'SYSMAI0004', 'kdw' => 'KDW01', 'column_name' => 'kdw',                   'icon' => null,       'field_properties_fm' => '{"optionID":"KramKdw"}',                                   'field_properties' => '{"element":"multiselect", "optionID":"KramKdw"}'], 
            ['form_id' => 'SYSMAI0004', 'kdw' => 'KDW01', 'column_name' => 'table',                 'icon' => null,       'field_properties_fm' => '{"optionID":"Table"}',                                     'field_properties' => '{"element":"multiselect", "optionID":"Table"}'], 
            ['form_id' => 'SYSMAI0004', 'kdw' => 'KDW01', 'column_name' => 'type',                  'icon' => null,       'field_properties_fm' => '{"optionID":"KramKdwType"}',                               'field_properties' => '{"element":"multiselect", "optionID":"KramKdwType"}'], 
            ['form_id' => 'SYSMAI0004', 'kdw' => 'KDW01', 'column_name' => 'presentation_style',    'icon' => null,       'field_properties_fm' => '{"optionID":"PresentationStyle"}',                         'field_properties' => '{"element":"multiselect", "optionID":"PresentationStyle"}'], 
            ['form_id' => 'SYSMAI0005', 'kdw' => 'KDW01', 'column_name' => 'form_id',               'icon' => null,       'field_properties_fm' => '{"optionID":"FormID"}',                                    'field_properties' => '{"element":"multiselect", "optionID":"FormID", "customLabel":true}'], 
            ['form_id' => 'SYSMAI0005', 'kdw' => 'KDW01', 'column_name' => 'kdw',                   'icon' => null,       'field_properties_fm' => '{"optionID":"KramKdw"}',                                   'field_properties' => '{"element":"multiselect", "optionID":"KramKdw"}'], 
            ['form_id' => 'SYSMAI0005', 'kdw' => 'KDW01', 'column_name' => 'field_properties',      'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{"element":"input", "inputType":"json"}'], 
            ['form_id' => 'SYSMAI0005', 'kdw' => 'KDW01', 'column_name' => 'field_properties_fm',   'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{"element":"input", "inputType":"json"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'photo',                 'icon' => null,       'field_properties_fm' => '{"inputType":"file", "class":"text-center"}',              'field_properties' => '{"element":"input", "inputType":"file"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'category',              'icon' => null,       'field_properties_fm' => '{"optionID":"ItemCategory"}',                              'field_properties' => '{"element":"multiselect", "optionID":"ItemCategory"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'uom',                   'icon' => null,       'field_properties_fm' => '{"optionID":"UoM"}',                                       'field_properties' => '{"element":"multiselect", "optionID":"UoM"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'priority',              'icon' => null,       'field_properties_fm' => '{"class":"d-none", "optionID":"YesNo"}',                   'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'active',                'icon' => null,       'field_properties_fm' => '{"class":"d-none", "optionID":"YesNo"}',                   'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'inventoriable',         'icon' => null,       'field_properties_fm' => '{"class":"d-none", "optionID":"YesNo"}',                   'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'kit',                   'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'min_inv_qty',           'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'max_inv_qty',           'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'remarks',               'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW02', 'column_name' => 'item_kit_id',           'icon' => null,       'field_properties_fm' => '{"optionID":"ItemKit"}',                                   'field_properties' => '{"element":"multiselect", "optionID":"ItemKit", "objectField":"item_kit_id.value", "label":"Item Kit Id"}'], 
            ['form_id' => 'CMMAI00001', 'kdw' => 'KDW02', 'column_name' => 'uom',                   'icon' => null,       'field_properties_fm' => '{"optionID":"UoM"}',                                       'field_properties' => '{"element":"multiselect", "optionID":"UoM", "objectField":"uom.value", "label":"Uom"}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'address',               'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'website',               'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'tin_number',            'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'currency_id',           'icon' => null,       'field_properties_fm' => '{"class":"d-none", "optionID":"Currency"}',                'field_properties' => '{"element":"multiselect", "optionID":"Currency"}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'active',                'icon' => null,       'field_properties_fm' => '{"optionID":"YesNo"}',                                     'field_properties' => '{"element":"multiselect", "optionID":"YesNo"}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'credit_term',           'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'tax_code',              'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'tax_inclusive',         'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'ship_via_id',           'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'acct_id',               'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'acct_id_bulk',          'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'], 
            ['form_id' => 'IMMAI00001', 'kdw' => 'KDW01', 'column_name' => 'acct_id_ir',            'icon' => null,       'field_properties_fm' => '{"class":"d-none"}',                                       'field_properties' => '{}'],
        ];
        DB::table('kram_form_fields')->insert($data);

        $dbase = DB::getDatabaseName();
        $data = [
            ['id'   => 'YesNo',                     'sql' => "SELECT 'Y' AS 'key', 'Yes' AS 'value' UNION ALL SELECT 'N' AS 'key', 'No' AS 'value'"],
            ['id'   => 'BlankYesNo',                'sql' => "SELECT '' AS 'key', '' AS 'value' UNION ALL SELECT 'Y' AS 'key', 'Yes' AS 'value' UNION ALL SELECT 'N' AS 'key', 'No' AS 'value'"],
            ['id'   => 'KramModule',                'sql' => "SELECT id AS 'key', description AS 'value' FROM kram_module"],
            ['id'   => 'KramCategory',              'sql' => "SELECT id AS 'key', description AS 'value' FROM kram_category"],
            ['id'   => 'KramKdw',                   'sql' => "SELECT 'KDW01' AS 'key', 'KDW01' AS 'value' UNION ALL SELECT 'KDW02' AS 'key', 'KDW02' AS 'value' UNION ALL SELECT 'KDW03' AS 'key', 'KDW03' AS 'value' UNION ALL SELECT 'KDW04' AS 'key', 'KDW04' AS 'value' UNION ALL SELECT 'KDW05' AS 'key', 'KDW05' AS 'value'"],
            ['id'   => 'KramKdwType',               'sql' => "SELECT 'FORM' AS 'key', 'Form' AS 'value' UNION ALL SELECT 'TABULAR' AS 'key', 'Tabular' AS 'value'"],
            ['id'   => 'KramDataType',              'sql' => "SELECT 'string' AS 'key', 'String' AS 'value' UNION ALL SELECT 'integer' AS 'key', 'Integer' AS 'value' UNION ALL SELECT 'datetime' AS 'key', 'DateTime' AS 'value'"],
            ['id'   => 'FormID',                    'sql' => "SELECT id AS 'key', description AS 'value' FROM kram_form"],
            ['id'   => 'Table',                     'sql' => "SELECT TABLE_NAME AS 'key', TABLE_NAME AS 'value' FROM information_schema.tables WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = '".$dbase."'"],
            ['id'   => 'UoM',                       'sql' => "SELECT id AS 'key', description AS 'value' FROM uom"],
            ['id'   => 'ItemCategory',              'sql' => "SELECT id AS 'key', description AS 'value' FROM item_category"],
            ['id'   => 'Item',                      'sql' => "SELECT id AS 'key', description AS 'value' FROM item"],
            ['id'   => 'ItemKit',                   'sql' => "SELECT id AS 'key', description AS 'value' FROM item WHERE kit = 'N'"],
            ['id'   => 'Currency',                  'sql' => "SELECT id AS 'key', description AS 'value' FROM currency"],
            ['id'   => 'FormPresentationStyle',     'sql' => "SELECT 'Tab' AS 'key', 'Tab' AS 'value' UNION ALL SELECT 'Card' AS 'key', 'Card' AS 'value'"],
            ['id'   => 'PresentationStyle',         'sql' => "SELECT 'Freeform' AS 'key', 'Freeform' AS 'value' UNION ALL SELECT 'Tabular' AS 'key', 'Tabular' AS 'value'"],
        ];
        DB::table('kram_select_options')->insert($data);
        
        $data = [
            ['id' => '1',   'form_id' => 'ADMMAI0002',    'access' => 'writer',     'permission' => '{"Add":"Y", "Edit":"Y", "Delete":"Y"}'  ],
            ['id' => '1',   'form_id' => 'EMMAI00001',    'access' => 'writer',     'permission' => '{"Add":"N", "Edit":"N", "Delete":"N"}'  ],
        ];
        DB::table('users_access')->insert($data);

        $data = [
            ['last_name' => 'Montinola', 'first_name' => 'Mark',    'middle_name' => 'Flor'     ],
            ['last_name' => 'Montinola', 'first_name' => 'Loren',   'middle_name' => 'Moreno'   ],
        ];
        DB::table('employees')->insert($data);

        $data = [
            ['description' => 'Matcha',                     'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Okinawa',                    'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Hokkaido',                   'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Wintermelon',                'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Banana Cream',               'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Cappuccino Cream',           'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Dark Chocolate Cream',       'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Cookies and Cream',          'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Mocha Cream',                'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Taro Cream',                 'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'Y'],
            ['description' => 'Kit 01',                     'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'N'],
            ['description' => 'Kit 02',                     'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'N'],
            ['description' => 'Kit 03',                     'category' => 'MILK TEAS',    'uom' => 'PCS',   'kit' => 'N'],
        ];
        DB::table('item')->insert($data);

        $data = [
            ['id'   =>  1,    'item_kit_id' => '11',       'uom' => 'PCS',      'quantity' => 2],
            ['id'   =>  1,    'item_kit_id' => '12',       'uom' => 'PCS',      'quantity' => 2],
            ['id'   =>  1,    'item_kit_id' => '13',       'uom' => 'PCS',      'quantity' => 2],
        ];
        DB::table('item_kit')->insert($data);
        
        $data = [
            ['id'   =>  'BAG',    'description' => 'Bag'],
            ['id'   =>  'BAR',    'description' => 'BAR'],
            ['id'   =>  'BKLT',   'description' => 'Booklet'],
            ['id'   =>  'BOX',    'description' => 'Box'],
            ['id'   =>  'BTL',    'description' => 'Bottle'],
            ['id'   =>  'CAN',    'description' => 'Can'],
            ['id'   =>  'CUT',    'description' => 'Cut'],
            ['id'   =>  'DAY',    'description' => 'Day'],
            ['id'   =>  'DOZ',    'description' => 'Dozen'],
            ['id'   =>  'EA',     'description' => 'EA'],
            ['id'   =>  'FT',     'description' => 'Feet'],
            ['id'   =>  'GAL',    'description' => 'Gallon'],
            ['id'   =>  'GRM',    'description' => 'Grams'],
            ['id'   =>  'GRS',    'description' => 'Gross'],
            ['id'   =>  'HR',     'description' => 'Hour'],
            ['id'   =>  'INCH',   'description' => 'Inches'],
            ['id'   =>  'KLS',    'description' => 'Kilos'],
            ['id'   =>  'KM',     'description' => 'Kilometers'],
            ['id'   =>  'LGHTS',  'description' => 'Lenght'],
            ['id'   =>  'LMS',    'description' => 'Linear Meter'],
            ['id'   =>  'LOT',    'description' => 'Lot'],
            ['id'   =>  'LTRS',   'description' => 'Liters'],
            ['id'   =>  'M2',     'description' => 'M2'],
            ['id'   =>  'M3',     'description' => 'M3'],
            ['id'   =>  'MHR',    'description' => 'MHR'],
            ['id'   =>  'MI',     'description' => 'Miles'],
            ['id'   =>  'ML',     'description' => 'Milliliter'],
            ['id'   =>  'MM',     'description' => 'Milimeter'],
            ['id'   =>  'MONTH',  'description' => 'Month'],
            ['id'   =>  'MOS',    'description' => 'Monthly'],
            ['id'   =>  'MTRS',   'description' => 'Meters'],
            ['id'   =>  'PAIL',   'description' => 'Pail'],
            ['id'   =>  'PAIRS',  'description' => 'Pairs'],
            ['id'   =>  'PCK',    'description' => 'Pack'],
            ['id'   =>  'PCKG',   'description' => 'Package'],
            ['id'   =>  'PCS',    'description' => 'Pieces'],
            ['id'   =>  'PD',     'description' => 'Pads'],
            ['id'   =>  'PINT',   'description' => 'Pint'],
            ['id'   =>  'QRTZ',   'description' => 'Quartz'],
            ['id'   =>  'REAMS',  'description' => 'Ream'],
            ['id'   =>  'ROLL',   'description' => 'Roll'],
            ['id'   =>  'SACKS',  'description' => 'Sacks'],
            ['id'   =>  'SETS',   'description' => 'Sets'],
            ['id'   =>  'SHT',    'description' => 'Sheet'],
            ['id'   =>  'SPL',    'description' => 'Spool'],
            ['id'   =>  'SQFT',   'description' => 'Square Feet'],
            ['id'   =>  'TIN',    'description' => 'Tin'],
            ['id'   =>  'TUBE',   'description' => 'Tube'],
            ['id'   =>  'UNIT',   'description' => 'Unit'],
            ['id'   =>  'YEAR',   'description' => 'Year'],
            ['id'   =>  'YRDS',   'description' => 'Yards'],
        ];
        DB::table('uom')->insert($data);

        $data = [
            ['id'   =>  'PHP',    'description' => 'Philippine Peso'],
            ['id'   =>  'SAR',    'description' => 'Saudi Riyal'],
            ['id'   =>  'USD',    'description' => 'US Dollar'],
        ];
        DB::table('currency')->insert($data);
    }
}
