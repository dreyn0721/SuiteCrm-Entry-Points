<?php

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

require_once 'include/Dashlets/DashletGeneric.php';
require_once 'modules/AsteriskIntegration/AsteriskIntegration.php';

class AsteriskIntegrationDashlet extends DashletGeneric
{
    public function __construct($id, $def = null)
    {
        global $current_user, $app_strings;
        require 'modules/AsteriskIntegration/metadata/dashletviewdefs.php';

        parent::__construct($id, $def);

        if (empty($def['title']))
        {
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'AsteriskIntegration');
        }

        $this->searchFields = $dashletData['AsteriskIntegrationDashlet']['searchFields'];
        $this->columns = $dashletData['AsteriskIntegrationDashlet']['columns'];

        $this->seedBean = new AsteriskIntegration();
    }
}
