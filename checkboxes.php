<?php
q1Count - +
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=314&chain=1
If([Is Active]= false and [CS DATE YEAR] = 2020 and [Customer Date  Policy Quarter]="1" and [Customer Date  Policy Quarter]!=[Cancel Policy Quarter],true,false)



commissionPaid
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=330&chain=1
If([
# of Humana Commissions]>0 
	or 
[# of Wellcare commissions]>0 and [# of Wellcare Chargeback] = 0 /////////////
	or
	[# of GPM commissions]>0 ////////////////
	or 
	[# of Aetna commissions]>0 //////////////
	or
	[# of Humana Commissions]>0 ////////////////redundunt
	or
	[# of Cigna commissions]>0 ////////////
	or
	[# of Anthem commissions]>0 /////////////
	or
	[# of Humana Commissions]>0 //////////redundunt
	or
	[# of Aetna supp commissions]>0 /////////////////
	or
	[# of UHC Commissions]>0 and [# of UHC Chargebacks]=0  //////////////
	,true,false)


# of Humana Commissions
# of Wellcare commissions
# of Wellcare Chargeback
# of GPM commissions
# of Aetna commissions
# of Humana Commissions
# of Cigna commissions
# of Anthem commissions
# of Humana Commissions
# of Aetna supp commissions
# of UHC Commissions
# of UHC Chargebacks





chargedBack
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=351&chain=1
If([UHC 2023 CB] < 0, true ,
	If([UHC 2022 CB] < 0, true ,
		If([2021 UHC CB] < 0, true ,
			If([2020 UHC CB] < 0, true ,
				If([Medico 2023 CB] < 0, true ,
					If([Medico 2022 CB] < 0, true ,
						If([Medico 2021 CB] < 0, true ,
							If([Medico 2020 CB] < 0, true ,
								If([Wellcare 2023 CB] < 0, true,
									If([Wellcare 2022 CB] < 0, true,
										If([2021 Wellcare CB] < 0, true,
											If([2020 Wellcare CB] < 0, true,
												If([Humana 2023 CB] < 0, true,
													If([Humana 2022 CB] < 0, true,
														If([2021 Humana CB] < 0, true,
															If([2020 Humana CB] < 0, true,
																If([GPM 2023 CB] < 0, true,
																	If([GPM 2022 CB] < 0, true,
																		If([2021 GPM CB] < 0, true,
																			If([2020 GPM CB] < 0, true,
																				If([Cigna Adv 2023 CB] < 0, true,
																					If([Cigna 2022 CB] < 0, true,
																						If([2021 Cigna Adv CB] < 0, true,
																							If([2020 Cigna Adv CB] < 0, true,
																								If([Anthem 2023 CB] < 0, true,
																									If([Anthem 2022 CB] < 0, true,
																										If([2021 Anthem CB] < 0, true,
																											If([2020 Anthem CB] < 0, true,
																												If([Aetna Adv 2023 CB] < 0, true,
																													If([Aetna Adv 2022 CB] < 0, true,
																														If([2021 Aetna Adv CB] < 0, true,
																															If([2020 Aetna Adv CB] < 0, true,
																																If([Aetna Supp 2023 CB] < 0, true,
																																	If([Aetna Supp 2022 CB] < 0, true,
																																		If([2021 Aetna Supp CB] < 0, true,
																																			If([2020 Aetna Supp CB] < 0, true,
																																				If([Aetna Adv 2023 CB] < 0, true,
																																					If([Aetna Adv 2022 CB] < 0, true,
																																						If([2021 Aetna Adv CB] < 0, true,
																																							If([2020 Aetna Adv CB] < 0, true,false
																																						))))))))))))))))))))))))))))))))))))))))


chargeBackCommission
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=352&chain=1
If([Life Time Commission] < 0,true,false)



isPlaced
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=500&chain=1
If([Status]="Cancelled" or [Status]="Issued" or [Status]="Rewrite" or [Status]="Deceased" or [Status]="Successful Resubmission", true , false )



isChurn
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=502&chain=1
If([Status]="Cancelled", true , false )



isIssued
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=501&chain=1
If([Status]="Cancelled" or [Status]="Withdrawn" or [Status]="Issued" or [Status]="Rewrite" or [Status]="Deceased", true , false )



pastRD
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=536&chain=1
ToDays([Effective Date] - Today()) > 90



sfdnc
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=644&chain=1
[Plan Duration]> 90 
and 
[Carrier]="Humana" 
or  [Carrier]="Anthem" 
or  [Carrier]="Anthem Blue Cross and Blue Shield" 
or [Carrier]="Anthem H1732-003"



paidHRA
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=716&chain=1
If([AETNA ADV PAID HRA]=1 or
[AETNA SF PAID HRA]=1 or
[AETNA SUPP PAID HRA]=1 or
[AFLAC PAID HRA]=1 or
[AMERITAS PAID HRA]=1 or
[ANTEHM PAID HRA]=1 or
[ANTHEM SF PAID HRA]=1 or
[CIGNA PAID HRA]=1 or
[GPM PAID HRA]=1 or
[HUMANA PAID HRA]=1 or
[HUMANA SF PAID HRA]=1 or
[MEDICO PAID HRA]=1 or
[UHC PAID HRA ]=1 or
[WELLCARE PAID HRA]=1 or
[WELLCARE SF PAID HRA]=1,true,false)



payout - +
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=94&chain=1
[Commission]*[Premium ]

If ([Payroll override] = true, 0, If ([Plan - Requires lifetime limit exception] = true and [Health Lifetime Limit] = "100000", 0, If ([House Deal], 0, 
  If([Is Active] = true and [Insured - Age]>58 and [Plan - 59+ (Age)] > 0 , [Plan - 59+ (Age)], 
      If ( [Term Duration] < 90 and [Plan - STM90ORLESS] > 0 ,   [Plan - STM90ORLESS],
            If([Is Active] = true and [Plan - Plan Type] = "STM" and [Insured - # of Approved ANC] = 0,
                If([Plan - W/O ANC] = null, [Plan - FLAT],[Plan - W/O ANC]) , 
                  If([Is Active] = true and [Plan - Plan Type] = "STM" and [Insured - # of Approved ANC] = 1,
                    If([Plan - W/1 ANC]= null, [Plan - FLAT],[Plan - W/1 ANC]) , 
                      If([Is Active] = true and [Plan - Plan Type] = "Limited Medical" and [Insured - # of Approved ANC] = 1,
                        If([Plan - W/1 ANC] = null, [Plan - FLAT],[Plan - W/1 ANC]) , 
                          If([Is Active] = true and [Plan - Plan Type] = "Limited Medical" and [Insured - # of Approved ANC] >= 2,
                            If([Plan - W/2 ANC] = null, [Plan - FLAT],[Plan - W/2 ANC]) ,
                              If([Is Active] = true and [Plan - Plan Type] = "STM" and [Insured - # of Approved ANC] >= 2,
                                If([Plan - W/2 ANC] = null, [Plan - FLAT],[Plan - W/2 ANC]) ,
                                  If([Is Active] = true and [Plan - Plan Type] != "STM" , [Plan - FLAT],
                                    If([Is Active] = true and [Plan - Plan Type] != "Limited Medical" , [Plan - FLAT],0 ))))))))))))








sfDate
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=645&chain=1
If([Is Cancel]=true,

If(
	[Cancel Date] = null ,Today(),[Cancel Date]
),
	
[Is Decline]=true, 

If(
	[Decline Date]=null ,Today(),[Decline Date]
),Today()

)



dateSubmittedToVerification - +
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=19&chain=1
If([VER time override]=null,[Date Created],[Manual Ver Time Entry])



planTypeCheck - + 
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=205&chain=1
If([Plan - Plan Type]=null, false, true)



isDecline - +
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=256&chain=1
If([Status]="Declined Carrier", true , false )



isCancel - +
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=257&chain=1
If([Status]="Cancelled" or [Status]="Withdrawn" or [Status]="Declined Carrier" or [Status]="Incomplete" or [Status]="Not Issued Withdrawn" or [Status]="Deceased" or [Status]="Future Pay Cancel" or [Status]="Initial Decline Payment Cancel" or [Status]="Initial Payment Decline" or [Status]="Payment Decline Cancel" or [Status]="Rescinded" or [Status]="No Signature" or [Status]="Successful Resubmission" or [Status]="Successful Resubmission Mark's Cancel" or [Status]="Successful Resubmission Mark's AEP Cancel" or [Status]="Marx AEP Cancel" or [Status]="Successful Resubmission NIW" or [Status]="Successful Resubmission Withdrawn" or [Status]="Marx Withdrawn", true , false )








chargeBack - dup issue
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=351&chain=1























































carrierCommissions
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=397&chain=1
[2021 Commission]+[2020 Commission]+[2022 Commission]+[2023 Commission]




revenue - basic - done but needed update on the field target
Revenue=(Commission-Chargebacks)







isNotIssuedCXL - checkbox - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=302&chain=1
If([Status]="Withdrawn" and ([Cancel Policy Quarter]= [Effective Policy Quarter]), true , false )






isEndOfQuarterActive - checkbox - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=306&chain=1
If([Status]="Awaiting Payment Verification" or 
	[Status]="Issued" or 
	[Status]="Pending Underwriting" or 
	[Status]="Underwriting Request Pending" or 
	[Status]="Pending Additional Info" or 
	[Status]="Medicaid Status Pending" or 
	([Status]="Withdrawn" and [Cancel Date]<"03/31/2020", true , false )








cancelLifespan - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=296&chain=1
[Cancel Date]-[Effective Date]







declineLifespan - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=298&chain=1
[Decline Date]-[Customer Date]






ageAtSale - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=389&chain=1
([Effective Date]-[Related Insured3 - DOB])







daysEffective - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=489&chain=1
Today() - [Effective Date]







termDuration - existing func - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=96&chain=1
ToDays([Term Date]-[Issue Date])






annualizedPremium - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=156&chain=1
[Premium ]*12






planDurationCalc - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=303&chain=1
If([Status]="Issued",ToDays(Today()-[Effective Date]), 
	If([Status]="Declined Carrier",
		0, 
else
		If([Status]="Cancelled" ,
			ToDays([Cancel Date]-[Effective Date]), 
else
			If([Status]="Withdrawn" ,
				ToDays([Cancel Date]-[Effective Date]), 
else
				If([Status]="Successful Resubmission Withdrawn" ,
					ToDays([Cancel Date]-[Effective Date]), 
else					
					If([Status]="Incomplete",
						0,
else
						If([Status]="Not Issued Withdrawn"
							,0
							,0
						)))))))





planDuration - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=305&chain=1
ToDays([SFDATE]-[Effective Date])






csDateYear - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=316&chain=1
Year([Customer Date])





qaNumber - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=229&chain=1
[Related Insured3 - Phone]





agentFirstName - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=198&chain=1
If([Sales Rep]=("co_albertomoreno"),
	"Alberto",

	If([Sales Rep]=("co_caitlinmchale"),
		"Caitlin",

		If([Sales Rep]=("co_kimberlykinkead"),
			"Kimberly",

			If([Sales Rep]=("co_racheallanneaux"),
				"Racheal",

				If([Sales Rep]=("co_sydneeallen"),
					"Sydnee",

					If([Sales Rep]=("co_warrenwilson"),
						"Warren",

						If([Sales Rep]=("co_patriciamcgriff"),
							"Patricia",

							If([Sales Rep]=("co_everettelemont"),
								"Everette",

								If([Sales Rep]=("co_roseaugustin"),
									"Rose",

									If([Sales Rep]=("co_essencejones"),
										"Essence",

										If([Sales Rep]=("co_jessbaldonado"),
											"Jessica",

											If([Sales Rep]=("co_carmenjoseph"),
												"Carmen",

												If([Sales Rep]=("co_carleitowynter"),
													"Carleito",

													If([Sales Rep]=("co_kelvinmajano"),
														"Kelvin",

														If([Sales Rep]=("co_chrisramos"),
															"Chris",

															If([Sales Rep]=("co_courtneyscrivens"),
																"Courtney",

																""))))))))))))))))




effectivePolicyQuarter - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=308&chain=1
If(
Month([Effective Date])<=3,"1",
Month([Effective Date])<=6,"2",
Month([Effective Date])<=9,"3",
Month([Effective Date])<=12,"4",
"0")







cancelPolicyQuarter - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=309&chain=1
If(
Month([Cancel Date])<=3,"1",
Month([Cancel Date])<=6,"2",
Month([Cancel Date])<=9,"3",
Month([Cancel Date])<=12,"4",
"0")






customerDatePolicyQuarter - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=315&chain=1
If(
Month([Cancel Date])<=3,"1",
Month([Cancel Date])<=6,"2",
Month([Cancel Date])<=9,"3",
Month([Cancel Date])<=12,"4",
"0")







ageRange - basic - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=388&chain=1
If(([Age]>=9 and [Age]<=64),
	"1. Under 65",

	If(([Age]>=65 and [Age]<=70),
		"2. 65-70",

		If(([Age]>=80 and [Age]<=120),
			"5. Over 80",

			If(([Age]>=71 and [Age]<=75),
				"3. 71-75",

				If(([Age]>=76 and [Age]<=79),
					"4. 76-79")))))





lun -basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=493&chain=1
If([Part D In This Plan Year]=true or 
	[Part D End of Last Plan Year]=true,
	"Unlike",

	If( [No Previous Medicare Adv or Part D Plan]=true,
		"New",

		"Like"))







effDATE_text - basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=496&chain=1
ToText(Month([Effective Date]))&"/"&ToText(Day([Effective Date]))&"/"&ToText(Year([Effective Date]))
in short = m/d/Y



cancelDate_text - basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=497&chain=1
ToText(Month([Cancel Date]))&"/"&ToText(Day([Cancel Date]))&"/"&ToText(Year([Cancel Date]))
in short = m/d/Y




dsStatus_text - basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=498&chain=1
ToText(Month(ToDate([Date Submitted to Verification])))&"/"&ToText(Day(ToDate([Date Submitted to Verification]))&"/"&ToText(Year(ToDate([Date Submitted to Verification]))))&"|"&[Status]&"|"&[Plan - Plan Type]&"|"&[Carrier]&"|"&ToText(Month([Cancel Date]))&"/"&ToText(Day([Cancel Date]))&"/"&ToText(Year([Cancel Date]))
/= m/d/Y|status|Plan - Plan Type|Carrier|m/d/Y


customerDate_text - basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=699&chain=1
ToText(Month([Customer Date]))&"/"&ToText(Day([Customer Date]))&"/"&ToText(Year([Customer Date]))
in short = m/d/Y



sobFileName - basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=752&chain=1
[Related Insured3 - Account Name]&"_"&[Related Insured3 - Phone]&"_"&[SOB]
use sobfilename 



appFileName - basic
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=753&chain=1
[Related Insured3 - Account Name]&"_"&[Related Insured3 - Phone]&"_"&[APP]
use appfilename





noCommissionUploaded - checkbox - skip
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=410&chain=1
	If([# of UHC Commissions] > 0,

		If([# of UHC Chargebacks] > 0, 
		true, 

		true,

		If([# of Humana Commissions] > 0, 
		true,

		If([# of Humana Chargebacks] > 0, 
		true,
		If([# of Wellcare commissions] > 0, 
		true,
		If([# of Wellcare Chargeback] > 0, 
		true,
		If([# of Medico commissions] > 0, 
		true,
		If([# of Medico Chargebacks] > 0, 
		true,
		If([# of GPM commissions] > 0, 
		true,
		If([# of GPM Chargebacks] > 0, 
		true,
		If([# of Cigna commissions] > 0, 
		true,If([# of Cigna Adv Chargebacks] > 0, 
		true,If([# of Anthem commissions] > 0, 
		true,If([# of Anthem Chargebacks] > 0, 
		true,If([# of Aetna commissions] > 0, 
		true,
		If([# of Aetna Adv Chargebacks] > 0, 
		true,
		If([# of Aetna supp commissions] > 0, 
		true,
		If([# of Aetna supp Chargebacks] > 0, 
		true,
		false))))))))))))))))))




commission2021 - skip
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=344&chain=1
	If([Carrier]="UHC", 
		[2021 UHC Commission]+[2021 UHC CB],
	else
		If([Carrier]="Humana", 
			[2021 Humana Commission]+[2021 Humana CB],
		else
			If([Carrier]="Anthem", 
				[2021 Anthem Commission]+[2021 Anthem CB],
			else
				If([Carrier]="Aetna", 
				[2021 Aetna Adv Commission]+[2021 Aetna Adv CB],

				If([Carrier]="Aetna Supp", 
					[2021 Aetna Sup Commission]+[2021 Aetna Supp CB],
				else
					If([Carrier]="Medico", 
						[Medico 2021 Commission]+[Medico 2021 CB],
					else
						If([Carrier]="Cigna Adv", 
							[2021 Cigna Adv Commission]+[2021 Cigna Adv CB],
						else
						If([Carrier]="GPM", 
							[2021 GPM Commission]+[2021 GPM CB],
						else
							If([Carrier]="Wellcare", 
								[2021 Wellcare Commission]+[2021 Wellcare CB],
							else
								If([Carrier]="Humana", 
									[2020 Humana Commission]+[2020 Humana CB],
								else
									If([Carrier]="HumanaSF", 
										[HumanaSF 2021 Commission]+[HumanaSF 2021 CB],
									else
										If([Carrier]="Ameritas", 
											[Ameritas  2021 Commission]+[Ameritas 2021 CB],
										else
											If([Carrier]="AnthemSF", 
												[AnthemSF 2021 Commission]+[AnthemSF 2021 CB]
											else
												,0
											)))))))))))))




commission2022 - skip
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=698&chain=1
	If([Carrier]="UHC", 
		[2022 UHC Commission]+[2022 UHC CB],
	else
		If([Carrier]="Humana", 
			[2022 Humana Commission]+[2022 Humana CB],
		else
			If([Carrier]="Anthem", 
				[2022 Anthem Commission]+[2022 Anthem CB],
			else
				If([Carrier]="Aetna", 
				[2022 Aetna Adv Commission]+[2022 Aetna Adv CB],

				If([Carrier]="Aetna Supp", 
					[2022 Aetna Sup Commission]+[2022 Aetna Supp CB],
				else
					If([Carrier]="Medico", 
						[Medico 2022 Commission]+[Medico 2022 CB],
					else
						If([Carrier]="Cigna Adv", 
							[2022 Cigna Adv Commission]+[2022 Cigna Adv CB],
						else
						If([Carrier]="GPM", 
							[2022 GPM Commission]+[2022 GPM CB],
						else
							If([Carrier]="Wellcare", 
								[2022 Wellcare Commission]+[2022 Wellcare CB],
							else
								If([Carrier]="Humana", 
									[2020 Humana Commission]+[2020 Humana CB],
								else
									If([Carrier]="HumanaSF", 
										[HumanaSF 2022 Commission]+[HumanaSF 2022 CB],
									else
										If([Carrier]="Ameritas", 
											[Ameritas  2022 Commission]+[Ameritas 2022 CB],
										else
											If([Carrier]="AnthemSF", 
												[AnthemSF 2022 Commission]+[AnthemSF 2022 CB]
											else
												,0
											)))))))))))))



commission2023 - skip
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=751&chain=1
	If([Carrier]="UHC", 
		[2023 UHC Commission]+[2023 UHC CB],
	else
		If([Carrier]="Humana", 
			[2023 Humana Commission]+[2023 Humana CB],
		else
			If([Carrier]="Anthem", 
				[2023 Anthem Commission]+[2023 Anthem CB],
			else
				If([Carrier]="Aetna", 
				[2023 Aetna Adv Commission]+[2023 Aetna Adv CB],

				If([Carrier]="Aetna Supp", 
					[2023 Aetna Sup Commission]+[2023 Aetna Supp CB],
				else
					If([Carrier]="Medico", 
						[Medico 2023 Commission]+[Medico 2023 CB],
					else
						If([Carrier]="Cigna Adv", 
							[2023 Cigna Adv Commission]+[2023 Cigna Adv CB],
						else
						If([Carrier]="GPM", 
							[2023 GPM Commission]+[2023 GPM CB],
						else
							If([Carrier]="Wellcare", 
								[2023 Wellcare Commission]+[2023 Wellcare CB],
							else
								If([Carrier]="Humana", 
									[2020 Humana Commission]+[2020 Humana CB],
								else
									If([Carrier]="HumanaSF", 
										[HumanaSF 2023 Commission]+[HumanaSF 2023 CB],
									else
										If([Carrier]="Ameritas", 
											[Ameritas  2023 Commission]+[Ameritas 2023 CB],
										else
											If([Carrier]="AnthemSF", 
												[AnthemSF 2023 Commission]+[AnthemSF 2023 CB]
											else
												,0
											)))))))))))))




commission2020 - skip
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=345&chain=1
	If([Carrier]="UHC", 
		[2020 UHC Commission]+[2020 UHC CB],
	else
		If([Carrier]="Humana", 
			[2020 Humana Commission]+[2020 Humana CB],
		else
			If([Carrier]="Anthem", 
				[2020 Anthem Commission]+[2020 Anthem CB],
			else
				If([Carrier]="Aetna", 
				[2020 Aetna Adv Commission]+[2020 Aetna Adv CB],

				If([Carrier]="Aetna Supp", 
					[2020 Aetna Sup Commission]+[2020 Aetna Supp CB],
				else
					If([Carrier]="Medico", 
						[Medico 2020 Commission]+[Medico 2020 CB],
					else
						If([Carrier]="Cigna Adv", 
							[2020 Cigna Adv Commission]+[2020 Cigna Adv CB],
						else
						If([Carrier]="GPM", 
							[2020 GPM Commission]+[2020 GPM CB],
						else
							If([Carrier]="Wellcare", 
								[2020 Wellcare Commission]+[2020 Wellcare CB],
							else
								If([Carrier]="Humana", 
									[2020 Humana Commission]+[2020 Humana CB],
								else
									If([Carrier]="HumanaSF", 
										[HumanaSF 2020 Commission]+[HumanaSF 2020 CB],
									else
										If([Carrier]="Ameritas", 
											[Ameritas  2020 Commission]+[Ameritas 2020 CB],
										else
											If([Carrier]="AnthemSF", 
												[AnthemSF 2020 Commission]+[AnthemSF 2020 CB]
											else
												,0
											)))))))))))))


lifeTimeCommission - existing func - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=346&chain=1
[2020 Commission]+[2021 Commission]+[2022 Commission]+[2023 Commission]



commission - existing func - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=67&chain=1
If ([Payroll override] = true, 0, If ([Plan - Requires lifetime limit exception] = true and [Health Lifetime Limit] = "100000", 0, If ([House Deal], 0, 
  If([Is Active] = true and [Insured - Age]>58 and [Plan - 59+ (Age)] > 0 , [Plan - 59+ (Age)], 
      If ( [Term Duration] < 90 and [Plan - STM90ORLESS] > 0 ,   [Plan - STM90ORLESS],
            If([Is Active] = true and [Plan - Plan Type] = "STM" and [Insured - # of Approved ANC] = 0,
                If([Plan - W/O ANC] = null, [Plan - FLAT],[Plan - W/O ANC]) , 
                  If([Is Active] = true and [Plan - Plan Type] = "STM" and [Insured - # of Approved ANC] = 1,
                    If([Plan - W/1 ANC]= null, [Plan - FLAT],[Plan - W/1 ANC]) , 
                      If([Is Active] = true and [Plan - Plan Type] = "Limited Medical" and [Insured - # of Approved ANC] = 1,
                        If([Plan - W/1 ANC] = null, [Plan - FLAT],[Plan - W/1 ANC]) , 
                          If([Is Active] = true and [Plan - Plan Type] = "Limited Medical" and [Insured - # of Approved ANC] >= 2,
                            If([Plan - W/2 ANC] = null, [Plan - FLAT],[Plan - W/2 ANC]) ,
                              If([Is Active] = true and [Plan - Plan Type] = "STM" and [Insured - # of Approved ANC] >= 2,
                                If([Plan - W/2 ANC] = null, [Plan - FLAT],[Plan - W/2 ANC]) ,
                                  If([Is Active] = true and [Plan - Plan Type] != "STM" , [Plan - FLAT],
                                    If([Is Active] = true and [Plan - Plan Type] != "Limited Medical" , [Plan - FLAT],0 ))))))))))))


planDurationRange - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=693&chain=1
If(([Plan Duration-calc]<=0), "A. Less than 1 Day",If(([Plan Duration-calc]>=1 and [Plan Duration-calc]<=30), "B. 1st Month",If(([Plan Duration-calc]>=31 and [Plan Duration-calc]<=62),"C. 2nd Month",If(([Plan Duration-calc]>=63 and [Plan Duration-calc]<=94),"D. 3rd Month",If(([Plan Duration-calc]>=95 and [Plan Duration-calc]<=126),"E. 90-120 Days",If(([Plan Duration-calc]>=127 and [Plan Duration-calc]<=158),"F. 4th Month",If(([Plan Duration-calc]>=159 and [Plan Duration-calc]<=190),"F. 5th Month",If(([Plan Duration-calc]>=191 and [Plan Duration-calc]<=365),"180 Days to One Year",If(([Plan Duration-calc]>=366),"G. Over One Year","")))))))))



durationRange - done
https://coverageoneinsurance.quickbase.com/db/bpt5murak?a=mf&fid=453&chain=1
If(([Plan Duration-calc]<=0), "A. Less than 1 Day",If(([Plan Duration-calc]>=1 and [Plan Duration-calc]<=30), "B. 1st Month",If(([Plan Duration-calc]>=31 and [Plan Duration-calc]<=62),"C. 2nd Month",If(([Plan Duration-calc]>=63 and [Plan Duration-calc]<=94),"D. 3rd Month",If(([Plan Duration-calc]>=95 and [Plan Duration-calc]<=126),"E. 4th Month",If(([Plan Duration-calc]>=127 and [Plan Duration-calc]<=158),"F. 5th Month",If(([Plan Duration-calc]>=159 and [Plan Duration-calc]<=190),"G. 6th Month",If(([Plan Duration-calc]>=191 and [Plan Duration-calc]<=365),"H. 180 Days to One Year",If(([Plan Duration-calc]>=366),"I. Over One Year","")))))))))





















./////////////////////////////////////////////////// INSURED /////////////////////////////////////////////////////////////
medicaid - checkbox
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=178&chain=1
If([Medicaid ID]!= null ,true,false)


age
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=65&chain=1
(Year(Today())-Year([DOB])-1)+
If(Month(Today())>Month([DOB]),1,0)+
If(Month(Today())=Month([DOB]) and Day(Today())>=Day([DOB]),1,0)


age2
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=164&chain=1
(Year(Today())-Year([DOB])-1)+
If(Month(Today())>Month([DOB]),1,0)+
If(Month(Today())=Month([DOB]) and Day(Today())>=Day([DOB]),1,0)


accountName
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=6&chain=1
[Primary First Name]&" "&[Primary Last Name]


fullAddress
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=57&chain=1
[Primary Street Adress]&","&[Primary City]&","&[Primary State]&","&[Primary Zip/Postal Code]


fullMailingAddress
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=150&chain=1
[Mailing Street Address]&","&[Mailing City]&","&[Mailing State/Province]&","&[Mailing Zip/Postal Code]


salutation
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=157&chain=1
If([Gender]=("Male"),"Mr.",If([Gender]=("Female"),"Ms.",""))


ageRange
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=195&chain=1
If(([Age]>=9 and [Age]<=21), 
"20 & Under",

	If(([Age]>=20 and [Age]<=29), 
	"20-29",

		If(([Age]>=30 and [Age]<=39),
		"30-39",

		If(([Age]>=40 and [Age]<=49),
		"40-49",

		If(([Age]>=50 and [Age]<=59),
		"50-59",

		If(([Age]>=60 and [Age]<=64),
		"60-64",

		If(([Age]=65),
		"65",

		If(([Age]=66),
		"66",

		If(([Age]=67),
		"67",

		If(([Age]=68),
		"68",

		If(([Age]=69),
		"69",

		If(([Age]>=70 and [Age]<=79),
		"70-79",

		If(([Age]>=80 and [Age]<=89),
		"80-89",

		If(([Age]>=90 and [Age]<=99),
		"90-99",

		If(([Age]>=100),
		"100+",

		"")))))))))))))))



totalCommissions
https://coverageoneinsurance.quickbase.com/db/bpt5muraf?a=mf&fid=194&chain=1
[Total 2021 Commission]+[Total 2020 Commission]


total 2021 Commission
total 2020 Commission


total 2021 commission is policies's formula field,
we don't have to make commission formula, we will just SUM all total result from each policies "commission total" field