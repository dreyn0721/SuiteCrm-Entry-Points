<?php
$module_name = 'Med01_Policy';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL4' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL5' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL6' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL7' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL9' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL10' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL11' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'salesrep',
            'studio' => 'visible',
            'label' => 'LBL_SALESREP',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'fronterrep',
            'studio' => 'visible',
            'label' => 'LBL_FRONTERREP',
          ),
          1 => 
          array (
            'name' => 'datesubmittedtoverification',
            'label' => 'LBL_DATESUBMITTEDTOVERIFICATION',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'enrollmentperiod',
            'label' => 'LBL_ENROLLMENTPERIOD',
          ),
          1 => 
          array (
            'name' => 'sepcode',
            'label' => 'LBL_SEPCODE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'rewritefronter',
            'studio' => 'visible',
            'label' => 'LBL_REWRITEFRONTER',
          ),
          1 => 
          array (
            'name' => 'rewritefrontedto',
            'studio' => 'visible',
            'label' => 'LBL_REWRITEFRONTEDTO',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'sfpersonalcode',
            'label' => 'LBL_SFPERSONALCODE',
          ),
          1 => 
          array (
            'name' => 'enrollmentcode',
            'label' => 'LBL_ENROLLMENTCODE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'vertimeoverride',
            'label' => 'LBL_VERTIMEOVERRIDE',
          ),
          1 => 
          array (
            'name' => 'manualvertimeentry',
            'label' => 'LBL_MANUALVERTIMEENTRY',
          ),
        ),
        6 => 
        array (
          0 => '',
        ),
        7 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'previouscarrier',
            'studio' => 'visible',
            'label' => 'LBL_PREVIOUSCARRIER',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'policynumber',
            'label' => 'LBL_POLICYNUMBER',
          ),
          1 => 
          array (
            'name' => 'aor',
            'studio' => 'visible',
            'label' => 'LBL_AOR',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'verifiedby',
            'studio' => 'visible',
            'label' => 'LBL_VERIFIEDBY',
          ),
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'effectivedate',
            'label' => 'LBL_EFFECTIVEDATE',
          ),
          1 => 
          array (
            'name' => 'premium',
            'label' => 'LBL_PREMIUM',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'appfee',
            'studio' => 'visible',
            'label' => 'LBL_APPFEE',
          ),
          1 => 
          array (
            'name' => 'firstmaplan',
            'studio' => 'visible',
            'label' => 'LBL_FIRSTMAPLAN',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'formularyexceptionneeded',
            'studio' => 'visible',
            'label' => 'LBL_FORMULARYEXCEPTIONNEEDED',
          ),
          1 => 
          array (
            'name' => 'hraconfnumber',
            'label' => 'LBL_HRACONFNUMBER',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'cshracompleteddate',
            'label' => 'LBL_CSHRACOMPLETEDDATE',
          ),
          1 => 
          array (
            'name' => 'cshracompletedby',
            'studio' => 'visible',
            'label' => 'LBL_CSHRACOMPLETEDBY',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'removefromagentportal',
            'label' => 'LBL_REMOVEFROMAGENTPORTAL',
          ),
          1 => '',
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'primarycaredoctorpcp',
            'label' => 'LBL_PRIMARYCAREDOCTORPCP',
          ),
          1 => 
          array (
            'name' => 'pcpid',
            'label' => 'LBL_PCPID',
          ),
        ),
        16 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'narapp',
            'label' => 'LBL_NARAPP',
          ),
        ),
        17 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'narsob',
            'label' => 'LBL_NARSOB',
          ),
        ),
        18 => 
        array (
          0 => 
          array (
            'name' => 'surveyoffered',
            'studio' => 'visible',
            'label' => 'LBL_SURVEYOFFERED',
          ),
          1 => 
          array (
            'name' => 'advocatecallcomplete',
            'label' => 'LBL_ADVOCATECALLCOMPLETE',
          ),
        ),
        19 => 
        array (
          0 => 
          array (
            'name' => 'sunfiredoctormismatch',
            'label' => 'LBL_SUNFIREDOCTORMISMATCH',
          ),
          1 => 
          array (
            'name' => 'advocatecallsentbacktoagent',
            'label' => 'LBL_ADVOCATECALLSENTBACKTOAGENT',
          ),
        ),
        20 => 
        array (
          0 => 
          array (
            'name' => 'advocatecallnotes',
            'studio' => 'visible',
            'label' => 'LBL_ADVOCATECALLNOTES',
          ),
          1 => 
          array (
            'name' => 'advocatecallbackscheduled',
            'label' => 'LBL_ADVOCATECALLBACKSCHEDULED',
          ),
        ),
        21 => 
        array (
          0 => '',
          1 => '',
        ),
        22 => 
        array (
          0 => 
          array (
            'name' => 'med01_insured_med01_policy_name',
          ),
        ),
      ),
      'lbl_editview_panel3' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'missingincorrectmedications',
            'label' => 'LBL_MISSINGINCORRECTMEDICATIONS',
          ),
          1 => 
          array (
            'name' => 'missingdoctor',
            'label' => 'LBL_MISSINGDOCTOR',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'exceptionmarkerror',
            'label' => 'LBL_EXCEPTIONMARKERROR',
          ),
          1 => 
          array (
            'name' => 'piorauthnotnotified',
            'label' => 'LBL_PIORAUTHNOTNOTIFIED',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'missingincorrectaddress',
            'label' => 'LBL_MISSINGINCORRECTADDRESS',
          ),
          1 => 
          array (
            'name' => 'incorrectpersonalinfo',
            'label' => 'LBL_INCORRECTPERSONALINFO',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'missingsecurityquestions',
            'label' => 'LBL_MISSINGSECURITYQUESTIONS',
          ),
          1 => 
          array (
            'name' => 'missingsunfirecode',
            'label' => 'LBL_MISSINGSUNFIRECODE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'agentdataentryissuenotes',
            'studio' => 'visible',
            'label' => 'LBL_AGENTDATAENTRYISSUENOTES',
          ),
          1 => 
          array (
            'name' => 'rewritefrontrep',
            'studio' => 'visible',
            'label' => 'LBL_REWRITEFRONTREP',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'aepassignedagent',
            'studio' => 'visible',
            'label' => 'LBL_AEPASSIGNEDAGENT',
          ),
          1 => 
          array (
            'name' => 'salesto',
            'studio' => 'visible',
            'label' => 'LBL_SALESTO',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'timestod',
            'studio' => 'visible',
            'label' => 'LBL_TIMESTOD',
          ),
          1 => 
          array (
            'name' => 'tonotes',
            'studio' => 'visible',
            'label' => 'LBL_TONOTES',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'applicationnotes',
            'studio' => 'visible',
            'label' => 'LBL_APPLICATIONNOTES',
          ),
          1 => 
          array (
            'name' => 'declinereason',
            'studio' => 'visible',
            'label' => 'LBL_DECLINEREASON',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'cancelreason',
            'studio' => 'visible',
            'label' => 'LBL_CANCELREASON',
          ),
          1 => 
          array (
            'name' => 'declinenotissuedconfirmed',
            'label' => 'LBL_DECLINENOTISSUEDCONFIRMED',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'saveagent',
            'studio' => 'visible',
            'label' => 'LBL_SAVEAGENT',
          ),
          1 => 
          array (
            'name' => 'savedate',
            'label' => 'LBL_SAVEDATE',
          ),
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'applicationacceptedbycarrier',
            'label' => 'LBL_APPLICATIONACCEPTEDBYCARRIER',
          ),
          1 => 
          array (
            'name' => 'futurepaymentdate',
            'label' => 'LBL_FUTUREPAYMENTDATE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'carrierconfirmedmoving',
            'label' => 'LBL_CARRIERCONFIRMEDMOVING',
          ),
          1 => 
          array (
            'name' => 'movingdisenrollmentdate',
            'label' => 'LBL_MOVINGDISENROLLMENTDATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'customerdate',
            'label' => 'LBL_CUSTOMERDATE',
          ),
          1 => 
          array (
            'name' => 'signeddate',
            'label' => 'LBL_SIGNEDDATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'issuedate',
            'label' => 'LBL_ISSUEDATE',
          ),
          1 => 
          array (
            'name' => 'declinedate',
            'label' => 'LBL_DECLINEDATE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'canceldate',
            'label' => 'LBL_CANCELDATE',
          ),
          1 => 
          array (
            'name' => 'receipt',
            'label' => 'LBL_RECEIPT',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'marxcheckdate',
            'label' => 'LBL_MARXCHECKDATE',
          ),
          1 => 
          array (
            'name' => 'marxnewplan',
            'label' => 'LBL_MARXNEWPLAN',
          ),
        ),
      ),
      'lbl_editview_panel5' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'carrierstatus1',
            'label' => 'LBL_CARRIERSTATUS1',
          ),
          1 => 
          array (
            'name' => 'agentrewrite',
            'label' => 'LBL_AGENTREWRITE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'agentasigned',
            'label' => 'LBL_AGENTASIGNED',
          ),
          1 => 
          array (
            'name' => 'cscampaignassigned',
            'label' => 'LBL_CSCAMPAIGNASSIGNED',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'rewrite',
            'label' => 'LBL_REWRITE',
          ),
          1 => 
          array (
            'name' => 'rewritepolicysubmitted',
            'label' => 'LBL_REWRITEPOLICYSUBMITTED',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'welcomeemailsent',
            'label' => 'LBL_WELCOMEEMAILSENT',
          ),
          1 => 
          array (
            'name' => 'welcomecallcomplete',
            'label' => 'LBL_WELCOMECALLCOMPLETE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'welcomeletterreturned',
            'label' => 'LBL_WELCOMELETTERRETURNED',
          ),
          1 => 
          array (
            'name' => 'birthdaycardreturned',
            'label' => 'LBL_BIRTHDAYCARDRETURNED',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'welcomeletterresent',
            'label' => 'LBL_WELCOMELETTERRESENT',
          ),
          1 => 
          array (
            'name' => 'dsnpsepfollowupappt',
            'label' => 'LBL_DSNPSEPFOLLOWUPAPPT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'carrierpolicypacketreceived',
            'label' => 'LBL_CARRIERPOLICYPACKETRECEIVED',
          ),
          1 => 
          array (
            'name' => 'effectivedatecallcomplete',
            'label' => 'LBL_EFFECTIVEDATECALLCOMPLETE',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'initialwellnessvisitscheduled',
            'label' => 'LBL_INITIALWELLNESSVISITSCHEDULED',
          ),
          1 => 
          array (
            'name' => 'day30aftereffectivefollowupcal',
            'label' => 'LBL_DAY30AFTEREFFECTIVEFOLLOWUPCAL',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'day60aftereffectivefollowupcal',
            'label' => 'LBL_DAY60AFTEREFFECTIVEFOLLOWUPCAL',
          ),
          1 => 
          array (
            'name' => 'day90aftereffectivefollowupcal',
            'label' => 'LBL_DAY90AFTEREFFECTIVEFOLLOWUPCAL',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'futureenrollmentperiodcallback',
            'label' => 'LBL_FUTUREENROLLMENTPERIODCALLBACK',
          ),
          1 => 
          array (
            'name' => 'futureenrollmentperiodcbnotes',
            'label' => 'LBL_FUTUREENROLLMENTPERIODCBNOTES',
          ),
        ),
      ),
      'lbl_editview_panel6' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'primarybeneficiary',
            'label' => 'LBL_PRIMARYBENEFICIARY',
          ),
          1 => 
          array (
            'name' => 'primarybeneficiaryrelationship',
            'studio' => 'visible',
            'label' => 'LBL_PRIMARYBENEFICIARYRELATIONSHIP',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'primarybeneficiaryperc',
            'label' => 'LBL_PRIMARYBENEFICIARYPERC',
          ),
          1 => 
          array (
            'name' => 'contingentbeneficiary',
            'label' => 'LBL_CONTINGENTBENEFICIARY',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'contingentbeneficiaryrelations',
            'studio' => 'visible',
            'label' => 'LBL_CONTINGENTBENEFICIARYRELATIONS',
          ),
          1 => 
          array (
            'name' => 'contingentbeneficiaryperc',
            'label' => 'LBL_CONTINGENTBENEFICIARYPERC',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'beneficiarynotes',
            'studio' => 'visible',
            'label' => 'LBL_BENEFICIARYNOTES',
          ),
        ),
      ),
      'lbl_editview_panel7' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'isactive',
            'label' => 'LBL_ISACTIVE',
          ),
          1 => 
          array (
            'name' => 'isdecline',
            'label' => 'LBL_ISDECLINE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'iscancel',
            'label' => 'LBL_ISCANCEL',
          ),
          1 => 
          array (
            'name' => 'commission',
            'label' => 'LBL_COMMISSION',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'payout',
            'label' => 'LBL_PAYOUT',
          ),
          1 => 
          array (
            'name' => 'payrolloverride',
            'label' => 'LBL_PAYROLLOVERRIDE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'reapp',
            'label' => 'LBL_REAPP',
          ),
          1 => 
          array (
            'name' => 'housedeal',
            'label' => 'LBL_HOUSEDEAL',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'vendor',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR',
          ),
          1 => 
          array (
            'name' => 'futurepaydeclinedate',
            'label' => 'LBL_FUTUREPAYDECLINEDATE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'isthisafuturepay',
            'studio' => 'visible',
            'label' => 'LBL_ISTHISAFUTUREPAY',
          ),
          1 => 
          array (
            'name' => 'plannamecode',
            'label' => 'LBL_PLANNAMECODE',
          ),
        ),
      ),
      'lbl_editview_panel9' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'humanapartnerappid',
            'label' => 'LBL_HUMANAPARTNERAPPID',
          ),
          1 => 
          array (
            'name' => 'humanaenrollmentid',
            'label' => 'LBL_HUMANAENROLLMENTID',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'humanapolicyid',
            'label' => 'LBL_HUMANAPOLICYID',
          ),
          1 => 
          array (
            'name' => 'humanasignaturedate',
            'label' => 'LBL_HUMANASIGNATUREDATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'humanaidcard',
            'label' => 'LBL_HUMANAIDCARD',
          ),
          1 => 
          array (
            'name' => 'humanamedicareid',
            'label' => 'LBL_HUMANAMEDICAREID',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'humanafullname',
            'label' => 'LBL_HUMANAFULLNAME',
          ),
          1 => 
          array (
            'name' => 'humanadateofbirth',
            'label' => 'LBL_HUMANADATEOFBIRTH',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'humanaphone',
            'label' => 'LBL_HUMANAPHONE',
          ),
          1 => 
          array (
            'name' => 'humanaemail',
            'label' => 'LBL_HUMANAEMAIL',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'humanaagentsan',
            'label' => 'LBL_HUMANAAGENTSAN',
          ),
          1 => 
          array (
            'name' => 'humanaagentsfullname',
            'studio' => 'visible',
            'label' => 'LBL_HUMANAAGENTSFULLNAME',
          ),
        ),
        6 => 
        array (
          0 => '',
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'humanaproductsplanname',
            'label' => 'LBL_HUMANAPRODUCTSPLANNAME',
          ),
          1 => 
          array (
            'name' => 'humanastatus',
            'studio' => 'visible',
            'label' => 'LBL_HUMANASTATUS',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'applicationsignaturedate',
            'label' => 'LBL_APPLICATIONSIGNATUREDATE',
          ),
          1 => 
          array (
            'name' => 'flagfordatareview',
            'label' => 'LBL_FLAGFORDATAREVIEW',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'durationrange',
            'label' => 'LBL_DURATIONRANGE',
          ),
          1 => 
          array (
            'name' => 'advocatecallcompletedby',
            'studio' => 'visible',
            'label' => 'LBL_ADVOCATECALLCOMPLETEDBY',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'advocatecallincomplete',
            'label' => 'LBL_ADVOCATECALLINCOMPLETE',
          ),
          1 => 
          array (
            'name' => 'sunfire',
            'label' => 'LBL_SUNFIRE',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'dayseffective',
            'label' => 'LBL_DAYSEFFECTIVE',
          ),
          1 => 
          array (
            'name' => 'dataverified',
            'label' => 'LBL_DATAVERIFIED',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'effdatetext',
            'label' => 'LBL_EFFDATETEXT',
          ),
          1 => 
          array (
            'name' => 'dsstatustext',
            'label' => 'LBL_DSSTATUSTEXT',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'isplaced',
            'label' => 'LBL_ISPLACED',
          ),
        ),
      ),
      'lbl_editview_panel10' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'agentfirstname',
            'label' => 'LBL_AGENTFIRSTNAME',
          ),
          1 => 
          array (
            'name' => 'testver',
            'label' => 'LBL_TESTVER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'highrisk',
            'label' => 'LBL_HIGHRISK',
          ),
          1 => 
          array (
            'name' => 'qanumber',
            'label' => 'LBL_QANUMBER',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'pointagram',
            'label' => 'LBL_POINTAGRAM',
          ),
          1 => 
          array (
            'name' => 'lun',
            'label' => 'LBL_LUN',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'partdendoflastplanyear',
            'label' => 'LBL_PARTDENDOFLASTPLANYEAR',
          ),
          1 => 
          array (
            'name' => 'partdinthisplanyear',
            'label' => 'LBL_PARTDINTHISPLANYEAR',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'nopreviousmedicareadvorpartdpl',
            'label' => 'LBL_NOPREVIOUSMEDICAREADVORPARTDPL',
          ),
          1 => 
          array (
            'name' => 'agentcommission',
            'label' => 'LBL_AGENTCOMMISSION',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'cancellifespan',
            'label' => 'LBL_CANCELLIFESPAN',
          ),
          1 => 
          array (
            'name' => 'activeduration',
            'label' => 'LBL_ACTIVEDURATION',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'isnotissuedcxl',
            'label' => 'LBL_ISNOTISSUEDCXL',
          ),
          1 => 
          array (
            'name' => 'plandurationcalc',
            'label' => 'LBL_PLANDURATIONCALC',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'isendofquarteractive',
            'label' => 'LBL_ISENDOFQUARTERACTIVE',
          ),
          1 => 
          array (
            'name' => 'effectivepolicyquarter',
            'label' => 'LBL_EFFECTIVEPOLICYQUARTER',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'welcomecallmade',
            'label' => 'LBL_WELCOMECALLMADE',
          ),
          1 => 
          array (
            'name' => 'itissuewithwelcomecall',
            'label' => 'LBL_ITISSUEWITHWELCOMECALL',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'q1count',
            'label' => 'LBL_Q1COUNT',
          ),
          1 => '',
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'ismedicaid',
            'label' => 'LBL_ISMEDICAID',
          ),
          1 => 
          array (
            'name' => 'commtype',
            'label' => 'LBL_COMMTYPE',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'chargedback',
            'label' => 'LBL_CHARGEDBACK',
          ),
          1 => 
          array (
            'name' => 'chargebackcommission',
            'label' => 'LBL_CHARGEBACKCOMMISSION',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'nocommissionuploaded',
            'label' => 'LBL_NOCOMMISSIONUPLOADED',
          ),
          1 => 
          array (
            'name' => 'agerange',
            'label' => 'LBL_AGERANGE',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'ageatsale',
            'label' => 'LBL_AGEATSALE',
          ),
          1 => 
          array (
            'name' => 'agerangeatdateofsale',
            'label' => 'LBL_AGERANGEATDATEOFSALE',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'humanaapplicationcode',
            'label' => 'LBL_HUMANAAPPLICATIONCODE',
          ),
          1 => 
          array (
            'name' => 'originateddid',
            'label' => 'LBL_ORIGINATEDDID',
          ),
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'statusauditresult',
            'studio' => 'visible',
            'label' => 'LBL_STATUSAUDITRESULT',
          ),
          1 => 
          array (
            'name' => 'statusauditnotes',
            'studio' => 'visible',
            'label' => 'LBL_STATUSAUDITNOTES',
          ),
        ),
        16 => 
        array (
          0 => 
          array (
            'name' => 'statusauditdate',
            'label' => 'LBL_STATUSAUDITDATE',
          ),
          1 => 
          array (
            'name' => 'statusauditdate2',
            'label' => 'LBL_STATUSAUDITDATE2',
          ),
        ),
        17 => 
        array (
          0 => 
          array (
            'name' => 'statuscontactauditresult',
            'studio' => 'visible',
            'label' => 'LBL_STATUSCONTACTAUDITRESULT',
          ),
          1 => 
          array (
            'name' => 'carriercancellationcode',
            'label' => 'LBL_CARRIERCANCELLATIONCODE',
          ),
        ),
        18 => 
        array (
          0 => 
          array (
            'name' => 'inhouserewrite',
            'studio' => 'visible',
            'label' => 'LBL_INHOUSEREWRITE',
          ),
          1 => 
          array (
            'name' => 'lunauditstatus',
            'label' => 'LBL_LUNAUDITSTATUS',
          ),
        ),
        19 => 
        array (
          0 => 
          array (
            'name' => 'marxlisactive',
            'label' => 'LBL_MARXLISACTIVE',
          ),
          1 => 
          array (
            'name' => 'lissubsidyamount',
            'label' => 'LBL_LISSUBSIDYAMOUNT',
          ),
        ),
        20 => 
        array (
          0 => 
          array (
            'name' => 'sfdnc',
            'label' => 'LBL_SFDNC',
          ),
          1 => 
          array (
            'name' => 'sfdate',
            'label' => 'LBL_SFDATE',
          ),
        ),
        21 => 
        array (
          0 => 
          array (
            'name' => 'planduration',
            'label' => 'LBL_PLANDURATION',
          ),
          1 => 
          array (
            'name' => 'hrastatus',
            'studio' => 'visible',
            'label' => 'LBL_HRASTATUS',
          ),
        ),
        22 => 
        array (
          0 => 
          array (
            'name' => 'exceptionneedednotmarked',
            'label' => 'LBL_EXCEPTIONNEEDEDNOTMARKED',
          ),
          1 => 
          array (
            'name' => 'sunfiretempmarker',
            'label' => 'LBL_SUNFIRETEMPMARKER',
          ),
        ),
        23 => 
        array (
          0 => 
          array (
            'name' => 'customerdatetext',
            'label' => 'LBL_CUSTOMERDATETEXT',
          ),
          1 => 
          array (
            'name' => 'paidhra',
            'label' => 'LBL_PAIDHRA',
          ),
        ),
        24 => 
        array (
          0 => 
          array (
            'name' => 'verrifiedreferral',
            'label' => 'LBL_VERRIFIEDREFERRAL',
          ),
          1 => '',
        ),
        25 => 
        array (
          0 => 
          array (
            'name' => 'sobfilename',
            'label' => 'LBL_SOBFILENAME',
          ),
          1 => 
          array (
            'name' => 'appfilename',
            'label' => 'LBL_APPFILENAME',
          ),
        ),
      ),
      'lbl_editview_panel11' => 
      array (
        0 => 
        array (
          0 => '',
          1 => '',
        ),
        1 => 
        array (
          0 => '',
          1 => '',
        ),
        2 => 
        array (
          0 => '',
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
