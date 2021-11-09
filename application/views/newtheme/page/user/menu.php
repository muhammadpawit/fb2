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
<div class="row">
			<?php foreach(MenuParentuser() as $mp){?>

			<div class="col-md-4">

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>
							<?php if(in_array($mp['id'],$inmenu)){?>
							<input type="checkbox" name="user_menu[]" value="<?php echo $mp['id']?>" checked>&nbsp;<?php echo $mp['nama']?>
							<?php }else{?>
								<input type="checkbox" name="user_menu[]" value="<?php echo $mp['id']?>">&nbsp;<?php echo $mp['nama']?>
							<?php } ?>

						</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach( MenuSub1All($mp['id']) as $sub1 ){?>

					<tr>

						<td>
							<?php if(in_array($sub1['id'],$inmenu)){?>
							<input type="checkbox" name="user_menu[]" value="<?php echo $sub1['id']?>" checked> <?php echo $sub1['nama']?>
							<?php }else{ ?>
							<input type="checkbox" name="user_menu[]" value="<?php echo $sub1['id']?>"> <?php echo $sub1['nama']?>
							<?php } ?>
						</td>

						<?php foreach( MenuSub2All($sub1['id']) as $sub2 ){?>

							<tr>

								<td>
									<?php if(in_array($sub2['id'],$inmenu)){?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="user_menu[]" value="<?php echo $sub2['id']?>" checked> <?php echo $sub2['nama']?>
									<?php }else{?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="user_menu[]" value="<?php echo $sub2['id']?>"> <?php echo $sub2['nama']?>
									<?php } ?>
								</td>

								<?php foreach( MenuSub3All($sub2['id']) as $sub3 ){?>

									<tr>

										<td>
											<?php if(in_array($sub3['id'],$inmenu)){?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="user_menu[]" value="<?php echo $sub3['id']?>" checked> <?php echo $sub3['nama']?>
											<?php }else{?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="user_menu[]" value="<?php echo $sub3['id']?>"> <?php echo $sub3['nama']?>
											<?php } ?>
										</td>

									</tr>

								<?php } ?>

							</tr>

						<?php } ?>



					</tr>

					<?php } ?>

				</tbody>

			</table>

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