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
  'asteriskintegration_modified_user' => 
  array (
    'id' => '26892460-5009-0f7f-411d-6484effd51d4',
    'relationship_name' => 'asteriskintegration_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
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
    'from_studio' => false,
  ),
  'asteriskintegration_created_by' => 
  array (
    'id' => '26a263b4-fcf5-5d29-ae18-6484ef40485e',
    'relationship_name' => 'asteriskintegration_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
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
    'from_studio' => false,
  ),
  'asteriskintegration_assigned_user' => 
  array (
    'id' => '26bb27bf-c71a-28f4-a2e8-6484ef23f0f9',
    'relationship_name' => 'asteriskintegration_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
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
    'from_studio' => false,
  ),
  'securitygroups_asteriskintegration' => 
  array (
    'id' => '26d309c4-f6cf-0a47-2013-6484ef11acff',
    'relationship_name' => 'securitygroups_asteriskintegration',
    'lhs_module' => 'SecurityGroups',
    'lhs_table' => 'securitygroups',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
    'rhs_key' => 'id',
    'join_table' => 'securitygroups_records',
    'join_key_lhs' => 'securitygroup_id',
    'join_key_rhs' => 'record_id',
    'relationship_type' => 'many-to-many',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'AsteriskIntegration',
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'asteriskintegration_accounts' => 
  array (
    'id' => '32a95941-3de2-ac14-1253-6484ef1f7ede',
    'relationship_name' => 'asteriskintegration_accounts',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
    'rhs_key' => 'id',
    'join_table' => 'asteriskintegration_accounts',
    'join_key_lhs' => 'asteriskintegration_accountsaccounts_ida',
    'join_key_rhs' => 'asteriskintegration_accountsasteriskintegration_idb',
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
    'from_studio' => false,
  ),
  'ada01_agent_dialer_activity_asteriskintegration_1' => 
  array (
    'id' => '32c22291-d798-ea47-dcba-6484ef0025da',
    'relationship_name' => 'ada01_agent_dialer_activity_asteriskintegration_1',
    'lhs_module' => 'ADA01_Agent_Dialer_Activity',
    'lhs_table' => 'ada01_agent_dialer_activity',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
    'rhs_key' => 'id',
    'join_table' => 'ada01_agent_dialer_activity_asteriskintegration_1_c',
    'join_key_lhs' => 'ada01_agen5c80ctivity_ida',
    'join_key_rhs' => 'ada01_agenb2c0gration_idb',
    'relationship_type' => 'one-to-one',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'from_studio' => true,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'asteriskintegration_contacts' => 
  array (
    'id' => '32da7441-22a9-3f5f-ffe6-6484ef6e4483',
    'relationship_name' => 'asteriskintegration_contacts',
    'lhs_module' => 'Contacts',
    'lhs_table' => 'contacts',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
    'rhs_key' => 'id',
    'join_table' => 'asteriskintegration_contacts',
    'join_key_lhs' => 'asteriskintegration_contactscontacts_ida',
    'join_key_rhs' => 'asteriskintegration_contactsasteriskintegration_idb',
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
    'from_studio' => false,
  ),
  'asteriskintegration_leads' => 
  array (
    'id' => '33232612-2c7d-4483-9c48-6484ef7cf841',
    'relationship_name' => 'asteriskintegration_leads',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'AsteriskIntegration',
    'rhs_table' => 'asteriskintegration',
    'rhs_key' => 'id',
    'join_table' => 'asteriskintegration_leads',
    'join_key_lhs' => 'asteriskintegration_leadsleads_ida',
    'join_key_rhs' => 'asteriskintegration_leadsasteriskintegration_idb',
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
    'from_studio' => false,
  ),
);