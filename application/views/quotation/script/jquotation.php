<script type="text/javascript">
   $(document).ready(function(){

         FSvQUOGetPdtList();
         FSvQUOCallDocHeader();
         FSvQUOCallItemList();

   });

   function FSvQUOGetPdtList(){

     $.ajax({
     url: 'r_quotationeventGetPdtList',
     type: 'GET',
     data: '',
     datatype: 'json'
     })
     .done(function (data) {
           $("#odvQuoPdtList").html(data);
      })
     .fail(function (jqXHR, textStatus, errorThrown) {
          //serrorFunction();
      });
   }

   function FSvQUOCallDocHeader(){

     $.ajax({
     url: 'r_quotationcalldocheader',
     type: 'GET',
     data: '',
     datatype: 'json'
     })
     .done(function (data) {
           $("#odvQuoHeader").html(data);
      })
     .fail(function (jqXHR, textStatus, errorThrown) {
          //serrorFunction();
      });
   }

   function FSvQUOCallItemList(){

     $.ajax({
     url: 'r_quotationeventcallitemslist',
     type: 'GET',
     data: '',
     datatype: 'json'
     })
     .done(function (data) {
           $("#odvQuoItemsList").html(data);
      })
     .fail(function (jqXHR, textStatus, errorThrown) {
          //serrorFunction();
      });
   }

   function FSvQUOAddItemToTemp(ptElm){
     tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
     tDataItem = $(ptElm).attr("data-iteminfo");

     $.ajax({
     url: 'r_quotationeventAddItems',
     type: 'POST',
     data: {tQuoDocNo:tQuoDocNo,Item:tDataItem},
     datatype: 'json'
     })
     .done(function (data) {

          FSvQUOCallItemList()

      })
     .fail(function (jqXHR, textStatus, errorThrown) {
          //serrorFunction();
      });
   }

   function FSxQUODelItem(ptElm){

     tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
     nItemSeq = $(ptElm).attr("data-seq");
     // alert(tQuoDocNo+'-'+nItemSeq);
     if(confirm('ยืนยันการลบสินค้านี้ออกจากเอกสาร')){
           $.ajax({
           url: 'r_quotationeventDelItems',
           type: 'POST',
           data: {tQuoDocNo:tQuoDocNo,nItemSeq:nItemSeq},
           datatype: 'json'
           })
           .done(function (data) {

                FSvQUOCallItemList()

            })
           .fail(function (jqXHR, textStatus, errorThrown) {
                //serrorFunction();
            });
     }

   }

   function FSxQUOEditItemQty(e,poElm) {
        //See notes about 'which' and 'key'
        if (e.keyCode == 13) {

            var nItemQTY  = $(poElm).val();
            tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
            nItemSeq = $(poElm).attr("data-seq");
            nUnitPrice = $(poElm).attr("data-unitpri");


            $.ajax({
            url: 'r_quotationeventEditItemsQty',
            type: 'POST',
            data: {tQuoDocNo:tQuoDocNo,nItemSeq:nItemSeq,nItemQTY:nItemQTY,nUnitPrice:nUnitPrice},
            datatype: 'json'
            })
            .done(function (data) {

                 FSvQUOCallItemList()

             })
            .fail(function (jqXHR, textStatus, errorThrown) {
                 //serrorFunction();
             });
              return false;

        }
    }

</script>
