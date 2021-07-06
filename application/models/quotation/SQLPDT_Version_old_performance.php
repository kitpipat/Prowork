$tSQL = "
				SELECT Q.* FROM(
				 SELECT P.* , ROW_NUMBER() OVER(ORDER BY P.RowID ASC) AS NewRowID FROM (
                 SELECT ROW_NUMBER() OVER(ORDER BY PDT.FTPdtBestsell DESC , PDT.FTPdtCode ASC) AS RowID,
                         PDT.FTPdtCode,
                         PDT.FTPdtName,
                         PGP.FTPgpName,
                         PDT.FTPdtImage ,
						 PDT.FTPbnCode,
		   				 PDT.FTMolCode,
						 PDT.FTPtyCode,
						 PDT.FTPzeCode,
						 PDT.FTPgpCode,
                         PDT.FCPdtCostStd,
						 PDT.FTPClrCode,
						 PDT.FTPunCode,
						 PUN.FTPunName,
						 PDT.FTSplCode,
                         PDT.FCPdtCostAFDis,
						 PDT.FTPdtBestsell,
						 PDT.FTPdtStaEditName,
						 BAP.FTPbnName,
						 COP.FTPClrName,
						 MOL.FTMolName,
						 SIZ.FTPzeName,
						 TYP.FTPtyName,
                         PDT.FCPdtSalPrice AS FCPdtStdSalPri ,
                         SP.FCXpdAddPri AS FCPdtUsrSalPri,
                         CASE WHEN ISNULL(PDT.FCPdtSalPrice,0) = 0 AND  ISNULL(SP.FCXpdAddPri,0) = 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0)

                              WHEN ISNULL(PDT.FCPdtSalPrice,0) <> 0 AND  ISNULL(SP.FCXpdAddPri,0) = 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0) + (ISNULL(PDT.FCPdtCostAFDis,0) * ISNULL(PDT.FCPdtSalPrice,0))/100

                              WHEN ISNULL(PDT.FCPdtSalPrice,0) = 0 AND  ISNULL(SP.FCXpdAddPri,0) <> 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0) + (ISNULL(PDT.FCPdtCostAFDis,0) * ISNULL(SP.FCXpdAddPri,0))/100

							  WHEN ISNULL(PDT.FCPdtSalPrice, 0) <> 0 AND ISNULL(SP.FCXpdAddPri, 0) <> 0
							  THEN ISNULL(PDT.FCPdtCostAFDis, 0) + (ISNULL(PDT.FCPdtCostAFDis, 0) * ISNULL(SP.FCXpdAddPri, 0)) / 100
						ELSE 0
						END AS FCPdtNetSalPri
                  	FROM VCN_Products PDT WITH (NOLOCK)
                  	LEFT JOIN ( SELECT * FROM VCN_AdjSalePriActive WITH (NOLOCK) WHERE FTPriGrpID = '" . $tPriceGrp . "' ) SP ON PDT.FTPdtCode = SP.FTPdtCode
                	LEFT JOIN TCNMPdtGrp PGP WITH (NOLOCK) 		ON PDT.FTPgpCode 	= PGP.FTPgpCode
					LEFT JOIN TCNMPdtUnit PUN WITH (NOLOCK) 	ON PDT.FTPunCode 	= PUN.FTPunCode
					LEFT JOIN TCNMPdtBrand BAP WITH (NOLOCK) 	ON PDT.FTPbnCode 	= BAP.FTPbnCode
					LEFT JOIN TCNMPdtColor COP WITH (NOLOCK) 	ON PDT.FTPClrCode 	= COP.FTPClrCode
					LEFT JOIN TCNMPdtModal MOL WITH (NOLOCK) 	ON PDT.FTMolCode 	= MOL.FTMolCode
					LEFT JOIN TCNMPdtSize SIZ WITH (NOLOCK) 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode
					LEFT JOIN TCNMPdtType TYP WITH (NOLOCK) 	ON PDT.FTPtyCode 	= TYP.FTPtyCode
					LEFT JOIN TCNMSpl SPL WITH (NOLOCK) 		ON PDT.FTSplCode 	= SPL.FTSplCode
				) P
            	WHERE  1=1 ";

		//ค้นหาขั้นสูง
		if ($aFilterAdv != '' || $aFilterAdv != null) {
			$tWherePBN  = '';
			$tWhereINPBN = '';
			$tWhereCLR	= '';
			$tWhereINCLR = '';
			$tWherePGP	= '';
			$tWhereINPGP = '';
			$tWhereMOL	= '';
			$tWhereINMOL = '';
			$tWherePZE	= '';
			$tWhereINPZE = '';
			$tWherePTY	= '';
			$tWhereINPTY = '';
			$tWherePUN	= '';
			$tWhereINPUN = '';
			$tWhereSPL	= '';
			$tWhereINSPL = '';
			for ($i = 0; $i < count($aFilterAdv); $i++) {
				$tFilterName 	= $aFilterAdv[$i]['tFilter'];
				$tFilterValue 	= $aFilterAdv[$i]['tValue'];
				switch ($tFilterName) {
					case "PBN":
						$tWhereINPBN .=  "'$tFilterValue'" . ',';
						break;
					case "CLR":
						$tWhereINCLR .=  "'$tFilterValue'" . ',';
						break;
					case "PGP":
						$tWhereINPGP .=  "'$tFilterValue'" . ',';
						break;
					case "MOL":
						$tWhereINMOL .=  "'$tFilterValue'" . ',';
						break;
					case "PZE":
						$tWhereINPZE .=  "'$tFilterValue'" . ',';
						break;
					case "PTY":
						$tWhereINPTY .=  "'$tFilterValue'" . ',';
						break;
					case "PUN":
						$tWhereINPUN .=  "'$tFilterValue'" . ',';
						break;
					case "SPL":
						$tWhereINSPL .=  "'$tFilterValue'" . ',';
						break;
					default:
				}

				if ($i == count($aFilterAdv) - 1) {
					$tWhereINPBN = substr($tWhereINPBN, 0, -1);
					$tWhereINCLR = substr($tWhereINCLR, 0, -1);
					$tWhereINPGP = substr($tWhereINPGP, 0, -1);
					$tWhereINMOL = substr($tWhereINMOL, 0, -1);
					$tWhereINPZE = substr($tWhereINPZE, 0, -1);
					$tWhereINPTY = substr($tWhereINPTY, 0, -1);
					$tWhereINPUN = substr($tWhereINPUN, 0, -1);
					$tWhereINSPL = substr($tWhereINSPL, 0, -1);
				}

				if ($tWhereINPBN != '') {
					$tWherePBN = " AND FTPbnCode IN (" . $tWhereINPBN . ")";
				}
				if ($tWhereINCLR != '') {
					$tWhereCLR = " AND FTPClrCode IN (" . $tWhereINCLR . ")";
				}
				if ($tWhereINPGP != '') {
					$tWherePGP = " AND P.FTPgpCode IN (" . $tWhereINPGP . ")";
				}
				if ($tWhereINMOL != '') {
					$tWhereMOL = " AND FTMolCode IN (" . $tWhereINMOL . ")";
				}
				if ($tWhereINPZE != '') {
					$tWherePZE = " AND P.FTPzeCode IN (" . $tWhereINPZE . ")";
				}
				if ($tWhereINPTY != '') {
					$tWherePTY = " AND FTPtyCode  IN (" . $tWhereINPTY . ")";
				}
				if ($tWhereINPUN != '') {
					$tWherePUN = " AND FTPunCode IN (" . $tWhereINPUN . ")";
				}
				if ($tWhereINSPL != '') {
					$tWhereSPL = " AND FTSplCode IN (" . $tWhereINSPL . ")";
				}
			}

			$tWhereFull = $tWherePBN . $tWhereCLR . $tWherePGP . $tWhereMOL . $tWherePZE . $tWherePTY . $tWherePUN . $tWhereSPL;
			$tSQL .= " $tWhereFull ";
		}

		//ค้นหาธรรมดา
		if ($tSearchAll != "") {

			$result['words'] = $segmentQuotation->get_segment_array($tSearchAll);
			$result['words_count'] = count($result['words']);
			if($result['words_count'] != 0){
				$tTextPDTName = '';
				for($i=0; $i<$result['words_count']; $i++){
					$tTextPDTName .= " OR P.FTPdtName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTPbnName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTPClrName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTMolName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTPzeName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTPtyName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTPgpName LIKE '%" .$result['words'][$i] . "%' ";
					// $tTextPDTName .= " OR P.FTPunName LIKE '%" .$result['words'][$i] . "%' ";
				}
			}
			
			$tSQL .= " AND ";
			$tSQL .= " P.FTPdtCode LIKE '%" . $tSearchAll . "%'";
			$tSQL .= $tTextPDTName;
		}

		$tSQL .= " ) AS Q WHERE Q.NewRowID > $aRowLen[0] AND Q.NewRowID <=$aRowLen[1] ";
