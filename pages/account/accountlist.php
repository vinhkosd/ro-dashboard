<?php
use Models\Zone;
$zoneList = Zone::get();
validateLogin(true, false);//check account login
// var_dump($zoneList);
?>
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
						<li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<h6 class="card-title">Danh sách tài khoản</h6>
							<p class="card-description"><a id="reloadDataButton" href="javascript:void(0)"> Tải lại </a></p>
							<div class="table-responsive">
							<table id="dataTableExample" class="table">
								<thead>
								<tr>
									<th>ID</th>
									<th>Tài khoản</th>
									<th>Thời gian đăng ký</th>
									<th>Email</th>
									<th>Money</th>
									<th>Email cũ</th>
									<th>Chức năng</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							</div>
						</div>
						</div>
					</div>
				</div>

			</div>
		<div class="modal fade" id="editAccount" tabindex="-1" role="dialog" aria-labelledby="editAccountLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editAccountLabel">Sửa tài khoản</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editAccountForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<div class="form-group">
						<label for="account" class="col-form-label">Tài khoản:</label>
						<input type="text" class="form-control" id="account" name="account" readonly/>
					</div>
					<div class="form-group">
						<label for="email" class="col-form-label">Email:</label>
						<input type="text" id="email" name="email" class="form-control" data-inputmask="'alias': 'email', 'clearIncomplete': true"/>
					</div>
					<div class="form-group">
						<label for="password" class="col-form-label">Mật khẩu (Không sửa thì có thể để trống):</label>
						<input type="text" class="form-control" id="password" name="password"/>
					</div>
					<div class="form-group">
						<label for="money" class="col-form-label">Money:</label>
						<input type="text" id="money" name="money"class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" readonly/>
					</div>
					<div class="form-group">
						<label for="old_email" class="col-form-label">Email Cũ:</label>
						<input type="text" id="old_email" name="old_email" class="form-control" data-inputmask="'alias': 'email', 'clearIncomplete': true" readonly/>
					</div>
					<div class="form-group">
						<label for="regtime" class="col-form-label">Thời gian đăng ký:</label>
						<input type="text" id="regtime" name="regtime" class="form-control" data-inputmask="'alias': 'datetime', 'clearIncomplete': true" data-inputmask-inputformat="yyyy-mm-dd HH:MM:ss" readonly/>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="editAccountSaveButton">Save</button>
				</div>
				</div>
			</div>
			</div>
			<!-- Extra large modal -->
			
			<div id="listRoleModal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="listRoleModal" aria-hidden="true">
			  <div class="modal-dialog modal-xl">
			    <div class="modal-content">
			    	<div class="modal-header">
						<h5 class="modal-title">Danh sách rolename</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="roleListForm">
							<input type="hidden" name="id"/>
			      			<div class="form-group">
		                        <label for="server" class="col-form-label">Chọn server:</label>
		                        <select class="form-control" name="server" value="<?php echo $zoneList->first()['zoneid'];?>" required>
		                        	<?php
		                        		$zoneList->map(function ($item, $key) {
                        					echo "<option value=".$item['zoneid'].">".$item['zonename']." - RegionId: ".$item['regionid']."- Zone: ".$item['zoneid']."</option>";
	                        			}); 
		                        	?>
		                        </select>
		                    </div>
		                    
	                    </form>
	                    <table id="dataTableRole" class="table">
							<thead>
							<tr>
								<th>AccID</th>
								<th>CharID</th>
								<th>ZoneId</th>
								<th>Name</th>
								<th>RoleLv</th>
								<th>Ngày tạo</th>
								<th>Chức năng</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
			      	</div>
			    </div>
			  </div>
			</div>
<script type="text/javascript">
	$(document).ready(function() {
		var dt = [];
		function loadAccountList() {
			var currentPage = $('#dataTableExample').DataTable().page.info().page;
			dt = $('#dataTableExample').DataTable().destroy();
			// $('#dataTableExample tbody').html("Loading...");
			 $('#dataTableExample').DataTable({
				"aLengthMenu": [
					[10, 30, 50, -1],
					[10, 30, 50, "Tất cả"]
				],
				"iDisplayLength": 10,
				"language": {
					search: ""
				},
				"processing": true,
		        "serverSide": true,
		        "ajax": "<?php homePath()?>ajax/accountlist_serverside.php",
		        "columns": [
		            { "data": "id" },
		            { "data": "account" },
		            { "data": "regtime" },
		            { "data": "email" },
		            { "data": "money" },
		            { "data": "old_email" },
		            {
		                "class":          "function-button",
		                "orderable":      false,
		                "data":           null,
		                "defaultContent": `	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account="">Edit</button>
		                					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#listRoleModal"  data-account="">List role</button>
		                `
		            },
		        ]
			});
			
			 dt.on( 'draw', function () {
		        // $('#dataTableExample tbody button').trigger( 'click' );
	        	$('#dataTableExample tbody').on( 'click', 'tr td.function-button', function () {
			        var tr = $(this).closest('tr');
			        var row = $('#dataTableExample').DataTable().row( tr );
			        $(this).find('button').attr('data-account', JSON.stringify(row.data()));
			        console.log(row.data());
			        console.log($(this));
			    });
		    });
		    
	    
			// $.post("<?php homePath()?>ajax/accountlist.php", (data) => {
			// 	var htmlBody = "";
			// 	data.map(item => {
			// 		htmlBody += "<tr>\r\n";
			// 		htmlBody += `	<td>${item.id}</td>\r\n`;
			// 		htmlBody += `	<td>${item.account}</td>\r\n`;
			// 		htmlBody += `	<td>${moment(item.regtime).format('DD/MM/YYYY HH:mm:ss')}</td>\r\n`;
			// 		htmlBody += `	<td>${item.email}</td>\r\n`;
			// 		htmlBody += `	<td>${item.money}.00</td>\r\n`;
			// 		htmlBody += `	<td>${item.old_email}</td>\r\n`;
			// 		htmlBody += `	<td>
			// 							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account='${JSON.stringify(item)}'>Edit</button>
			// 							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#listRoleModal"  data-account='${JSON.stringify(item)}'>List role</button>
			// 						</td>\r\n`;
			// 		htmlBody += "</tr>\r\n";
			// 	});
			// 	$('#dataTableExample tbody').html(htmlBody);

			// 	$('#dataTableExample').DataTable({
			// 		"aLengthMenu": [
			// 			[10, 30, 50, -1],
			// 			[10, 30, 50, "Tất cả"]
			// 		],
			// 		"iDisplayLength": 10,
			// 		"language": {
			// 			search: ""
			// 		},
			// 	});
			// 	$('#dataTableExample').each(function() {
			// 		var datatable = $(this);
			// 		// SEARCH - Add the placeholder for Search and Turn this into in-line form control
			// 		var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			// 		search_input.attr('placeholder', 'Search');
			// 		search_input.removeClass('form-control-sm');
			// 		// LENGTH - Inline-Form control
			// 		var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			// 		length_sel.removeClass('form-control-sm');
			// 	});
			// 	$('#dataTableExample').DataTable().page(currentPage).draw('page');
			// }, "json");
		}
		loadAccountList();
		
		$('#reloadDataButton').click(function(e,t) {
			loadAccountList(); 
		})

		$('#editAccount').on('show.bs.modal', function (event) {
			console.log('onShow');
			var button = $(event.relatedTarget) // Button that triggered the modal
			console.log(button.data('account'));
			var accountData = (button.data('account')) // Extract info from data-* attributes
			var modal = $(this);
			Object.keys(accountData).map(item => {
				if(item !== 'password') {
					modal.find('.modal-body input[name='+item+']').val(accountData[item]);
				}
			})
			modal.find('.modal-title').text('Edit account : ' + accountData['account'])
		});
		
		$('#listRoleModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Button that triggered the modal
			var accountData = (button.data('account')) // Extract info from data-* attributes
			var modal = $(this);
			
			var params = {
				...accountData,
				zoneid: <?php echo $zoneList->first()['zoneid'];?>
			}
			
			$('#roleListForm select[name=server]').val(<?php echo $zoneList->first()['zoneid'];?>);
			
			Object.keys(accountData).map(item => {
				modal.find('.modal-body input[name='+item+']').val(accountData[item]);
			})
			getRoles(params);
		});
		$('#roleListForm select[name=server]').change(function() {
			var zoneId = $(this).val();
			var accId = $('#roleListForm input[name=id]').val();
			var params = {
				id: accId,
				zoneid: zoneId
			}
			
			getRoles(params);
		});

		$('#editAccountSaveButton').click(function () {
			$.post("<?php homePath()?>ajax/editaccount.php",$('#editAccountForm').serialize(), (data) => {
				if(data.success) {
					Lobibox.notify("success", {
						msg: data.success
					});
				} else {
					Lobibox.notify("error", {
						msg: data.error
					});
				}
				$('#editAccount').modal('hide');
			}, "json")
			.always(function() {
				loadAccountList();
			});
			return false;
		});
		
		function getRoles(params) {
			var currentPage = $('#dataTableRole').DataTable().page.info().page;
			$('#dataTableRole').DataTable().destroy();
			$('#dataTableRole tbody').html("Loading...");
			
			$.get("<?php homePath()?>ajax/getroles.php", params, (data) => {
				var htmlBody = "";
				data.map(item => {
					htmlBody += "<tr>\r\n";
					htmlBody += `	<td>${item.accid}</td>\r\n`;
					htmlBody += `	<td>${item.charid}</td>\r\n`;
					htmlBody += `	<td>${item.zoneid}</td>\r\n`;
					htmlBody += `	<td>${item.name}</td>\r\n`;
					htmlBody += `	<td>${item.rolelv}</td>\r\n`;
					htmlBody += `	<td>${moment(1000*item.createtime).format('DD/MM/YYYY HH:mm:ss')}</td>\r\n`;
					htmlBody += `	<td>
										<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account='${JSON.stringify(item)}'>Edit</button-->
									</td>\r\n`;
					htmlBody += "</tr>\r\n";
				});
				$('#dataTableRole tbody').html(htmlBody);
				
				$('#dataTableRole').DataTable({
					"aLengthMenu": [
						[10, 30, 50, -1],
						[10, 30, 50, "Tất cả"]
					],
					"iDisplayLength": 10,
					"language": {
						search: ""
					}
				});
				$('#dataTableRole').each(function() {
					var datatable = $(this);
					// SEARCH - Add the placeholder for Search and Turn this into in-line form control
					var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
					search_input.attr('placeholder', 'Search');
					search_input.removeClass('form-control-sm');
					// LENGTH - Inline-Form control
					var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
					length_sel.removeClass('form-control-sm');
				});
				$('#dataTableRole').DataTable().page(currentPage).draw('page');
			}, "json");
		}
	});

</script>