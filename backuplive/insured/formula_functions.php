<?php
error_reporting(-1);
ini_set('display_errors', 1);



function test(){
    return "test";
}


function customerDatePolicyQuarter( $policy_data = false, $insured_data = false ){ //canceldate
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){
            if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 3 ){
                return "1";
            } else if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 6 ){
                return "2";
            } else if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 9 ){
                return "3";
            } else if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 12 ){
                return "4";
            } else {
                return "0";
            }
        } else {
            return "0";
        }



    } else {
        return false;
    }
}


function cancelPolicyQuarter( $policy_data = false, $insured_data = false ){ //canceldate
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){
            if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 3 ){
                return "1";
            } else if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 6 ){
                return "2";
            } else if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 9 ){
                return "3";
            } else if( date("m", strtotime( $policy_data['canceldate'] ) ) <= 12 ){
                return "4";
            } else {
                return "0";
            }
        } else {
            return "0";
        }

    } else {
        return false;
    }
}



function isActive( $policy_data = false, $insured_data = false ){ // status
    if( $policy_data !== false  ){

        //make conditions here
        $activeStatusValues = array(
            'AwaitingPaymentVerification',
            'Issued',
            'PendingUnderwriting',
            'UnderwritingRequestPending',
            'PendingAdditionalInfo',
            'MedicaidStatusPending',
            'MonthlyPaymentDecline',
            'Rewrite'
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){
            return true;
        } else {
            return false;
        }


    } else {
        return false;
    }
}



function q1Count( $policy_data = false, $insured_data = false ){ // status, customerdate, canceldate 
    if( $policy_data !== false  ){
        //make conditions here
        $isActive = isActive( $policy_data, $insured_data );
        $csDateYear = csDateYear( $policy_data, $insured_data );
        $customerDatePolicyQuarter = (string)customerDatePolicyQuarter( $policy_data, $insured_data );
        $cancelPolicyQuarter = (string)cancelPolicyQuarter( $policy_data, $insured_data );

        if( $isActive == false && $csDateYear == '2020' && $customerDatePolicyQuarter == '1' && $customerDatePolicyQuarter !== $cancelPolicyQuarter ){
            return true;
        } else {
            return false;
        }



    } else {
        return false;
    }
}

function commissionPaid( $policy_data = false, $insured_data = false, $commission_count_by_id = false ){
    if( $policy_data !== false  && $commission_count_by_id !== false ){
        //make conditions here
        if( isset( $commission_count_by_id[ $policy_data['id'] ] ) ){

            $noOfHumanaCommissions = $commission_count_by_id[ $policy_data['id'] ];

            if( $noOfHumanaCommissions > 0 ){ //no of humana commissions or chargebacks > 0
                return true;
            } else {
                return false;
            }
        }

        return false;

    } else {
        return false;
    }
}

function chargedBack( $policy_data = false, $insured_data = false, $related_commission_by_id = false, $commission_ids_by_policy_id = false ){
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false && isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
        //make conditions here

        $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

        if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){
            $humana_2023_cb = 0;
            $humana_2022_cb = 0;
            $humana_2021_cb = 0;
            $humana_2020_cb = 0;

            foreach( $related_commissions_ids as $related_commissions_id ){

                if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                    if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                        $humana_2023_cb = $humana_2023_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                    } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                        $humana_2022_cb = $humana_2022_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                    } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                        $humana_2021_cb = $humana_2021_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                    } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                        $humana_2020_cb = $humana_2020_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                    }
                }
            }


            if( $humana_2023_cb <= 0 ){
                return true;
            } else if( $humana_2022_cb <= 0 ){
                return true;
            } else if( $humana_2021_cb <= 0 ){
                return true;
            } else if( $humana_2020_cb <= 0 ){
                return true;
            }

        }

        

        return false;
        


    } else {
        return false;
    }
}

function chargeBackCommission( $policy_data = false, $insured_data = false , $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //carrier
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here

        switch ( $policy_data['carrier'] ) {
            case 'Humana':
                if( isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
                    $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

                    if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){
                        $humana_2023_cb = 0;
                        $humana_2022_cb = 0;
                        $humana_2021_cb = 0;
                        $humana_2020_cb = 0;

                        $humana_2023_commission = 0;
                        $humana_2022_commission = 0;
                        $humana_2021_commission = 0;
                        $humana_2020_commission = 0;

                        foreach( $related_commissions_ids as $related_commissions_id ){

                            if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                                if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                                    $humana_2023_cb = $humana_2023_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2023_commission = $humana_2023_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                                    $humana_2022_cb = $humana_2022_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2022_commission = $humana_2022_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                                    $humana_2021_cb = $humana_2021_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2021_commission = $humana_2021_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                                    $humana_2020_cb = $humana_2020_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2020_commission = $humana_2020_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                }
                            }
                        }

                        $humana_2023 = $humana_2023_commission+$humana_2023_cb;
                        $humana_2022 = $humana_2022_commission+$humana_2022_cb;
                        $humana_2021 = $humana_2021_commission+$humana_2021_cb;
                        $humana_2020 = $humana_2020_commission+$humana_2020_cb;

                        $lifeTimeCommission = $humana_2023+$humana_2022+$humana_2021+$humana_2020;


                        if( $lifeTimeCommission <= 0 ){
                            return true;
                        }

                    }
                }
                

                break;
            
            default:
                # code...
                break;
        }

        

        return false;


    } else {
        return false;
    }
}



function lifeTimeCommission( $policy_data = false, $insured_data = false , $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //carrier
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here
        if( isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
            $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

            if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){

                $humana_2023_commission = 0;
                $humana_2022_commission = 0;
                $humana_2021_commission = 0;
                $humana_2020_commission = 0;

                foreach( $related_commissions_ids as $related_commissions_id ){

                    if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                        if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                            $humana_2023_commission = $humana_2023_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                        } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                            $humana_2022_commission = $humana_2022_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                        } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                            $humana_2021_commission = $humana_2021_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                        } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                            $humana_2020_commission = $humana_2020_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                        }
                    }
                }

                $lifeTimeCommission = $humana_2023_commission+$humana_2022_commission+$humana_2021_commission+$humana_2020_commission;


                if( $lifeTimeCommission <= 0 ){
                    return (number_format(( $lifeTimeCommission ), 8, '.', ''));
                } else {
                    return (number_format(0, 8, '.', ''));
                }

            }
        }
        

        

        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }
}

function isPlaced( $policy_data = false, $insured_data = false ){ // status
    if( $policy_data !== false  ){
        //make conditions here
        $activeStatusValues = array(
            "Cancelled",
            "Issued",
            "Rewrite",
            "Deceased",
            "SuccessfulResubmission"
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){
            return true;
        } else {
            return false;
        }



    } else {
        return false;
    }
}

function isChurn( $policy_data = false, $insured_data = false ){ // status
    if( $policy_data !== false  ){
        //make conditions here
        $activeStatusValues = array(
            "Cancelled"
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){
            return true;
        } else {
            return false;
        }


    } else {
        return false;
    }
}

function isIssued( $policy_data = false, $insured_data = false ){ // status
    if( $policy_data !== false  ){
        //make conditions here
        $activeStatusValues = array(
            "Cancelled",
            "Withdrawn",
            "Issued",
            "Rewrite",
            "Deceased"
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){
            return true;
        } else {
            return false;
        }



    } else {
        return false;
    }
}

function termDuration( $policy_data = false, $insured_data = false ){ //issuedate, termdate
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['issuedate'] ) && $policy_data['issuedate'] && isset( $policy_data['termdate'] ) && $policy_data['termdate'] ){

            $date1 = new DateTime( $policy_data['issuedate'] );
            $date2 = new DateTime( $policy_data['termdate'] );

            $diff = $date1->diff($date2);

            return abs( $diff->days );
        }


        return 0;


    } else {
        return 0;
    }
}

function pastRD( $policy_data = false, $insured_data = false ){ // effectivedate
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){

            $date1 = new DateTime( $policy_data['effectivedate'] );
            $date2 = new DateTime( date("Y-m-d") );

            $diff = $date1->diff($date2);

            if( abs($diff->days) > 90 ){
                return true;
            }
        }


        return false;


    } else {
        return false;
    }
}


function sfdnc( $policy_data = false, $insured_data = false ){ //carrier, effectivedate, status, canceldate, declinedate
    if( $policy_data !== false  ){
        //make conditions here
        $plan_duration = planDuration( $policy_data = false, $insured_data = false );

        if( isset( $plan_duration ) && $plan_duration > 90 && isset( $policy_data['carrier'] ) ){

            $carrierValues = array(
                "Humana",
                "Anthem",
                "AnthemBlueCrossandBlueShield",
                "AnthemH1732-003"
            );


            if( in_array($policy_data['carrier'], $carrierValues) ){
                return true;
            }

        }

        return false;


    } else {
        return false;
    }
}

function paidHRA( $policy_data = false, $insured_data = false, $related_commission_by_id = false, $commission_ids_by_policy_id = false ){
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here
        if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){

            $humana_paid_hra = 0;
            $aetna_adv_paid_hra = 0;

            foreach( $related_commissions_ids as $related_commissions_id ){

                if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['plann'] ) && $related_commission_by_id[ $related_commissions_id ]['plann'] == "HRA" ){
                    $humana_paid_hra++;
                }
            }


            if( 
                $humana_paid_hra 
                ||
                $aetna_adv_paid_hra
            ){
                return true;
            }


        }


        return false;


    } else {
        return false;
    }
}


function commission( $policy_data = false, $insured_data = false ){ //issuedate, termdate, payrolloverride, healthlifetimelimit, status, housedeal, plantype
    if( $policy_data !== false  ){
        //make conditions here

        $isActive = isActive( $policy_data, $insured_data );
        $termDuration = termDuration( $policy_data, $insured_data );
        
        if( isset( $policy_data['payrolloverride'] ) ){
            $payrolloverride = $policy_data['payrolloverride'];
        } else {
            $payrolloverride = 0;
        }

        if( isset( $policy_data['housedeal'] ) ){
            $housedeal = $policy_data['housedeal'];
        } else {
            $housedeal = 0;
        }

        if( isset( $policy_data['healthlifetimelimit'] ) ){
            $healthlifetimelimit = $policy_data['healthlifetimelimit'];
        } else {
            $healthlifetimelimit = 0;
        }

        $plan_requiresLifetimeLimitException = 0;//[Plan - Requires lifetime limit exception] 
        $plan_59age = 0;// [Plan - 59+ (Age)]
        $plan_STM90ORLESS = 0;// [Plan - STM90ORLESS]
        $plan_plantype = $policy_data['plantype'];// [Plan - Plan Type]
        $plan_flat = 0;// [Plan - FLAT]
        $plan_woanc = 0;// [Plan - W/O ANC]
        $plan_w1anc = 0;// [Plan - W/1 ANC]
        $plan_w2anc = 0;// [Plan - W/2 ANC]

        if( $payrolloverride ){
            return 0;
        } else {
            if( $plan_requiresLifetimeLimitException && $healthlifetimelimit == "100000" ){
                return (number_format(0, 8, '.', ''));
            } else {
                if( $housedeal ){
                    return (number_format(0, 8, '.', ''));
                } else {
                    if( $isActive and $plan_59age > 0 ){ //gone Insured - Age>58
                        return (number_format($plan_59age, 8, '.', ''));
                    } else {
                        if( $termDuration < 90 and $plan_STM90ORLESS > 0 ){
                            return (number_format($plan_STM90ORLESS, 8, '.', ''));
                        } else {
                            if( $isActive and $plan_plantype == "STM" ){ // gone [Insured - # of Approved ANC] = 0
                                if( $plan_woanc == null ){
                                    return (number_format($plan_flat, 8, '.', ''));
                                } else {
                                    return (number_format($plan_woanc, 8, '.', ''));
                                }
                            } else {
                                if( $isActive and $plan_plantype == "STM" ){ // gone [Insured - # of Approved ANC] = 1
                                    if( $plan_w1anc == null ){
                                        return (number_format($plan_flat, 8, '.', ''));
                                    } else {
                                        return (number_format($plan_w1anc, 8, '.', ''));
                                    }
                                } else {
                                    if( $isActive and $plan_plantype == "Limited Medical" ){ // gone [Insured - # of Approved ANC] = 1
                                        if( $plan_w1anc == null ){
                                            return (number_format($plan_flat, 8, '.', ''));
                                        } else {
                                            return (number_format($plan_w1anc, 8, '.', ''));
                                        }
                                    } else {
                                        if( $isActive and $plan_plantype == "Limited Medical" ){ // gone [Insured - # of Approved ANC] = 2
                                            if( $plan_w2anc == null ){
                                                return (number_format($plan_flat, 8, '.', ''));
                                            } else {
                                                return (number_format($plan_w2anc, 8, '.', ''));
                                            }
                                        } else {
                                            if( $isActive and $plan_plantype == "STM" ){ // gone [Insured - # of Approved ANC] = 2
                                                if( $plan_w2anc == null ){
                                                    return (number_format($plan_flat, 8, '.', ''));
                                                } else {
                                                    return (number_format($plan_w2anc, 8, '.', ''));
                                                }
                                            } else {
                                                if( $isActive and $plan_plantype != "STM" ){
                                                    return (number_format($plan_flat, 8, '.', ''));
                                                } else {
                                                    if( $isActive and $plan_plantype != "Limited Medical" ){
                                                        return (number_format($plan_flat, 8, '.', ''));
                                                    } else {
                                                        return (number_format(0, 8, '.', ''));
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }

}

function payout( $policy_data = false, $insured_data = false ){ //issuedate, termdate, payrolloverride, healthlifetimelimit, status, housedeal, plantype, premium
    if( $policy_data !== false  ){
        //make conditions here

        $commission = commission( $policy_data , $insured_data );

        if( isset( $policy_data['premium'] ) && $policy_data['premium'] && $commission ){

            $premium = $policy_data['premium'];

            if( ( $premium*$commission ) > 0 ){
                return (number_format(( $premium*$commission ), 6, '.', ''));
            } else {
                return (number_format(0, 6, '.', ''));
            }
            

        }


        return (number_format(0, 6, '.', ''));


    } else {
        return (number_format(0, 6, '.', ''));
    }
}

function planDuration( $policy_data = false, $insured_data = false ){ //effectivedate, status, canceldate, declinedate
    if( $policy_data !== false  ){

        if( isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){

            $sfDate = sfDate( $policy_data, $insured_data );
            $effectivedate = $policy_data['effectivedate'];

            if( isset( $sfDate ) && $sfDate && isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){
                $date1 = new DateTime( $policy_data['effectivedate'] );
                $date2 = new DateTime( $sfDate );

                $diff = $date1->diff($date2);

                return (int)$diff->days;
            }
        }

        
        return 0;

    } else {
        return 0;
    }
}


function sfDate( $policy_data = false, $insured_data = false ){ //status, canceldate, declinedate
    if( $policy_data !== false  ){

        $isCancel = isCancel( $policy_data = false, $insured_data = false );
        $isDecline = isDecline( $policy_data = false, $insured_data = false );

        if( $isCancel ){

            if( isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){
                return date("Y-m-d", strtotime( $policy_data['canceldate'] ));
            } else {
                return date("Y-m-d");
            }

        } else if( $isDecline ){
            if( isset( $policy_data['declinedate'] ) && $policy_data['declinedate'] ){
                return date("Y-m-d", strtotime( $policy_data['declinedate'] ));
            } else {
                return date("Y-m-d");
            }
        } 

        return false;

    } else {
        return false;
    }

}

function dateSubmittedToVerification( $policy_data = false, $insured_data = false ){ //vertimeoverride, date_entered, manualvertimeentry
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['vertimeoverride'] ) && $policy_data['vertimeoverride'] && isset($policy_data['manualvertimeentry']  ) ){
            return $policy_data['manualvertimeentry'];
        } else {
            return $policy_data['date_entered'];
        }


        return false;


    } else {
        return false;
    }
}

function planTypeCheck( $policy_data = false, $insured_data = false ){ //plantype
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['plantype'] ) && $policy_data['plantype'] ){
            return true;
        }

        return false;


    } else {
        return false;
    }
}

function isDecline( $policy_data = false, $insured_data = false ){//status
    if( $policy_data !== false  ){
        //make conditions here
        $activeStatusValues = array(
            "DeclinedCarrier"
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){
            return true;
        } else {
            return false;
        }


        return false;


    } else {
        return false;
    }
}

function isCancel( $policy_data = false, $insured_data = false ){ //status
    if( $policy_data !== false  ){
        //make conditions here
        $activeStatusValues = array(
            "Cancelled",
            "Withdrawn",
            "DeclinedCarrier",
            "Incomplete",
            "NotIssuedWithdrawn",
            "Deceased",
            "FuturePayCancel",
            "InitialDeclinePaymentCancel",
            "InitialPaymentDecline",
            "PaymentDeclineCancel",
            "Rescinded",
            "NoSignature",
            "SuccessfulResubmission",
            "SuccessfulResubmissionMark'sCancel",
            "SuccessfulResubmissionMark'sAEPCancel",
            "MarxAEPCancel",
            "SuccessfulResubmissionNIW",
            "SuccessfulResubmissionWithdrawn",
            "MarxWithdrawn"
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){
            return true;
        } else {
            return false;
        }



    } else {
        return false;
    }
}










function revenue( $policy_data = false, $insured_data = false, $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //issuedate, termdate, payrolloverride, healthlifetimelimit, status, housedeal, plantype


    $revenue = 0;
    $commission = 0;
    $chargeback = 0;


    if( $policy_data !== false  ){
        //make conditions here
        $commission = commission( $policy_data, $insured_data );
        $chargeback = chargedBack( $policy_data, $insured_data, $related_commission_by_id, $commission_ids_by_policy_id );


        $revenue = ( abs( $commission ) ) - ( abs( $chargeback ) );


        

    }

    return $revenue;
    
}


function effectivePolicyQuarter( $policy_data = false, $insured_data = false ){ //effectivedate

    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){
            if( date("m", strtotime( $policy_data['effectivedate'] ) ) <= 3 ){
                return "1";
            } else if( date("m", strtotime( $policy_data['effectivedate'] ) ) <= 6 ){
                return "2";
            } else if( date("m", strtotime( $policy_data['effectivedate'] ) ) <= 9 ){
                return "3";
            } else if( date("m", strtotime( $policy_data['effectivedate'] ) ) <= 12 ){
                return "4";
            } else {
                return "0";
            }
        } else {
            return "0";
        }



    } else {
        return false;
    }
}








function isNotIssuedCXL( $policy_data = false, $insured_data = false ){ //status, canceldate, effectivedate
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['status'] ) && $policy_data['status'] == "Withdrawn" ){

            $cancelDate = cancelPolicyQuarter( $policy_data, $insured_data );
            $effectiveDate = effectivePolicyQuarter( $policy_data, $insured_data );

            if( $cancelDate == $effectiveDate ){
                return true;
            }


        }

        


        return false;


    } else {
        return false;
    }
    
}






function isEndOfQuarterActive( $policy_data = false, $insured_data = false ){ // status, canceldate
    if( $policy_data !== false  ){
        //make conditions here


        $activeStatusValues = array(
            'AwaitingPaymentVerification',
            'Issued',
            'PendingUnderwriting',
            'UnderwritingRequestPending',
            'PendingAdditionalInfo',
            'MedicaidStatusPending',
            'Withdrawn'
        );

        if( isset( $policy_data['status'] ) && in_array( $policy_data['status'] , $activeStatusValues) ){

            if( $policy_data['status'] == "Withdrawn" ){
                if( isset( $policy_data['canceldate'] ) && strtotime( $policy_data['canceldate'] ) < strtotime( "2020-03-31" ) ){
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }

            
        } else {
            return false;
        }



    } else {
        return false;
    }
    
}






function cancelLifespan( $policy_data = false, $insured_data = false ){ //canceldate, effectivedate
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] && isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){

            $date1 = new DateTime( $policy_data['canceldate'] );
            $date2 = new DateTime( $policy_data['effectivedate'] );

            $diff = $date1->diff($date2);

            return abs( $diff->days );
        }



        return 0;


    } else {
        return 0;
    }
    
}






function declineLifespan( $policy_data = false, $insured_data = false ){ //declinedate, customerdate
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['declinedate'] ) && $policy_data['declinedate'] && isset( $policy_data['customerdate'] ) && $policy_data['customerdate'] ){

            $date1 = new DateTime( $policy_data['customerdate'] );
            $date2 = new DateTime( $policy_data['declinedate'] );

            $diff = $date1->diff($date2);

            return abs( $diff->days );
        }



        return 0;


    } else {
        return 0;
    }
    
}






function ageAtSale( $policy_data = false, $insured_data = false ){ //effectivedate, insured-dob
    if( $policy_data !== false && $insured_data !== false ){
        //make conditions here
        if( isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] && isset( $insured_data['dob'] ) && $insured_data['dob'] ){

            $date1 = new DateTime( $insured_data['dob'] );
            $date2 = new DateTime( $policy_data['effectivedate'] );

            $diff = $date1->diff($date2);

            return abs( $diff->y ); // return count of years
        }



        return 0;


    } else {
        return 0;
    }
    
}






function daysEffective( $policy_data = false, $insured_data = false ){ //effectivedate
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){

            $date1 = new DateTime( date("Y-m-d") );
            $date2 = new DateTime( $policy_data['effectivedate'] );

            $diff = $date1->diff($date2);

            return abs( $diff->days );
        }



        return 0;


    } else {
        return 0;
    }
    
}







function annualizedPremium( $policy_data = false, $insured_data = false ){ //premium
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['premium'] ) && $policy_data['premium'] ){

            $premium = abs( $policy_data['premium'] );

            if( ( $premium*12 ) > 0 ){
                return (number_format(( $premium*12 ), 8, '.', ''));
            } else {
                return (number_format(0, 8, '.', ''));
            }
            

        }


        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }
    
}






function planDurationCalc( $policy_data = false, $insured_data = false ){ //status, effectivedate, canceldate
    if( $policy_data !== false  ){
        //make conditions here

        if( isset( $policy_data['status'] ) && $policy_data['status'] && isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] && isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){

            if( $policy_data['status'] == "Issued"){
                $date1 = new DateTime( date("Y-m-d") );
                $date2 = new DateTime( $policy_data['effectivedate'] );

                $diff = $date1->diff($date2);

                return abs( $diff->days );
            } else {
                if( $policy_data['status'] == "DeclinedCarrier"){
                    return 0;
                } else {
                    if( $policy_data['status'] == "Withdrawn"){
                       $date1 = new DateTime( $policy_data['canceldate'] );
                        $date2 = new DateTime( $policy_data['effectivedate'] );

                        $diff = $date1->diff($date2);

                        return abs( $diff->days );
                    } else {

                        if( $policy_data['status'] == "SuccessfulResubmissionWithdrawn"){
                           $date1 = new DateTime( $policy_data['canceldate'] );
                            $date2 = new DateTime( $policy_data['effectivedate'] );

                            $diff = $date1->diff($date2);

                            return abs( $diff->days );
                        } else {
                            if( $policy_data['status'] == "Incomplete"){
                                return 0;
                            } else {
                                
                                if( $policy_data['status'] == "NotIssuedWithdrawn"){
                                    return 0;
                                } else {
                                    return 0;
                                }
                            }
                            
                        }
                        
                    }
                }
            }
        }


        return 0;


    } else {
        return 0;
    }
    
}





function csDateYear( $policy_data = false, $insured_data = false ){ //customerdate
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['customerdate'] ) && $policy_data['customerdate'] ){
            return date( "Y", strtotime( $policy_data['customerdate'] ) );
        }


        return "";


    } else {
        return "";
    }
    
}










function qaNumber( $policy_data = false, $insured_data = false ){ //insured-phone
    if( $policy_data !== false && $insured_data !== false  ){
        //make conditions here
        if( isset( $insured_data['phone'] ) && $insured_data['phone'] ){
            return $insured_data['phone'];
        }


        return "";


    } else {
        return "";
    }
    
}






















function agentFirstName( $policy_data = false, $insured_data = false ){ //salesrep
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['salesrep'] ) && $policy_data['salesrep'] ){
            $agent_name = "";

            switch ( $policy_data['salesrep'] ) {

                case 'co_albertomoreno':
                    $agent_name = "Alberto";
                    break;

                case 'co_caitlinmchale':
                    $agent_name = "Caitlin";
                    break;


                case 'co_kimberlykinkead':
                    $agent_name = "Kimberly";
                    break;


                case 'co_racheallanneaux':
                    $agent_name = "Racheal";
                    break;


                case 'co_sydneeallen':
                    $agent_name = "Sydnee";
                    break;


                case 'co_warrenwilson':
                    $agent_name = "Warren";
                    break;


                case 'co_patriciamcgriff':
                    $agent_name = "Patricia";
                    break;


                case 'co_everettelemont':
                    $agent_name = "Everette";
                    break;


                case 'co_roseaugustin':
                    $agent_name = "Rose";
                    break;


                case 'co_essencejones':
                    $agent_name = "Essence";
                    break;


                case 'co_jessbaldonado':
                    $agent_name = "Jessica";
                    break;


                case 'co_carmenjoseph':
                    $agent_name = "Carmen";
                    break;


                case 'co_carleitowynter':
                    $agent_name = "Carleito";
                    break;


                case 'co_kelvinmajano':
                    $agent_name = "Kelvin";
                    break;


                case 'co_chrisramos':
                    $agent_name = "Chris";
                    break;


                case 'co_courtneyscrivens':
                    $agent_name = "Courtney";
                    break;
                
                default:
                    # code...
                    break;
            }

            return $agent_name;

        }


        return "";


    } else {
        return "";
    }
    
}








function ageRange( $policy_data = false, $insured_data = false ){ //insured-age
    if( $policy_data !== false && $insured_data !== false  ){
        //make conditions here
        if( isset( $insured_data['age'] ) && $insured_data['age'] ){
            $age_range = "";
            $age = abs( $insured_data['age'] );


            if( $age >= 9 and $age <= 64 ){
                $age_range = "1. Under 65";
            } else if(  $age >= 65 and $age <= 70  ){
                $age_range = "2. 65-70";
            } else if(  $age >= 80 and $age <= 120  ){
                $age_range = "5. Over 80";
            } else if(  $age >= 71 and $age <= 75  ){
                $age_range = "3. 71-75";
            } else if(  $age >= 76 and $age <= 79  ){
                $age_range = "4. 76-79";
            }

            return $age_range;
        }


        return "";


    } else {
        return "";
    }
    
}














function planDurationRange( $policy_data = false, $insured_data = false ){ //status, effectivedate, canceldate
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['status'] ) && $policy_data['status'] && isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] && isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){

            $planDurationCalc = planDurationCalc( $policy_data, $insured_data );


            if( isset( $planDurationCalc ) && $planDurationCalc ){

                if( $planDurationCalc <= 0 ){
                    return "A. Less than 1 Day";
                } else {
                    if( $planDurationCalc >= 1 && $planDurationCalc <= 30 ){
                        return "B. 1st Month";
                    } else {
                        if( $planDurationCalc >= 31 && $planDurationCalc <= 62 ){
                            return "C. 2nd Month";
                        } else {
                            if( $planDurationCalc >= 63 && $planDurationCalc <= 94 ){
                                return "D. 3rd Month";
                            } else {
                                if( $planDurationCalc >= 95 && $planDurationCalc <= 126 ){
                                    return "E. 90-120 Days";
                                } else {
                                    if( $planDurationCalc >= 127 && $planDurationCalc <= 158 ){
                                        return "F. 4th Month";
                                    } else {
                                        if( $planDurationCalc >= 159 && $planDurationCalc <= 190 ){
                                            return "F. 5th Month";
                                        } else {
                                            if( $planDurationCalc >= 191 && $planDurationCalc <= 365 ){
                                                return "180 Days to One Year";
                                            } else {
                                                if( $planDurationCalc >= 366 ){
                                                    return "G. Over One Year";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }


        return "";


    } else {
        return "";
    }
    
}














function durationRange( $policy_data = false, $insured_data = false ){ //status, effectivedate, canceldate
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['status'] ) && $policy_data['status'] && isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] && isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){

            $planDurationCalc = planDurationCalc( $policy_data, $insured_data );


            if( isset( $planDurationCalc ) && $planDurationCalc ){

                if( $planDurationCalc <= 0 ){
                    return "A. Less than 1 Day";
                } else {
                    if( $planDurationCalc >= 1 && $planDurationCalc <= 30 ){
                        return "B. 1st Month";
                    } else {
                        if( $planDurationCalc >= 31 && $planDurationCalc <= 62 ){
                            return "C. 2nd Month";
                        } else {
                            if( $planDurationCalc >= 63 && $planDurationCalc <= 94 ){
                                return "D. 3rd Month";
                            } else {
                                if( $planDurationCalc >= 95 && $planDurationCalc <= 126 ){
                                    return "E. 4th Month";
                                } else {
                                    if( $planDurationCalc >= 127 && $planDurationCalc <= 158 ){
                                        return "F. 5th Month";
                                    } else {
                                        if( $planDurationCalc >= 159 && $planDurationCalc <= 190 ){
                                            return "G. 6th Month";
                                        } else {
                                            if( $planDurationCalc >= 191 && $planDurationCalc <= 365 ){
                                                return "H. 180 Days to One Year";
                                            } else {
                                                if( $planDurationCalc >= 366 ){
                                                    return "I. Over One Year";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }


        return "";


    } else {
        return "";
    }
    
}



function commission2023( $policy_data = false, $insured_data = false , $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //carrier
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here

        switch ( $policy_data['carrier'] ) {
            case 'Humana':
                if( isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
                    $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

                    if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){
                        $humana_2023_cb = 0;
                        $humana_2022_cb = 0;
                        $humana_2021_cb = 0;
                        $humana_2020_cb = 0;

                        $humana_2023_commission = 0;
                        $humana_2022_commission = 0;
                        $humana_2021_commission = 0;
                        $humana_2020_commission = 0;

                        foreach( $related_commissions_ids as $related_commissions_id ){
                            if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                                if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                                    $humana_2023_cb = $humana_2023_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2023_commission = $humana_2023_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                                    $humana_2022_cb = $humana_2022_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2022_commission = $humana_2022_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                                    $humana_2021_cb = $humana_2021_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2021_commission = $humana_2021_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                                    $humana_2020_cb = $humana_2020_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2020_commission = $humana_2020_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                }
                            }
                        }

                        $humana_2023 = $humana_2023_commission+$humana_2023_cb;
                        $humana_2022 = $humana_2022_commission+$humana_2022_cb;
                        $humana_2021 = $humana_2021_commission+$humana_2021_cb;
                        $humana_2020 = $humana_2020_commission+$humana_2020_cb;

                        return (number_format($humana_2023, 8, '.', ''));

                    }
                }
                

                break;
            
            default:
                # code...
                break;
        }

        

        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }
}



function commission2022( $policy_data = false, $insured_data = false , $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //carrier
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here

        switch ( $policy_data['carrier'] ) {
            case 'Humana':
                if( isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
                    $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

                    if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){
                        $humana_2023_cb = 0;
                        $humana_2022_cb = 0;
                        $humana_2021_cb = 0;
                        $humana_2020_cb = 0;

                        $humana_2023_commission = 0;
                        $humana_2022_commission = 0;
                        $humana_2021_commission = 0;
                        $humana_2020_commission = 0;

                        foreach( $related_commissions_ids as $related_commissions_id ){
                            if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                                if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                                    $humana_2023_cb = $humana_2023_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2023_commission = $humana_2023_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                                    $humana_2022_cb = $humana_2022_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2022_commission = $humana_2022_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                                    $humana_2021_cb = $humana_2021_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2021_commission = $humana_2021_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                                    $humana_2020_cb = $humana_2020_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2020_commission = $humana_2020_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                }
                            }
                        }

                        $humana_2023 = $humana_2023_commission+$humana_2023_cb;
                        $humana_2022 = $humana_2022_commission+$humana_2022_cb;
                        $humana_2021 = $humana_2021_commission+$humana_2021_cb;
                        $humana_2020 = $humana_2020_commission+$humana_2020_cb;

                        return (number_format($humana_2022, 8, '.', ''));

                    }
                }
                

                break;
            
            default:
                # code...
                break;
        }

        

        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }
}



function commission2021( $policy_data = false, $insured_data = false , $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //carrier
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here

        switch ( $policy_data['carrier'] ) {
            case 'Humana':
                if( isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
                    $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

                    if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){
                        $humana_2023_cb = 0;
                        $humana_2022_cb = 0;
                        $humana_2021_cb = 0;
                        $humana_2020_cb = 0;

                        $humana_2023_commission = 0;
                        $humana_2022_commission = 0;
                        $humana_2021_commission = 0;
                        $humana_2020_commission = 0;

                        foreach( $related_commissions_ids as $related_commissions_id ){
                            if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                                if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                                    $humana_2023_cb = $humana_2023_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2023_commission = $humana_2023_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                                    $humana_2022_cb = $humana_2022_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2022_commission = $humana_2022_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                                    $humana_2021_cb = $humana_2021_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2021_commission = $humana_2021_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                                    $humana_2020_cb = $humana_2020_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2020_commission = $humana_2020_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                }
                            }
                        }

                        $humana_2023 = $humana_2023_commission+$humana_2023_cb;
                        $humana_2022 = $humana_2022_commission+$humana_2022_cb;
                        $humana_2021 = $humana_2021_commission+$humana_2021_cb;
                        $humana_2020 = $humana_2020_commission+$humana_2020_cb;

                        return (number_format($humana_2021, 8, '.', ''));

                    }
                }
                

                break;
            
            default:
                # code...
                break;
        }

        

        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }
}




function commission2020( $policy_data = false, $insured_data = false , $related_commission_by_id = false, $commission_ids_by_policy_id = false ){ //carrier
    if( $policy_data !== false  && $related_commission_by_id !== false && $commission_ids_by_policy_id !== false ){
        //make conditions here

        switch ( $policy_data['carrier'] ) {
            case 'Humana':
                if( isset( $commission_ids_by_policy_id[ $policy_data['id'] ] ) ){
                    $related_commissions_ids = $commission_ids_by_policy_id[ $policy_data['id'] ];

                    if( isset( $related_commissions_ids ) && is_array( $related_commissions_ids ) && count( $related_commissions_ids ) > 0 ){
                        $humana_2023_cb = 0;
                        $humana_2022_cb = 0;
                        $humana_2021_cb = 0;
                        $humana_2020_cb = 0;

                        $humana_2023_commission = 0;
                        $humana_2022_commission = 0;
                        $humana_2021_commission = 0;
                        $humana_2020_commission = 0;

                        foreach( $related_commissions_ids as $related_commissions_id ){
                            if( isset( $related_commission_by_id[ $related_commissions_id ] ) && isset( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ){
                                if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2023" ){
                                    $humana_2023_cb = $humana_2023_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2023_commission = $humana_2023_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2022" ){
                                    $humana_2022_cb = $humana_2022_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2022_commission = $humana_2022_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2021" ){
                                    $humana_2021_cb = $humana_2021_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2021_commission = $humana_2021_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                } else if( date("Y", strtotime( $related_commission_by_id[ $related_commissions_id ]['statementdate'] ) ) == "2020" ){
                                    $humana_2020_cb = $humana_2020_cb+(float)$related_commission_by_id[ $related_commissions_id ]['chargeback'];
                                    $humana_2020_commission = $humana_2020_commission+(float)$related_commission_by_id[ $related_commissions_id ]['commission'];
                                }
                            }
                        }

                        $humana_2023 = $humana_2023_commission+$humana_2023_cb;
                        $humana_2022 = $humana_2022_commission+$humana_2022_cb;
                        $humana_2021 = $humana_2021_commission+$humana_2021_cb;
                        $humana_2020 = $humana_2020_commission+$humana_2020_cb;

                        return (number_format($humana_2020, 8, '.', ''));

                    }
                }
                

                break;
            
            default:
                # code...
                break;
        }

        

        return (number_format(0, 8, '.', ''));


    } else {
        return (number_format(0, 8, '.', ''));
    }
}









function noCommissionUploaded( $policy_data = false, $insured_data = false, $commission_count_by_id = false ){
    if( $policy_data !== false  && $commission_count_by_id !== false ){
        //make conditions here
        if( isset( $commission_count_by_id[ $policy_data['id'] ] ) ){

            $noOfHumanaCommissions = $commission_count_by_id[ $policy_data['id'] ];

            if( $noOfHumanaCommissions > 0 ){ //no of humana commissions or chargebacks > 0
                return true;
            } else {
                return false;
            }
        }

        return false;

    } else {
        return false;
    }
}



























function lun( $policy_data = false, $insured_data = false ){ // partdinthisplanyear, partdendoflastplanyear
    if( $policy_data !== false  ){
        //make conditions here
        if( isset( $policy_data['partdinthisplanyear'] ) && $policy_data['partdinthisplanyear'] || isset( $policy_data['partdendoflastplanyear'] ) && $policy_data['partdendoflastplanyear'] ){
            return "Unlike";
        } else {
            if( isset( $policy_data['No Previous Medicare Adv'] ) && $policy_data['No Previous Medicare Adv'] || isset( $policy_data['Part D Plan'] ) && $policy_data['Part D Plan'] ){
                return "New";
            } else {
                return "Like";
            }
        }


        return "";


    } else {
        return "";
    }
    
}


















function effDATE_text( $policy_data = false, $insured_data = false ){ //effectivedate
    if( $policy_data !== false  ){
        //make conditions here
        $effDATE_text = "";

        if( isset( $policy_data['effectivedate'] ) && $policy_data['effectivedate'] ){
            $effDATE_text = date( "m", strtotime( $policy_data['effectivedate'] ) )."/".date( "d", strtotime( $policy_data['effectivedate'] ) )."/".date( "y", strtotime( $policy_data['effectivedate'] ) );
        } else {
            $effDATE_text = "//";
        }



        return $effDATE_text;


    } else {
        return "";
    }
    
}


















function cancelDate_text( $policy_data = false, $insured_data = false ){ //canceldate
    if( $policy_data !== false  ){
        //make conditions here
        $cancelDate_text = "";

        if( isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){
            $cancelDate_text = date( "m", strtotime( $policy_data['canceldate'] ) )."/".date( "d", strtotime( $policy_data['canceldate'] ) )."/".date( "y", strtotime( $policy_data['canceldate'] ) );
        } else {
            $cancelDate_text = "//";
        }



        return $cancelDate_text;


    } else {
        return "";
    }
    
}

















function dsStatus_text( $policy_data = false, $insured_data = false ){ //datesubmittedtoverification, status, plantype, carrier, canceldate
    if( $policy_data !== false  ){
        //make conditions here
        $dsStatus_text = "";

        if( isset( $policy_data['datesubmittedtoverification'] ) && $policy_data['datesubmittedtoverification'] ){
            $datesubmittedtoverification = date( "m", strtotime( $policy_data['datesubmittedtoverification'] ) )."/".date( "d", strtotime( $policy_data['datesubmittedtoverification'] ) )."/".date( "y", strtotime( $policy_data['datesubmittedtoverification'] ) );
        } else {
            $datesubmittedtoverification = "//";
        }
        $dsStatus_text = $datesubmittedtoverification;



        if( isset( $policy_data['status'] ) && $policy_data['status'] ){
            $dsStatus_text = $dsStatus_text."|".$policy_data['status'];
        } else {
            $dsStatus_text = $dsStatus_text."|";
        }



        if( isset( $policy_data['plantype'] ) && $policy_data['plantype'] ){
            $dsStatus_text = $dsStatus_text."|".$policy_data['plantype'];
        } else {
            $dsStatus_text = $dsStatus_text."|";
        }



        if( isset( $policy_data['carrier'] ) && $policy_data['carrier'] ){
            $dsStatus_text = $dsStatus_text."|".$policy_data['carrier'];
        } else {
            $dsStatus_text = $dsStatus_text."|";
        }



        if( isset( $policy_data['canceldate'] ) && $policy_data['canceldate'] ){
            $dsStatus_text = $dsStatus_text."|".date( "m", strtotime( $policy_data['canceldate'] ) )."/".date( "d", strtotime( $policy_data['canceldate'] ) )."/".date( "y", strtotime( $policy_data['canceldate'] ) );
        } else {
            $dsStatus_text = $dsStatus_text."|";
        }
        




        return $dsStatus_text;


    } else {
        return "";
    }
    
}



















function customerDate_text( $policy_data = false, $insured_data = false ){ //customerdate
    if( $policy_data !== false  ){
        //make conditions here
        $customerDate_text = "";

        if( isset( $policy_data['customerdate'] ) && $policy_data['customerdate'] ){
            $customerDate_text = date( "m", strtotime( $policy_data['customerdate'] ) )."/".date( "d", strtotime( $policy_data['customerdate'] ) )."/".date( "y", strtotime( $policy_data['customerdate'] ) );
        } else {
            $customerDate_text = "//";
        }



        return $customerDate_text;

    } else {
        return "";
    }
    
}



















function sobFileName( $policy_data = false, $insured_data = false ){ //insured-name, insured-phone
    if( $policy_data !== false || $insured_data !== false  ){
        //make conditions here
        $sobFileName = "";

        if( isset( $insured_data['name'] ) && $insured_data['name'] ){
            $sobFileName = $insured_data['name'];
        }

        if( isset( $insured_data['phone'] ) && $insured_data['phone'] ){
            $sobFileName = $sobFileName."_".$insured_data['phone'];
        }

        $sobFileName = $sobFileName."_";



        return $sobFileName;


    } else {
        return "";
    }
    
}



















function appFileName( $policy_data = false, $insured_data = false ){ //insured-name, insured-phone
    if( $policy_data !== false || $insured_data !== false  ){
        //make conditions here
        $appFileName = "";

        if( isset( $insured_data['name'] ) && $insured_data['name'] ){
            $appFileName = $insured_data['name'];
        }

        if( isset( $insured_data['phone'] ) && $insured_data['phone'] ){
            $appFileName = $appFileName."_".$insured_data['phone'];
        }

        $appFileName = $appFileName."_";



        return $appFileName;


    } else {
        return "";
    }
    
}











































//insured formula field
function insured_age( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //insured-dob
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here
        if( isset( $insured_data['dob'] ) && isset( $insured_data['dob'] ) ){

            $date1 = new DateTime( date("Y-m-d", strtotime( date("Y-m-d") )) );
            $date2 = new DateTime( $insured_data['dob'] );

            $diff = $date1->diff($date2);

            return abs( $diff->y );

        }







        return "";


    } else {
        return "";
    }
    

}





//insured formula field
function insured_age2( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //insured-dob
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here
        if( isset( $insured_data['dob'] ) && isset( $insured_data['dob'] ) ){

            $date1 = new DateTime( date("Y-m-d", strtotime( date("Y-m-d") )) );
            $date2 = new DateTime( $insured_data['dob'] );

            $diff = $date1->diff($date2);

            return abs( $diff->y );

        }







        return "";


    } else {
        return "";
    }
    

}










function accountName( $policy_data = false, $insured_data = false ){ //insured-name
    if( $policy_data !== false && $insured_data !== false ){
        //make conditions here
        if( isset( $insured_data['name'] ) && $insured_data['name'] ){
            return $insured_data['name']; // return count of years
        }



        return "";


    } else {
        return "";
    }
    
}







//insured formula field
function insured_accountName( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //primaryfirstname, primarylastname
    if( $insured_data !== false  ){
        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here

        if( isset( $insured_data['primaryfirstname'] ) && isset( $insured_data['primarylastname'] ) ){
            return $insured_data['primaryfirstname']." ".$insured_data['primarylastname'];
        }







        return "";

    } else {
        return "";
    }
    

}











function insured_medicaid( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //medicaidid
    if( $insured_data !== false  ){
        if( isset( $insured_data['medicaidid'] ) && $insured_data['medicaidid'] ){
            return true;
        }
    }


    return false;
}







function insured_fullAddress( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //primarystreetadress, primarycity, primarystate, primaryzippostalcode
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here
        $full_address = "";

        if( isset( $insured_data['primarystreetadress'] ) ){
            $full_address = $insured_data['primarystreetadress'];
        }

        if( isset( $insured_data['primarycity'] ) ){
            $full_address = $full_address.",".$insured_data['primarycity'];
        }

        
        if( isset( $insured_data['primarystate'] ) ){
            $full_address = $full_address.",".$insured_data['primarystate'];
        }

        
        if( isset( $insured_data['primaryzippostalcode'] ) ){
            $full_address = $full_address.",".$insured_data['primaryzippostalcode'];
        }

        


        return $full_address;

    } else {
        return "";
    }
}







function insured_fullMailingAddress( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //mailingstreetaddress, mailingcity, mailingstateprovince, mailingzippostalcode
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/






        //make conditions here
        $full_mailing_address = "";

        if( isset( $insured_data['mailingstreetaddress'] ) ){
            $full_mailing_address = $insured_data['mailingstreetaddress'];
        }

        if( isset( $insured_data['mailingcity'] ) ){
            $full_mailing_address = $full_mailing_address.",".$insured_data['mailingcity'];
        }

        
        if( isset( $insured_data['mailingstateprovince'] ) ){
            $full_mailing_address = $full_mailing_address.",".$insured_data['mailingstateprovince'];
        }

        
        if( isset( $insured_data['mailingzippostalcode'] ) ){
            $full_mailing_address = $full_mailing_address.",".$insured_data['mailingzippostalcode'];
        }

        


        return $full_mailing_address;

    } else {
        return "";
    }
}







//insured formula field
function insured_salutation( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ // gender
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here
        if( isset( $insured_data['gender'] ) && $insured_data['gender'] ){
            if( ucfirst( strtolower( str_replace(" ", "", $insured_data['gender']) ) ) == "Male" ){
                return "Mr.";
            } else if( ucfirst( strtolower( str_replace(" ", "", $insured_data['gender']) ) ) == "Female" ){
                return "Mrs.";
            }
        }







        return "";

    } else {
        return "";
    }
    

}


function insured_ageRange( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //insured-dob
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here
        if( isset( $insured_data['dob'] ) && isset( $insured_data['dob'] ) ){

            $date1 = new DateTime( date("Y-m-d", strtotime( date("Y-m-d") )) );
            $date2 = new DateTime( $insured_data['dob'] );

            $diff = $date1->diff($date2);

            $age = abs( $diff->y );


            if( $age >= 9 && $age <= 21 ){
                return "20 & Under";
            } else if(  $age >= 20 && $age <= 29  ){
                return "20-29";
            } else if(  $age >= 30 && $age <= 39  ){
                return "30-39";
            } else if(  $age >= 40 && $age <= 49  ){
                return "40-49";
            } else if(  $age >= 50 && $age <= 59  ){
                return "50-59";
            } else if(  $age >= 60 && $age <= 64  ){
                return "60-64";
            } else if(  $age == 65  ){
                return "65";
            } else if(  $age == 66  ){
                return "66";
            } else if(  $age == 67  ){
                return "67";
            } else if(  $age == 68  ){
                return "68";
            } else if(  $age == 69  ){
                return "69";
            } else if(  $age >= 70 && $age <= 79  ){
                return "70-79";
            } else if(  $age >= 80 && $age <= 89  ){
                return "80-89";
            } else if(  $age >= 90 && $age <= 99  ){
                return "90-99";
            } else if(  $age >= 100 ){
                return "100+";
            }


        }







        return "";


    } else {
        return "";
    }
    

}
















//insured formula field
function insured_totalCommission( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){ //commission2020, commission2021
    if( $insured_data !== false  ){



        $total_commission = 0;



        $total_commission_2020 = 0;
        $total_commission_2021 = 0;

        
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    if( isset( $policy_data['commission2020'] ) ){
                        $total_commission_2020 = $total_commission_2020+( abs( $policy_data['commission2020'] ) );
                    }


                    if( isset( $policy_data['commission2021'] ) ){
                        $total_commission_2021 = $total_commission_2021+( abs( $policy_data['commission2021'] ) );
                    }








                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////







        //make conditions here
        $total_commission = $total_commission_2020+$total_commission_2021;
        
        return (number_format($total_commission, 8, '.', ''));







        return (number_format(0, 8, '.', ''));

    } else {
        return (number_format(0, 8, '.', ''));
    }
    

}


















//insured formula field
function insured_sample_string( $insured_data = false, $related_policy_by_id = false, $policy_ids_by_insured_id = false ){
    if( $insured_data !== false  ){

        /*
        ///////////////////IF REQUIRED POLICY FIELDS////////////////
        if( isset( $policy_ids_by_insured_id[ $insured_data['id'] ] ) && is_array( $policy_ids_by_insured_id[ $insured_data['id'] ] ) ){
            $related_policy_ids = $policy_ids_by_insured_id[ $insured_data['id'] ];

            foreach( $related_policy_ids as $related_policy_id ){
                $policy_data = [];
                if( isset( $related_policy_by_id ) && is_array( $related_policy_by_id ) && isset( $related_policy_by_id[ $related_policy_id ] ) && is_array( $related_policy_by_id[ $related_policy_id ] ) ){
                    $policy_data = $related_policy_by_id[ $related_policy_id ];








                    print_r( $policy_data );
                    exit();









                    //End policy Loop
                } else {
                    //policy not found in collection array
                }
            }
        }
        ///////////////////IF REQUIRED POLICY FIELDS////////////////*/







        //make conditions here








        return "";

    } else {
        return "";
    }
    

}



function sample_string( $policy_data = false, $insured_data = false ){
    if( $policy_data !== false  ){
        //make conditions here



        return "";


    } else {
        return "";
    }
    
}









?>
