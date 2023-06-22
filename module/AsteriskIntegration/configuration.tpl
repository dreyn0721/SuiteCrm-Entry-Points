<script>
    $.getScript('modules/AsteriskIntegration/configuration.js');
</script>

<div class="moduleTitle asteriskintegration_administration_head_title">
    <h2 class="module-title-text asteriskintegration_administration_head_title_text">
        <a href="index.php?module=Administration&action=index">
            {$MOD_STRINGS.LBL_ADMINISTRATION}
        </a>
        <span>
            {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION}
        </span>
        <span>
            {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_CONFIGURATION}
        </span>
    </h2>
</div>

<div class="asteriskintegration_administration_table_title">
    {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_SERVER_LIST}
</div>
<div class="asteriskintegration_administration_list_column_title">
    <span style="width: 11%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_SERVER_NAME}
    </span>
    <span style="width: 09%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_SOCKET_PORT}
    </span>
    <span style="width: 10%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_SERVER_IP}
    </span>
    <span style="width: 08%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_AMI_PORT}
    </span>
    <span style="width: 10%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_AMI_USERNAME}
    </span>
    <span style="width: 11%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_RECORDINGLINK_IP}
    </span>
    <span style="width: 09%; text-align: left">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_RECORDINGLINK_PORT}
    </span>
    <span style="width: 11%">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_SERVICE_TITLE}
    </span>
    <span style="width: 08%">
        {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_PROCESS_ID}
    </span>
    <span style="width: 07%">
        {$APP_STRINGS.LBL_DELETE_BUTTON_TITLE}
    </span>
</div>
<div class="asteriskintegration_administration_list_rows">
    {if $ASTERISK_INTEGRATION_SERVERS_LIST|@count gt 0}
        {foreach from=$ASTERISK_INTEGRATION_SERVERS_LIST key=id item=row}
    <div class="asteriskintegration_administration_list_row">
        <span style="width: 11%; text-align: left">
            {$row.name}
        </span>
        <span style="width: 09%; text-align: left">
            {$row.socket_port}
        </span>
        <span style="width: 10%; text-align: left">
            {$row.server_ip}
        </span>
        <span style="width: 10%; text-align: left">
            {$row.ami_username}
        </span>
        <span style="width: 08%; text-align: left">
            {$row.ami_port}
        </span>
        <span style="width: 11%; text-align: left">
            {$row.recordinglink_ip}
        </span>
        <span style="width: 09%; text-align: left">
            {$row.recordinglink_port}
        </span>
        <span style="width: 11%">
            {if $row.system_pid neq ""}
            <input class="button" name="restart" onclick="asteriskintegration_service_restart('{$id}');" type="button" value="{$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_RESTART_BUTTON_LABEL}"/>
            {else}
            <input class="button" name="restart" onclick="asteriskintegration_service_start('{$id}');" type="button" value="{$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_START_BUTTON_LABEL}"/>
            {/if}
        </span>
        <span style="width: 08%">
            {if $row.system_pid neq ""}
                {$row.system_pid}
            {else}
                -
            {/if}
        </span>
        <span style="width: 07%">
            <input accesskey="{$APP_STRINGS.LBL_DELETE_BUTTON_KEY}" class="button" name="delete" onclick="asteriskintegration_delete_server('{$id}');" title="{$APP_STRINGS.LBL_DELETE_BUTTON_TITLE}" type="button" value="{$APP_STRINGS.LBL_DELETE_BUTTON_LABEL}"/>
        </span>
    </div>
    {/foreach}
    {else}
    <div class="asteriskintegration_administration_list_no_records">
        No results found.
    </div>
    {/if}
</div>

<br/>

<div class="asteriskintegration_administration_table_title">
    {$MOD_STRINGS.LBL_ASTERISK_INTEGRATION_ADD_SERVER}
</div>
<form action="" autocomplete="false" method="POST" name="AsteriskIntegrationServers" onsubmit="return validate_asteriskintegration_check_form();">
    <div class="asteriskintegration_administration_configuration_form">
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                Name
            </span>
            <span>
                <input id="server_name" name="server_name" onblur="return validate_asteriskintegration_server_name(this.value);" type="text" value=""/>
            </span>
            <span id="error_asteriskintegration_server_name">
                Please Enter Server Name
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                Socket Port
            </span>
            <span>
                <input id="socket_port" name="socket_port" onblur="return validate_asteriskintegration_socket_port(this.value);" type="text" value="5188"/>
            </span>
            <span id="error_asteriskintegration_socket_port">
                Please Enter Socket Port
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                Server IP
            </span>
            <span>
                <input id="server_ip" name="server_ip" onblur="return validate_asteriskintegration_server_ip(this.value);" type="text" value=""/>
            </span>
            <span id="error_asteriskintegration_server_ip">
                Please Enter Server IP
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                AMI Port
            </span>
            <span>
                <input id="ami_port" name="ami_port" onblur="return validate_asteriskintegration_server_field(this.name, this.value);" type="text" value="5038"/>
            </span>
            <span id="error_asteriskintegration_ami_port">
                Please Enter AMI Port
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                AMI Username
            </span>
            <span>
                <input autocomplete="false" id="ami_username" name="ami_username" onblur="return validate_asteriskintegration_server_field(this.name, this.value);" type="text" value="admin"/>
            </span>
            <span id="error_asteriskintegration_ami_username">
                Please Enter AMI Username
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                AMI Secret
            </span>
            <span>
                <input .="" autocomplete="false" id="ami_secret" name="ami_secret" onblur="return validate_asteriskintegration_server_field(this.name, this.value);" type="text" value="">
                </input>
            </span>
            <span id="error_asteriskintegration_ami_secret">
                Please Enter AMI Secret
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                Recordinglink IP
            </span>
            <span>
                <input id="recordinglink_ip" name="recordinglink_ip" onblur="return validate_asteriskintegration_server_field(this.name, this.value);" type="text" value=""/>
            </span>
            <span id="error_asteriskintegration_recordinglink_ip">
                Please Enter IP For Recording Link
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
                Recordinglink Port
            </span>
            <span>
                <input id="recordinglink_port" name="recordinglink_port" onblur="return validate_asteriskintegration_server_field(this.name, this.value);" type="text" value=""/>
            </span>
            <span id="error_asteriskintegration_recordinglink_port">
                Please Enter Port For Recording Link
            </span>
        </div>
        <div class="asteriskintegration_administration_configuration_form_row">
            <span>
            </span>
            <span>
                <input class="button" name="save_asteriskintegration_settings" type="submit" value="{$APP_STRINGS.LBL_SAVE_BUTTON_LABEL}"/>
            </span>
            <span>
            </span>
        </div>
    </div>
</form>
