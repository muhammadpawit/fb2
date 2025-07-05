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
                        <input type="checkbox" class="parent-checkbox" name="user_menu[]" value="<?php echo $mp['id']; ?>" <?php echo in_array($mp['id'], $inmenu) ? 'checked' : ''; ?> data-parent-id="<?php echo $mp['id']; ?>">
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
                                        <input type="checkbox" class="sub1-checkbox" name="user_menu[]" value="<?php echo $sub1['id']; ?>" <?php echo in_array($sub1['id'], $inmenu) ? 'checked' : ''; ?> data-parent-id="<?php echo $mp['id']; ?>" data-sub1-id="<?php echo $sub1['id']; ?>">
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
                                                        <input type="checkbox" class="sub2-checkbox" name="user_menu[]" value="<?php echo $sub2['id']; ?>" <?php echo in_array($sub2['id'], $inmenu) ? 'checked' : ''; ?> data-parent-id="<?php echo $mp['id']; ?>" data-sub1-id="<?php echo $sub1['id']; ?>" data-sub2-id="<?php echo $sub2['id']; ?>">
                                                        <a data-toggle="collapse" data-parent="#collapseSub1<?php echo $sub1['id']; ?>" href="#collapseSub2<?php echo $sub2['id']; ?>" class="collapsed">
                                                            &nbsp;<?php echo $sub2['nama']; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseSub2<?php echo $sub2['id']; ?>" class="panel-collapse collapse">
                                                    <div class="box-body">
                                                        <?php foreach (MenuSub3All($sub2['id']) as $sub3) { ?>
                                                            <div>
                                                                <input type="checkbox" class="sub3-checkbox" name="user_menu[]" value="<?php echo $sub3['id']; ?>" <?php echo in_array($sub3['id'], $inmenu) ? 'checked' : ''; ?> data-parent-id="<?php echo $mp['id']; ?>" data-sub1-id="<?php echo $sub1['id']; ?>" data-sub2-id="<?php echo $sub2['id']; ?>" data-sub3-id="<?php echo $sub3['id']; ?>">
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
<script>
$(document).ready(function() {
    // Ketika parent dicentang
    $('.parent-checkbox').change(function() {
        var parentId = $(this).data('parent-id');
        var isChecked = $(this).is(':checked');
        
        // Centang/uncentang semua sub1, sub2, dan sub3 di bawah parent ini
        $('.sub1-checkbox[data-parent-id="' + parentId + '"]').prop('checked', isChecked);
        $('.sub2-checkbox[data-parent-id="' + parentId + '"]').prop('checked', isChecked);
        $('.sub3-checkbox[data-parent-id="' + parentId + '"]').prop('checked', isChecked);
    });
    
    // Ketika sub1 dicentang
    $('.sub1-checkbox').change(function() {
        var parentId = $(this).data('parent-id');
        var sub1Id = $(this).data('sub1-id');
        var isChecked = $(this).is(':checked');
        
        // Centang/uncentang semua sub2 dan sub3 di bawah sub1 ini
        $('.sub2-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"]').prop('checked', isChecked);
        $('.sub3-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"]').prop('checked', isChecked);
    });
    
    // Ketika sub2 dicentang
    $('.sub2-checkbox').change(function() {
        var parentId = $(this).data('parent-id');
        var sub1Id = $(this).data('sub1-id');
        var sub2Id = $(this).data('sub2-id');
        var isChecked = $(this).is(':checked');
        
        // Centang/uncentang semua sub3 di bawah sub2 ini
        $('.sub3-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"][data-sub2-id="' + sub2Id + '"]').prop('checked', isChecked);
    });
    
    // Ketika sub3 dicentang - TIDAK ADA PERUBAHAN KE LEVEL ATASNYA
    $('.sub3-checkbox').change(function() {
        // Tidak perlu melakukan apa-apa ke level atasnya
    });
    
    // Fungsi untuk update status checkbox parent (tidak digunakan dalam skenario ini)
    // function updateParentCheckbox(parentId) {
    //     var allSub1Checked = true;
    //     $('.sub1-checkbox[data-parent-id="' + parentId + '"]').each(function() {
    //         if (!$(this).is(':checked')) {
    //             allSub1Checked = false;
    //             return false; // keluar dari loop
    //         }
    //     });
    //     $('.parent-checkbox[data-parent-id="' + parentId + '"]').prop('checked', allSub1Checked);
    // }
    
    // Fungsi untuk update status checkbox sub1 (tidak digunakan dalam skenario ini)
    // function updateSub1Checkbox(parentId, sub1Id) {
    //     var allSub2Checked = true;
    //     $('.sub2-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"]').each(function() {
    //         if (!$(this).is(':checked')) {
    //             allSub2Checked = false;
    //             return false; // keluar dari loop
    //         }
    //     });
    //     $('.sub1-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"]').prop('checked', allSub2Checked);
    // }
    
    // Fungsi untuk update status checkbox sub2 (tidak digunakan dalam skenario ini)
    // function updateSub2Checkbox(parentId, sub1Id, sub2Id) {
    //     var allSub3Checked = true;
    //     $('.sub3-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"][data-sub2-id="' + sub2Id + '"]').each(function() {
    //         if (!$(this).is(':checked')) {
    //             allSub3Checked = false;
    //             return false; // keluar dari loop
    //         }
    //     });
    //     $('.sub2-checkbox[data-parent-id="' + parentId + '"][data-sub1-id="' + sub1Id + '"][data-sub2-id="' + sub2Id + '"]').prop('checked', allSub3Checked);
    // }
});
</script>