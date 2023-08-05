<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
$relationships = array (
  'med01_insured_modified_user' => 
  array (
    'id' => 'c5acbc99-d500-bcae-bd4c-6488724eac81',
    'relationship_name' => 'med01_insured_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_Insured',
    'rhs_table' => 'med01_insured',
    'rhs_key' => 'modified_user_id',
    'join_table' => NULL,
    'join_key_lhs' => NULL,
    'join_key_rhs' => NULL,
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'med01_insured_created_by' => 
  array (
    'id' => 'c5c4686a-4308-8fa6-5a80-64887282b73d',
    'relationship_name' => 'med01_insured_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_Insured',
    'rhs_table' => 'med01_insured',
    'rhs_key' => 'created_by',
    'join_table' => NULL,
    'join_key_lhs' => NULL,
    'join_key_rhs' => NULL,
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'med01_insured_assigned_user' => 
  array (
    'id' => 'c5dcf5e1-3cc2-b302-6a4d-648872bb91b9',
    'relationship_name' => 'med01_insured_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_Insured',
    'rhs_table' => 'med01_insured',
    'rhs_key' => 'assigned_user_id',
    'join_table' => NULL,
    'join_key_lhs' => NULL,
    'join_key_rhs' => NULL,
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'securitygroups_med01_insured' => 
  array (
    'id' => 'c5f4dc16-67dc-7d91-d1fc-6488727d18c3',
    'relationship_name' => 'securitygroups_med01_insured',
    'lhs_module' => 'SecurityGroups',
    'lhs_table' => 'securitygroups',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_Insured',
    'rhs_table' => 'med01_insured',
    'rhs_key' => 'id',
    'join_table' => 'securitygroups_records',
    'join_key_lhs' => 'securitygroup_id',
    'join_key_rhs' => 'record_id',
    'relationship_type' => 'many-to-many',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'Med01_Insured',
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'med01_insured_med01_spend' => 
  array (
    'id' => 'e39e3656-dac2-0732-9394-648872322ef2',
    'relationship_name' => 'med01_insured_med01_spend',
    'lhs_module' => 'Med01_Insured',
    'lhs_table' => 'med01_insured',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_Spend',
    'rhs_table' => 'med01_spend',
    'rhs_key' => 'id',
    'join_table' => 'med01_insured_med01_spend_c',
    'join_key_lhs' => 'med01_insured_med01_spendmed01_insured_ida',
    'join_key_rhs' => 'med01_insured_med01_spendmed01_spend_idb',
    'relationship_type' => 'one-to-one',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => true,
  ),
  'med01_insured_med01_policy' => 
  array (
    'id' => 'e402c6b0-474d-0a4c-5e16-648872da90de',
    'relationship_name' => 'med01_insured_med01_policy',
    'lhs_module' => 'Med01_Insured',
    'lhs_table' => 'med01_insured',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_Policy',
    'rhs_table' => 'med01_policy',
    'rhs_key' => 'id',
    'join_table' => 'med01_insured_med01_policy_c',
    'join_key_lhs' => 'med01_insured_med01_policymed01_insured_ida',
    'join_key_rhs' => 'med01_insured_med01_policymed01_policy_idb',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => true,
  ),
  'med01_insured_med01_cscases' => 
  array (
    'id' => 'e43574b9-a520-15e9-d6a0-6488721968a1',
    'relationship_name' => 'med01_insured_med01_cscases',
    'lhs_module' => 'Med01_Insured',
    'lhs_table' => 'med01_insured',
    'lhs_key' => 'id',
    'rhs_module' => 'Med01_CSCases',
    'rhs_table' => 'med01_cscases',
    'rhs_key' => 'id',
    'join_table' => 'med01_insured_med01_cscases_c',
    'join_key_lhs' => 'med01_insured_med01_cscasesmed01_insured_ida',
    'join_key_rhs' => 'med01_insured_med01_cscasesmed01_cscases_idb',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => true,
  ),
  'med01_insured_asteriskintegration_1' => 
  array (
    'rhs_label' => 'Asterisk Integration',
    'lhs_label' => 'Insured',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'Med01_Insured',
    'rhs_module' => 'AsteriskIntegration',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'med01_insured_asteriskintegration_1',
  ),
);