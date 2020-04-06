<script type="text/javascript">
   $(document).ready(function(){

         FSvQUOGetPdtList();
         FSvQUOGetItemList();

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

   function FSvQUOGetItemList(){

     $.ajax({
     url: 'r_quotationeventGetItemsList',
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

          FSvQUOGetItemList()

      })
     .fail(function (jqXHR, textStatus, errorThrown) {
          //serrorFunction();
      });
   }

</script>
