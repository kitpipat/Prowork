<script type="text/javascript">
   $(document).ready(function(){

         FSvQUODocHeader();
         FSvQUODocItems();

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

</script>
