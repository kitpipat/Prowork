<table class="table table-bordered">
  <!-- Table head -->
  <thead>
    <tr>
      <th>
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck1">
          <label class="custom-control-label" for="tableDefaultCheck1">Check 1</label>
        </div>
      </th>
      <th>Lorem</th>
      <th>Ipsum</th>
      <th>Dolor</th>
    </tr>
  </thead>
  <!-- Table head -->

  <!-- Table body -->
  <tbody>
    <tr>
      <th scope="row">
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck2" checked>
          <label class="custom-control-label" for="tableDefaultCheck2">Check 2</label>
        </div>
      </th>
      <td>Cell 1</td>
      <td>Cell 2</td>
      <td>Cell 3</td>
    </tr>
    <tr>
      <th scope="row">
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck3">
          <label class="custom-control-label" for="tableDefaultCheck3">Check 3</label>
        </div>
      </th>
      <td>Cell 4</td>
      <td>Cell 5</td>
      <td>Cell 6</td>
    </tr>
    <tr>
      <th scope="row">
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck4">
          <label class="custom-control-label" for="tableDefaultCheck4">Check 4</label>
        </div>
      </th>
      <td>Cell 7</td>
      <td>Cell 8</td>
      <td>Cell 9</td>
    </tr>
  </tbody>
  <!-- Table body -->
</table>
<?php
   for($i = 0;$i<100;$i++){
     echo 'ใบเสนอราคาทั้งหมด'."<br>";
   }
?>
<div>
ลายเซนต์
</div>

<link rel="stylesheet" href="<?=base_url('/application/assets/css/bootstrap.css')?>">