<script type="text/javascript">
   $(document).ready(function(){

         FSvQUODocHeader();
   });

   function FSvQUODocHeader(){

             tDocNo = $("#ospDocNo").attr("data-docno");
             $.ajax({
             url: 'r_quodocgetdocheader',
             type: 'GET',
             data: {tDocNo : tDocNo},
             datatype: 'json'
             })
             .done(function (data) {
                 //console.log(data)
                 aDocHD = JSON.parse(data)
                 //console.log(aDocHD["raItems"])
                 tBchCode = aDocHD["raItems"][0]["FTBchCode"]
                 tXqhDocNo = aDocHD["raItems"][0]["FTXqhDocNo"]
                 dXqhDocDate = aDocHD["raItems"][0]["FDXqhDocDate"]
                 tXqhCshOrCrd = aDocHD["raItems"][0]["FTXqhCshOrCrd"]
                 nXqhCredit = aDocHD["raItems"][0]["FNXqhCredit"]
                 tXqhVATInOrEx = aDocHD["raItems"][0]["FTXqhVATInOrEx"]
                 nXqhSmpDay = aDocHD["raItems"][0]["FNXqhSmpDay"]
                 dXqhEftTo = aDocHD["raItems"][0]["FDXqhEftTo"]
                 dDeliveryDate = aDocHD["raItems"][0]["FDDeliveryDate"]
                 tXqhStaExpress = aDocHD["raItems"][0]["FTXqhStaExpress"]
                 tXqhStaDoc = aDocHD["raItems"][0]["FTXqhStaDoc"]
                 tXqhStaActive = aDocHD["raItems"][0]["FTXqhStaActive"]
                 tXqhPrjName = aDocHD["raItems"][0]["FTXqhPrjName"]
                 tXqhPrjCodeRef = aDocHD["raItems"][0]["FTXqhPrjCodeRef"]
                 tUsrDep = aDocHD["raItems"][0]["FTUsrDep"]
                 tApprovedBy = aDocHD["raItems"][0]["FTApprovedBy"]
                 tCreateBy = aDocHD["raItems"][0]["FTCreateBy"]
                 tUsrDep = aDocHD["raItems"][0]["FTUsrDep"]
                 dCreateOn = aDocHD["raItems"][0]["FDCreateOn"]
                 tUsrApvNameBy = aDocHD["raItems"][0]["FTUsrFName"]
                 dApproveDate = aDocHD["raItems"][0]["FDApproveDate"]
                 tXqhStaDeli = aDocHD["raItems"][0]["FTXqhStaDeli"]
                 tXqhRmk = aDocHD["raItems"][0]["FTXqhRmk"]
                 tVatRate = aDocHD["raItems"][0]["FCXqhVatRate"]

                 if(tXqhDocNo == ""){
                    tXqhDocNo = "SQ######-#####"
                    $("#ospDocNo").attr("data-docno",'')
                 }else{
                    tXqhDocNo = tXqhDocNo
                    $("#ospDocNo").attr("data-docno",tXqhDocNo)
                 }


                 $("#olbDocNo").text(tXqhDocNo);

                 if(dXqhDocDate == ""){
                    dXqhDocDate = moment().format('YYYY-MM-DD, h:mm:ss')
                 }
                 else{
                    dXqhDocDate = dXqhDocDate
                 }
                 $("#ospDocDate").text(dXqhDocDate)

                 switch (tXqhStaDoc) {
                   case '':
                     $("#ospStaDoc").text("รออนุมัติ")
                     break;
                   case '1':
                     $("#ospStaDoc").text("อนุมัติแล้ว")
                     break;
                   case '2':
                     $("#ospStaDoc").text("ยกเลิก")
                     break;
                   default:
                     $("#ospStaDoc").text("รออนุมัติ")
                 }

                 $("#oetXqhSmpDay").val(nXqhSmpDay)
                 $("#oetXqhCredit").val(nXqhCredit)
                 $("#odpXqhEftTo").val(dXqhEftTo)
                 $("#odpDeliveryDate").val(dDeliveryDate)
                 $('#ocmXqhCshOrCrd option[value="'+tXqhCshOrCrd+'"]').attr("selected", "selected");
                 $("#ospCreateBy").text(tCreateBy)
                 $("#ospApprovedBy").text(tUsrApvNameBy)
                 $("#ospApproveDate").text(dApproveDate)

                 if(tXqhStaExpress ==''){
                   $( "#ocbStaExpress" ).prop( "checked", false);
                 }else{
                   $( "#ocbStaExpress" ).prop( "checked", true );
                 }

                 if(tXqhStaActive ==''){
                   $( "#ocbtStaDocActive" ).prop( "checked", false);
                 }else{
                   $( "#ocbtStaDocActive" ).prop( "checked", true );
                 }

                 if(tXqhStaDeli ==''){
                   $( "#ocbStaDeli" ).prop( "checked", false);
                 }else{
                   $( "#ocbStaDeli" ).prop( "checked", true );
                 }

                 $( "#oetPrjName" ).val(tXqhPrjName)
                 $( "#oetPrjCodeRef" ).val(tXqhPrjCodeRef)
                 $('#ocmVatType option[value="'+tXqhVATInOrEx+'"]').attr("selected", "selected");
                 $("#otaDocRemark").text(tXqhRmk)

                 if(tVatRate == 0){
                    tVatRate = 7
                 }else{
                    tVatRate = tVatRate
                 }
                 $("#oetVatRate").val(tVatRate)

                 FSoQUODocCst(); //load customer in sq
                 FSvQUODocItems();

              })
             .fail(function (jqXHR, textStatus, errorThrown) {
                  //serrorFunction();
              });
   }

   function FSoQUODocCst(){

            tDocNo = $("#ospDocNo").attr("data-docno");
            tDocNo = $("#ospDocNo").attr("data-docno");
            $.ajax({
            url: 'r_quodocgetdoccst',
            type: 'GET',
            data: {tDocNo : tDocNo},
            datatype: 'json'
            })
            .done(function (data) {

                aDocHD = JSON.parse(data)
                //console.log(aDocHD["raItems"])
                tXqcCstName = aDocHD["raItems"][0]["FTXqcCstName"]
                tXqcAddress = aDocHD["raItems"][0]["FTXqcAddress"]
                tXqhTaxNo = aDocHD["raItems"][0]["FTXqhTaxNo"]
                tXqhContact = aDocHD["raItems"][0]["FTXqhContact"]
                tXqhEmail = aDocHD["raItems"][0]["FTXqhEmail"]
                tXqhTel = aDocHD["raItems"][0]["FTXqhTel"]
                tXqhFax = aDocHD["raItems"][0]["FTXqhFax"]

                $("#oetCstName").val(tXqcCstName)
                $("#oetAddress").text(tXqcAddress)
                $("#oetTaxNo").val(tXqhTaxNo)
                $("#oetContact").val(tXqhContact)
                $("#oetEmail").val(tXqhEmail)
                $("#oetTel").val(tXqhTel)
                $("#oetFax").val(tXqhFax)

             })
            .fail(function (jqXHR, textStatus, errorThrown) {
                 //serrorFunction();
             });

   }

   function FSvQUODocItems(){

             tDocNo = $("#ospDocNo").attr("data-docno");

             $.ajax({
             url: 'r_quodoccallitems',
             type: 'GET',
             data: {tDocNo : tDocNo},
             datatype: 'json'
             })
             .done(function (data) {
                   $("#odvQuoDocItems").html(data);

                   nDocNetTotal = parseFloat($("#ospDocNetTotal").text())


                   $("#otdDocNetTotal").text(accounting.formatMoney(nDocNetTotal.toFixed(2),""))

                   nFooterDis = 0
                   nNetAFHD = nDocNetTotal - ( nFooterDis);


                   $("#otdNetAFHD").text(accounting.formatMoney(nNetAFHD.toFixed(2),""))

                   nVatType = $("#ocmVatType").val()
                   nVatRate = $("#oetVatRate").val()

                   nVat = 0
                   nGrandTotal = 0
                   if(nVatType == "1"){

                       nVat = ((nNetAFHD * (100 + parseInt(nVatRate))) / 100) - nNetAFHD
                   }else{
                       nVat = nNetAFHD-((nNetAFHD * 100)/(100+parseInt(nVatRate)))
                   }

                   $("#otdVat").text(accounting.formatMoney(nVat.toFixed(2),""))

                   nGrandTotal = parseFloat(nNetAFHD) + parseFloat(nVat.toFixed(2))
                   $("#otdGrandTotal").text(accounting.formatMoney(nGrandTotal.toFixed(2),""))


              })
             .fail(function (jqXHR, textStatus, errorThrown) {
                  //serrorFunction();
              });

   }

   function FSxQUOSaveDoc(){

            oDocCstInfo = $("#ofmQuotationCst").serializeArray()
            oDocHeaderInfo = $("#ofmQuotationHeader").serializeArray()

            tDocNo = $("#ospDocNo").attr("data-docno");

            $.ajax({
            url: 'r_quodocsavedoc',
            type: 'GET',
            data: {oDocHeaderInfo:oDocHeaderInfo,oDocCstInfo : oDocCstInfo,tDocNo:tDocNo},
            datatype: 'json'
            })
            .done(function (data) {

             })
            .fail(function (jqXHR, textStatus, errorThrown) {
                 //serrorFunction();
             });

   }

</script>
