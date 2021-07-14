<?php
use Models\GiftCode; 
use Carbon\Carbon; 
validateLogin(true, false);//check account login


$giftCodeQuery = GiftCode::query();
$giftCodeQuery->groupBy('GiftID', 'Title');
$giftCodeCategorys = $giftCodeQuery->get(['GiftID', 'Title']);
?>
<div class="page-content">
	<nav class="page-breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">GiftCode</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Danh sách giftcode</li>
		</ol>
	</nav>
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body col-md-12" style="display:flex">
		            <div class="col-md-2">
		                <h6 class="card-title">Chọn loại giftCode</h6>
		                <div class="input-group">
		                   <select id="giftCat" name="giftCat" value="0">
		                   		<option value=0>Tất cả</option>
		                   		<?php 
		                   			$giftCodeCategorys->map(function($item) {
		                   				echo '<option value='.$item['GiftID'].'>'.$item['GiftID'].' - '.$item['Title'].'</option>';	
		                   			});
		                   		?>
		                   	</select>
		                </div>
		            </div>
		            <div class="col-md-2">
		                <h6 class="card-title">Sử dụng</h6>
		                <div class="input-group">
		                   <select id="giftUsed" name="giftUsed" value="0">
		                   		<option value=0>Tất cả</option>
		                   		<option value=1>Đã sử dụng</option>
		                   		<option value=2>Chưa sử dụng</option>
		                   	</select>
		                </div>
		            </div>
		            <div class="col-md-2">
		            	<h6 class="card-title">Xuất file</h6>
		                <button id="exportToFile" type="button" class="btn btn-primary">Xuất file</button>
		            </div>
		            <div class="col-md-2">
		            	<h6 class="card-title">Tạo GiftCODE</h6>
		                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createGiftCode" >Tạo</button>
		            </div>
		            <div class="col-md-3">
		            	<h6 class="card-title">Reload</h6>
		                <button id="reloadDataButton" type="button" class="btn btn-primary">Reload</button>
		            </div>
		        </div>
				<div class="card-body">
					<h6 class="card-title">Danh sách gói</h6>
					<div class="table-responsive">
						<table id="dataTableExample" class="table">
							<thead>
								<tr>
									<th>ID</th>
									<th>GiftID</th>
									<th>ItemID</th>
									<th>Tên</th>
									<th>Code</th>
									<th>Loại mua</th>
									<th>Chức năng</th>
								</tr>
							</thead>
							<tbody></tbody>
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
				<h5 class="modal-title" id="editAccountLabel">Sửa gói</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editAccountForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<div class="form-group">
						<label for="ItemID" class="col-form-label">ItemID:</label>
						<input type="text" class="form-control" name="ItemID" />
					</div>
					<div class="form-group">
						<label for="Code" class="col-form-label">Code:</label>
						<input type="text" name="Code" class="form-control" />
					</div>
					<div class="form-group">
						<label for="Title" class="col-form-label">Tên gói:</label>
						<input type="text" name="Title" class="form-control" />
					</div>
					<div class="form-group">
						<label for="BuyType" class="col-form-label">Loại mua:</label>
						<select class="form-control" name="BuyType">
						    <option value=2>Riêng</option>
							<option value=1>Chung</option>
						</select>
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

<div class="modal fade" id="createGiftCode" tabindex="-1" role="dialog" aria-labelledby="createGiftCodeLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createGiftCodeLabel">Tạo GiftCode</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="createGiftCodeForm">
					<div class="form-group">
						<label for="GiftID" class="col-form-label">GiftID:</label>
						<input type="text" class="form-control" name="GiftID" placeholder="GiftID của code hoặc để trống GiftID tự tăng" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" >
					</div>
					<div class="form-group">
						<label for="count" class="col-form-label">Số lượng code:</label>
						<input type="text" class="form-control" name="count" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" required>
					</div>
					<div class="form-group">
						<label for="prefix" class="col-form-label">Tiền tố:</label>
						<input type="text" class="form-control" name="prefix" placeholder="Có thể để trống. Ví dụ: GCODE1 -> code = GCODE1ABC. bỏ trống -> code = ABC">
					</div>
					<div class="form-group">
						<label for="codelen" class="col-form-label">Độ dài code:</label>
						<input type="text" class="form-control" name="codelen" value="12" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" required>
					</div>
					<div class="form-group">
						<label for="ItemID" class="col-form-label">ItemID:</label>
						<input type="text" class="form-control" name="ItemID" required />
					</div>
					<!--<div class="form-group">-->
					<!--	<label for="Code" class="col-form-label">Code:</label>-->
					<!--	<input type="text" name="Code" class="form-control" />-->
					<!--</div>-->
					<div class="form-group">
						<label for="Title" class="col-form-label">Tên giftcode:</label>
						<input type="text" name="Title" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="BuyType" class="col-form-label">Loại giftcode:</label>
						<select class="form-control" name="BuyType" required>
							<option value=1>GiftCode Chung</option>
							<option value=2>GiftCode Riêng</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="createGiftCodeBtn">Tạo</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	function loadAccountList() {
	
	    var listBuyType = {
	        1: 'Gift code chung',
	        2: 'Gift code riêng',
	        0: 'Không xác định'
	    }
	
		var currentPage = $('#dataTableExample').DataTable().page.info().page;
		$('#dataTableExample').DataTable().destroy();
		$('#dataTableExample tbody').html("Loading...");
		
		var giftCat = $('#giftCat').val();
		var giftUsed = $('#giftUsed').val();
		var params = {
			GiftID: giftCat,
			GiftUsed: giftUsed
		};
		
		$.post("<?php homePath()?>ajax/giftcodelist.php", params, (data) => {
			var htmlBody = "";
			data.map(item => {
			    htmlBody += "<tr>\r\n";
			    htmlBody += `	<td>${item.id}</td>\r\n`;
			    htmlBody += `	<td>${item.GiftID}</td>\r\n`;
			    htmlBody += `	<td>${item.ItemID}</td>\r\n`;
			    htmlBody += `	<td>${item.Title}</td>\r\n`;
			    htmlBody += `	<td>${item.Code}</td>\r\n`;
			    htmlBody += `	<td>${listBuyType[item.BuyType]}</td>\r\n`;
			    htmlBody += `	<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account='${JSON.stringify(item)}'>Edit</button></td>\r\n`;
			    htmlBody += "</tr>\r\n";
			});
			
			$('#dataTableExample tbody').html(htmlBody);
			
			$('#dataTableExample').DataTable({
			    "aLengthMenu": [
			        [10, 30, 50, -1],
			        [10, 30, 50, "Tất cả"]
			    ],
			    "iDisplayLength": 10,
			    "language": {
			        search: ""
			    }
			});
			$('#dataTableExample').each(function() {
			    var datatable = $(this);
			    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
			    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			    search_input.attr('placeholder', 'Search');
			    search_input.removeClass('form-control-sm');
			    // LENGTH - Inline-Form control
			    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			    length_sel.removeClass('form-control-sm');
			});
			$('#dataTableExample').DataTable().page(currentPage).draw('page');
		}, "json");
	}
	
	loadAccountList();
	
	$('#reloadDataButton').click(function(e,t) {
		loadAccountList(); 
		loadCategoryGiftCode();
	})
	
	$('#editAccount').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	console.log(button.data('account'));
	var accountData = (button.data('account')) // Extract info from data-* attributes
	var modal = $(this);
	//set data to form
	Object.keys(accountData).map(item => {
		if(item !== 'password') {
		    modal.find('.modal-body input[name='+item+']').val(accountData[item]);
		    modal.find('.modal-body select[name='+item+']').val(accountData[item]);
		}
	});
	
	modal.find('.modal-title').text('Edit account : ' + accountData['account'])
	});
	
	$('#editAccountSaveButton').click(function () {
		$.post("<?php homePath()?>ajax/editpackage.php",$('#editAccountForm').serialize(), (data) => {
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
	
	$('#createGiftCodeBtn').click(function () {
	    $('#createGiftCodeForm').submit();
	});
	
	 $('#createGiftCodeForm').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }

        $.post("<?php homePath()?>ajax/creategiftcode.php", $('#createGiftCodeForm').serialize(), (data) => {
            if (data.success) {
                Lobibox.notify("success", {
                    msg: data.success
                });
                download(data.filename, data.dataCode);
                loadCategoryGiftCode();
            } else {
                Lobibox.notify("error", {
                    msg: data.error
                });
            }
            $('#createGiftCode').modal('hide');
        }, "json")
        .always(function() {
            loadAccountList();
        });
        return false;
    });
    
    function loadCategoryGiftCode() {
    	$.post("<?php homePath()?>ajax/listcategorygiftcode.php", (data) => {
    		var htmlBody = "<option value=0>Tất cả</option>";
    		data.map(item => {
				htmlBody += '<option value=' + item.GiftID + '>'+ item.GiftID + ' - ' + item.Title + '</option>';
			});
			$('#giftCat').html(htmlBody);
        }, "json");
    }
    
    $('#giftCat').change(function(e,t) {
		loadAccountList(); 
	})
	
	$('#giftUsed').change(function(e,t) {
		loadAccountList(); 
	})
	
	$('#exportToFile').click(function () {
		var giftCat = $('#giftCat').val();
		var params = {
			GiftID: giftCat
		};
		
		filenameExport = 'CODETYPE' + $('#giftCat').val() + '-' + moment().format('DD-MM-YYYY-HHmmss');
		$.post("<?php homePath()?>ajax/giftcodelist.php", params, (data) => {
		var fileBody = "";
		data.map(item => {
		    fileBody += `${item.Code}\r\n`;
		});
		download(filenameExport, fileBody);
		
		Lobibox.notify("success", {
    		msg: 'Xuất file thành công'
        });
        
		}, "json");
	});
    
    function download(filename, text) {
      var element = document.createElement('a');
      element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
      element.setAttribute('download', filename);
    
      element.style.display = 'none';
      document.body.appendChild(element);
    
      element.click();
    
      document.body.removeChild(element);
    }

	});
</script>