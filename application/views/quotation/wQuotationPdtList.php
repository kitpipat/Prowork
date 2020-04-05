<?php for($p=0;$p<$nTotalRecord;$p++){
      $tPdtName = $aPdtList['raItems'][$p]['FTPdtName'];
      $nPdtNetSalPri = $aPdtList['raItems'][$p]['FCPdtNetSalPri'];
?>
<div class="col-sm-3 col-md-3 col-lg-3">
    <div class="thumbnail">
        <img src="<?=base_url('application/assets/images/products/NoImage.png') ?>" alt="...">
        <div class="caption">
            <h4><?php echo $tPdtName;?></h4>
            <span>&#3647;<?php echo number_format($nPdtNetSalPri,2);?></span>
        </div>
    </div>
</div>
<?php } ?>
