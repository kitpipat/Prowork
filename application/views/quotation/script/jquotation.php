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

</script>
