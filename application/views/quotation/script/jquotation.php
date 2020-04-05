<script type="text/javascript">
   $(document).ready(function(){

         FSvQUOGetPdtList()

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

</script>
