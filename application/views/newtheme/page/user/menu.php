<div class="row">
	<div class="col-md-12">
		<label><input type="checkbox" name="checkall" id="checkAll"> Checklis semua</label>
	</div>
</div>
<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="userid" value="<?php echo $userid?>">
	<input type="hidden" name="user_menu[]" value="1">
	<input type="hidden" name="user_menu[]" value="2">
	<input type="hidden" name="user_menu[]" value="113">
	<div class="box-group" id="accordion">
    <?php foreach (MenuParentuser() as $mp) { ?>
        <div class="panel box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">
                    <input type="checkbox" name="user_menu[]" value="<?php echo $mp['id']; ?>" <?php echo in_array($mp['id'], $inmenu) ? 'checked' : ''; ?>>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $mp['id']; ?>" aria-expanded="true" class="collapsed">
                        &nbsp;<?php echo $mp['nama']; ?>
                    </a>
                </h4>
            </div>
            <div id="collapse<?php echo $mp['id']; ?>" class="panel-collapse collapse">
                <div class="box-body">
                    <?php foreach (MenuSub1All($mp['id']) as $sub1) { ?>
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <input type="checkbox" name="user_menu[]" value="<?php echo $sub1['id']; ?>" <?php echo in_array($sub1['id'], $inmenu) ? 'checked' : ''; ?>>
                                    <a data-toggle="collapse" data-parent="#collapse<?php echo $mp['id']; ?>" href="#collapseSub1<?php echo $sub1['id']; ?>" class="collapsed">
                                        &nbsp;<?php echo $sub1['nama']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSub1<?php echo $sub1['id']; ?>" class="panel-collapse collapse">
                                <div class="box-body">
                                    <?php foreach (MenuSub2All($sub1['id']) as $sub2) { ?>
                                        <div class="panel box box-warning">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <input type="checkbox" name="user_menu[]" value="<?php echo $sub2['id']; ?>" <?php echo in_array($sub2['id'], $inmenu) ? 'checked' : ''; ?>>
                                                    <a data-toggle="collapse" data-parent="#collapseSub1<?php echo $sub1['id']; ?>" href="#collapseSub2<?php echo $sub2['id']; ?>" class="collapsed">
                                                        &nbsp;<?php echo $sub2['nama']; ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseSub2<?php echo $sub2['id']; ?>" class="panel-collapse collapse">
                                                <div class="box-body">
                                                    <?php foreach (MenuSub3All($sub2['id']) as $sub3) { ?>
                                                        <div>
                                                            <input type="checkbox" name="user_menu[]" value="<?php echo $sub3['id']; ?>" <?php echo in_array($sub3['id'], $inmenu) ? 'checked' : ''; ?>>
                                                            &nbsp;<?php echo $sub3['nama']; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="row">
	<div class="col-md-12">
		<label><button type="submit" class="btn btn-info btn-sm">Simpan</button></label>
		<a href="<?php echo $batal?>" class="btn btn-sm btn-danger tet-white">Kembali</a>
	</div>
</div>
</form>
<script type="text/javascript">
	$("#checkAll").click(function(){
	    $('input:checkbox').not(this).prop('checked', this.checked);
	});
</script>