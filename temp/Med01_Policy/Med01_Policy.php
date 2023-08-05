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


class Med01_Policy extends Basic
{
    public $new_schema = true;
    public $module_dir = 'Med01_Policy';
    public $object_name = 'Med01_Policy';
    public $table_name = 'med01_policy';
    public $importable = true;

    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $SecurityGroups;
    public $agentemail;
    public $agentlastname;
    public $plans;
    public $serialnumber;
    public $plannamecode;
    public $plantype;
    public $dsstatustext;
    public $medicaidnumber;
    public $humanaapplicationcode;
    public $oldamebeneficiary2;
    public $oldamebeneficiary1;
    public $lifetermlength;
    public $appfilename;
    public $sobfilename;
    public $customerdatetext;
    public $durationrange;
    public $canceldatetext;
    public $effdatetext;
    public $lun;
    public $plandurationrange;
    public $agerangeatdateofsale;
    public $agerange;
    public $commtype;
    public $customerdatepolicyquarter;
    public $cancelpolicyquarter;
    public $effectivepolicyquarter;
    public $agentfirstname;
    public $humanafullname;
    public $humanaemail;
    public $amebenefit;
    public $lissubsidyamount;
    public $lunauditstatus;
    public $carriercancellationcode;
    public $humanaproductsplanname;
    public $humanadateofbirth;
    public $humanamedicareid;
    public $humanapolicyid;
    public $humanapartnerappid;
    public $contingentbeneficiary;
    public $primarybeneficiary;
    public $carrierstatus1;
    public $marxnewplan;
    public $receipt;
    public $callbacknotesforagent;
    public $pcpid;
    public $primarycaredoctorpcp;
    public $hraconfnumber;
    public $policynumber;
    public $enrollmentcode;
    public $sfpersonalcode;
    public $sepcode;
    public $enrollmentperiod;
    public $mimetype;
    public $healthlifetimelimit;
    public $statusauditnotes;
    public $agentportalnotes;
    public $beneficiarynotes;
    public $applicationnotes;
    public $agentdataentryissuenotes;
    public $tonotes;
    public $advocatecallnotes;
    public $surveyoffered;
    public $firstmaplan;
    public $annotatednumber;
    public $originateddid;
    public $humanaphone;
    public $qanumber;
    public $statuscontactauditresult;
    public $advocatecallcompletedby;
    public $csdateyear;
    public $planduration;
    public $plandurationcalc;
    public $termduration;
    public $dayseffective;
    public $ageatsale;
    public $activeduration;
    public $declinelifespan;
    public $cancellifespan;
    public $relatedinsured;
    public $humanaagentsan;
    public $humanaidcard;
    public $humanaenrollmentid;
    public $username;
    public $carrier;
    public $status;
    public $saveagent;
    public $rewritefrontrep;
    public $verifiedby;
    public $salesto;
    public $deductable;
    public $colnsurance;
    public $appfee;
    public $hrastatus;
    public $checkboxtestfield;
    public $inhouserewrite;
    public $statusauditresult;
    public $rewritefrontedto;
    public $rewritefronter;
    public $dataentryrep;
    public $aepassignedagent;
    public $cshracompletedby;
    public $humanastatus;
    public $humanaagentsfullname;
    public $previouscarrier;
    public $formularyexceptionneeded;
    public $cancelreason;
    public $declinereason;
    public $salesrep;
    public $isthisafuturepay;
    public $a1monthlyadminfee;
    public $timestod;
    public $contingentbeneficiaryrelations;
    public $primarybeneficiaryrelationship;
    public $vendor;
    public $aor;
    public $fronterrep;
    public $primarybeneficiaryperc;
    public $commission2020;
    public $commission2021;
    public $commission2022;
    public $commission2023;
    public $contingentbeneficiaryperc;
    public $commission;
    public $lifetimecommission;
    public $carriercommissions;
    public $annualizedpremium;
    public $agentcallbackappt;
    public $testver;
    public $datesubmittedtoverification;
    public $humanasignaturedate;
    public $oepappointment;
    public $futureenrollmentperiodcbnotes;
    public $futureenrollmentperiodcallback;
    public $day90aftereffectivefollowupcal;
    public $day60aftereffectivefollowupcal;
    public $day30aftereffectivefollowupcal;
    public $initialwellnessvisitscheduled;
    public $effectivedatecallcomplete;
    public $carrierpolicypacketreceived;
    public $dsnpsepfollowupappt;
    public $welcomecallcomplete;
    public $welcomeemailsent;
    public $signeddate;
    public $advocatecallbackscheduled;
    public $cshracompleteddate;
    public $manualvertimeentry;
    public $sfdate;
    public $savedate;
    public $applicationsignaturedate;
    public $dupstmtermdate1;
    public $termdate;
    public $statusauditdate2;
    public $statusauditdate;
    public $futurepaydeclinedate;
    public $welcomeletterresent;
    public $birthdaycardreturned;
    public $welcomeletterreturned;
    public $marxcheckdate;
    public $canceldate;
    public $declinedate;
    public $issuedate;
    public $customerdate;
    public $movingdisenrollmentdate;
    public $futurepaymentdate;
    public $effectivedate;
    public $onetimeapplicationfee;
    public $currency_id;
    public $maxoutofpocket;
    public $lifecoverageamount;
    public $cibenefit;
    public $amecibenefit;
    public $agentcommission;
    public $premium;
    public $chargebackcommission;
    public $missingincorrectmedications;
    public $advocatecallsentbacktoagent;
    public $rewrite;
    public $cscampaignassigned;
    public $agentrewrite;
    public $highrisk;
    public $applicationacceptedbycarrier;
    public $lumpsumheartattackandstrokerid;
    public $invasivecancerrecurrencerider;
    public $criticalconditionrider;
    public $exceptionneedednotmarked;
    public $sunfiretempmarker;
    public $marxlisactive;
    public $marxlookupfailed;
    public $lunauditupdate;
    public $cpadeal;
    public $missinggender;
    public $narapp;
    public $narsob;
    public $dataverified;
    public $sunfire;
    public $nopreviousmedicareadvorpartdpl;
    public $partdendoflastplanyear;
    public $ismedicaid;
    public $pointagram;
    public $vertimeoverride;
    public $housedeal;
    public $verrifiedreferral;
    public $paidhra;
    public $sfdnc;
    public $rewritebonus;
    public $unplacedrewrite;
    public $pastrd;
    public $isissued;
    public $ischurn;
    public $isplaced;
    public $nocommissionuploaded;
    public $chargedback;
    public $commissionpaid;
    public $q1count;
    public $isendofquarteractive;
    public $isnotissuedcxl;
    public $iscancel;
    public $isdecline;
    public $plantypecheck;
    public $advocatecallincomplete;
    public $flagfordatareview;
    public $isactive;
    public $carrierconfirmedmoving;
    public $sunfiredoctormismatch;
    public $advocatecallcomplete;
    public $removefromagentportal;
    public $itissuewithwelcomecall;
    public $welcomecallmade;
    public $partdinthisplanyear;
    public $reapp;
    public $payrolloverride;
    public $rewritepolicysubmitted;
    public $agentasigned;
    public $declinenotissuedconfirmed;
    public $missingsunfirecode;
    public $missingsecurityquestions;
    public $incorrectpersonalinfo;
    public $missingincorrectaddress;
    public $piorauthnotnotified;
    public $exceptionmarkerror;
    public $missingdoctor;
    public $payout;
    public $commissions;
    public $chargebacks;
    public $textz;
	
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }
	
}