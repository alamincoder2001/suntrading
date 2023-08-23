<div class="row">
	<div class="col-sm-6 col-sm-offset-3" style="margin-top: 20px;">
		<!-- PAGE CONTENT BEGINS -->
		<div class="form-horizontal">

			<div class="form-group">
				<label class="col-sm-4 control-label"> Brand Name :</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="brandname" name="brandname" placeholder="Brand Name" value="<?php echo set_value('brandname'); ?>" />
					<span id="msg"></span>
					<?php echo form_error('brandname'); ?>
					<span style="color:red;font-size:15px;">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"> HS Code :</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="hs_code" name="hs_code" placeholder="HS Code" value="<?php echo set_value('hs_code'); ?>" />
					<span id="msg_hs_code"></span>
					<?php echo form_error('hs_code'); ?>
					<span style="color:red;font-size:15px;">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"> Origin :</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="origin" name="origin" placeholder="Origin" value="<?php echo set_value('origin'); ?>" />
					<span id="msg_origin"></span>
					<?php echo form_error('origin'); ?>
					<span style="color:red;font-size:15px;">
				</div>
			</div>

			<div class="form-group text-right">
				<div class="col-sm-10">
					<button type="button" class="btn btn-sm btn-success" onclick="submit()" name="btnSubmit">
						Save
					</button>
				</div>
			</div>

		</div>
	</div>
</div>



<div class="row">
	<div class="col-sm-12">

		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<div class="table-header">
			Brand Information
		</div>

		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
		<div id="saveResult">
			<table id="dynamic-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>SL No</th>
						<th>Brand Name</th>
						<th>HS Code</th>
						<th>Origin</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
					$BRANCHid = $this->session->userdata('BRANCHid');
					$query = $this->db->query("SELECT * FROM tbl_brand where status='a' AND brand_branchid = '$BRANCHid' order by brand_name asc");
					$row = $query->result();
					//echo "<pre>";print_r($row);exit;
					?>
					<?php $i = 1;
					foreach ($row as $row) { ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><a href="#"><?php echo $row->brand_name; ?></a></td>
							<td><a href="#"><?php echo $row->hs_code; ?></a></td>
							<td><a href="#"><?php echo $row->origin; ?></a></td>
							<td>
								<div class="hidden-sm hidden-xs action-buttons">
									<a class="blue" href="#">
										<i class="ace-icon fa fa-search-plus bigger-130"></i>
									</a>
									<a class="green" href="<?php echo base_url() ?>editbrand/<?php echo $row->brand_SiNo; ?>" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
										<i class="ace-icon fa fa-pencil bigger-130"></i>
									</a>
									<a class="red" href="#" onclick="deleted(<?php echo $row->brand_SiNo; ?>)">
										<i class="ace-icon fa fa-trash-o bigger-130"></i>
									</a>
								</div>
							</td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	function submit() {
		var brandname = $("#brandname").val();
		if (brandname == "") {
			$("#msg").html("Required Filed").css("color", "red");
			return false;
		} else {
			$("#msg").html("");
		}

		var hs_code = $("#hs_code").val();
		if (hs_code == "") {
			$("#msg_hs_code").html("Required Filed").css("color", "red");
			return false;
		} else {
			$("#msg").html("");
		}

		var origin = $("#origin").val();
		if (origin == "") {
			$("#msg_origin").html("Required Filed").css("color", "red");
			return false;
		} else {
			$("#msg").html("");
		}

		var catname = encodeURIComponent(catname);
		var inputdata = {
			brandname: brandname,
			hs_code: hs_code,
			origin: origin,
		}
		var urldata = "<?php echo base_url(); ?>insertbrand";
		$.ajax({
			type: "POST",
			url: urldata,
			data: inputdata,
			success: function(data) {
				if (data == "false") {
					alert("This Name Allready Exists");
				} else {
					alert("Save Success");
					location.reload();
					document.getElementById("brandname").value = '';
				}
			}
		});
	}
</script>

<script type="text/javascript">
	function deleted(id) {
		var deletedd = id;
		var inputdata = 'deleted=' + deletedd;
		var confirmation = confirm("are you sure you want to delete this ?");
		var urldata = "<?php echo base_url() ?>branddelete";
		if (confirmation) {
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success: function(data) {
					//$("#saveResult").html(data);
					alert("Delete Success");
					window.location.href = '<?php echo base_url(); ?>Administrator/page/add_brand';
				}
			});
		};
	}
</script>