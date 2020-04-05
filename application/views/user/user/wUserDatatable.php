<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
			<th >ลำดับ</th>
			<th >รูปภาพ</th>
      <th >ชื่อ-นามกสุล</th>
      <th >สาขา</th>
			<th >แผนก</th>
			<th >กลุ่มสิทธิ์</th>
			<th >กลุ่มราคา</th>
			<th >สถานะ</th>
			<th >แก้ไข</th>
			<th >ลบ</th>
    </tr>
  </thead>
  <tbody>
				<?php if($aUserList['rtCode'] != 800){ ?>
					<?php foreach($aUserList['raItems'] AS $nKey => $nValue){ ?>
						<tr>
							<th scope="row">1</th>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
						</tr>
					<?php } ?>
				<?php }else{ ?>
					<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
				<?php } ?>
  </tbody>
</table>
