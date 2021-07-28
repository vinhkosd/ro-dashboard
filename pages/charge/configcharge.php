<?php
use Models\GiftCode; 
use Carbon\Carbon; 
validateLogin(true, false);//check account login


$giftCodeQuery = GiftCode::query();
$giftCodeQuery->groupBy('GiftID', 'Title');
$giftCodeCategorys = $giftCodeQuery->get(['GiftID', 'Title']);
?>

<style>
body ul {
  padding: 0px;
}
body ul .draggable {
  font-weight: 800;
  height: 40px;
  list-style-type: none;
  margin: 10px;
  background-color: white;
  color: #0072ff;
  width: 250px;
  line-height: 3.2;
  cursor: move;
  transition: all 200ms;
  user-select: none;
  margin: 10px auto;
  position: relative;
}
body ul .draggable:after {
  content: "kéo thả";
  right: 7px;
  font-size: 10px;
  position: absolute;
  cursor: pointer;
  line-height: 5;
  transition: all 200ms;
  transition-timing-function: cubic-bezier(0.48, 0.72, 0.62, 1.5);
  transform: translateX(120%);
  opacity: 0;
}
body ul .draggable:hover:after {
  opacity: 1;
  transform: translate(0);
}

.over {
  transform: scale(1.1, 1.1);
}

span.delete-span{
   background: #e74c3c;
	height: 40px;
	margin-right: 0px;
	text-align: center;
	color: white;
	width: 0;
	display: inline-block;
	transition: .1s linear;
    opacity: 0
}

span.edit-span{
   background: #3c81e7;
	height: 40px;
	margin-right: 20px;
	text-align: center;
	color: white;
	width: 0;
	display: inline-block;
	transition: .1s linear;
    opacity: 0
}

li:hover span {
    width: 40px;
    opacity: 1.0;
    cursor: pointer;
}

</style>
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
		            	<h6 class="card-title">Tạo</h6>
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
									<th>Tên</th>
									<th>Khu vực</th>
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
				<h5 class="modal-title" id="editAccountLabel">Sửa bank</h5>
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
				<h5 class="modal-title" id="createGiftCodeLabel">Tạo loại nạp mới</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="createGiftCodeForm">
					<div class="form-group">
						<label for="charge_title" class="col-form-label">Tên loại nạp:</label>
						<input type="text" class="form-control" name="charge_title" placeholder="Tên loại nạp. Ví dụ: GOPAY" required>
					</div>
				
					<div class="form-group">
						<label for="region" class="col-form-label">Tên khu vực:</label>
						<input type="text" name="region" class="form-control" required/>
					</div>
					
					<div class="form-group">
						<label for="region" class="col-form-label">Link IMG:</label>
						<input type="text" name="img" class="form-control" required/>
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

<div class="modal fade" id="listComponent" tabindex="-1" role="dialog" aria-labelledby="listComponentLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="listComponentLabel">danh sách component</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <h1>Sửa danh sách component</h1>
                    <div class="form-group">
                    	<label>Chọn loại component cần thêm: </label>
                    	<select id="componentType" class="w-100">
                    		<option value="InfoBox">InfoBox</option>
                    		<option value="Image">Image</option>
                    		<option value="Input">Input</option>
                    		<option value="Select">Select</option>
                    		<option value="InputNumber">InputNumber</option>
                    	</select>
                    </div>
                <button id="addComponent" type="button" class="btn btn-primary">Thêm</button>
                <ul class="draggable-list">
                </ul>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="listComponentSave">Lưu</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="componentEdit" tabindex="-1" role="dialog" aria-labelledby="componentEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="componentEditLabel">Sửa component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="saveComponentEditForm">
                	
                <input type="hidden" name="index" >
            	
                <div class="form-group">
                    <label for="label" class="col-form-label">Label:</label>
                    <input type="text" class="form-control" name="label">
                </div>
                <div class="form-group">
                    <label for="placeholder" class="col-form-label">Content/Placeholder:</label>
                    <input type="text" class="form-control" name="placeholder">
                </div>
                <div class="form-group">
                    <label for="option" class="col-form-label">Option(cho select, gõ xong enter):</label>
                    <input name="option" id="tags" value="" />
                </div>
                
                <div class="form-group">
                    <label for="align" class="col-form-label">Căn lề:</label>
                    <select name="align" class="w-100">
                        <option value="center">Giữa</option>
                		<option value="right">Trái</option>
                		<option value="left">Phải</option>
                	</select>
                </div>
                <div class="form-group">
                    <label for="disabled" class="col-form-label">Disabled:</label>
                    <select name="disabled" class="w-100">
                		<option value="true">True</option>
                		<option value="false" selected="selected">False</option>
                	</select>
                </div>
                
                <div class="form-group">
                    <label for="readonly" class="col-form-label">Readonly:</label>
                    <select name="readonly" class="w-100">
                		<option value="true">True</option>
                		<option value="false" selected="selected">False</option>
                	</select>
                </div>
                
                <div class="form-group">
                    <label for="required" class="col-form-label">Required:</label>
                    <select name="required" class="w-100">
                		<option value="true">True</option>
                		<option value="false" selected="selected">False</option>
                	</select>
                </div>
                
                <div class="form-group">
                    <label for="filter" class="col-form-label">Filter:</label>
                    <select name="filter" class="w-100">
                        null/số([0-9])/chữ thường([a-z])/chữ hoa([A-Z])/chữ hoa thường(a-zA-Z)/chữ & số (a-zA-Z0-9)/chữ & số & 1 số kí tự (a-zA-Z0-9._@%-), 
                		<option value="null">Không filter</option>
                		<option value="/[a-z]/g">chữ thường</option>
                		<option value="/[0-9]/g">số</option>
                		<option value="/[A-Z]/g">chữ hoa</option>
                		<option value="/[a-zA-Z]/g">chữ hoa thường</option>
                		<option value="/[a-zA-Z0-9]/g">chữ & số </option>
                		<option value="/[a-zA-Z0-9\.\@\_\-]/g">chữ & số & 1 số kí tự (a-zA-Z0-9._@%-)</option>
                		<option value="/[a-z0-9\.\@\_\-]/g">chữ thường & số & 1 số kí tự (a-zA-Z0-9._@%-)</option>
                	</select>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveComponentEdit">Save</button>
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
		
		$.post("<?php homePath()?>ajax/configchargelist.php", params, (data) => {
			var htmlBody = "";
			data.map(item => {
			    htmlBody += "<tr>\r\n";
			    htmlBody += `	<td>${item.id}</td>\r\n`;
			    htmlBody += `	<td>${item.charge_title}</td>\r\n`;
			    htmlBody += `	<td>${item.region}</td>\r\n`;
			    htmlBody += `	<td>`;
			    htmlBody += `		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account='${JSON.stringify(item)}'>Edit</button>\r\n`;
			    htmlBody += `		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#listComponent" data-account='${JSON.stringify(item)}'>List Component</button>\r\n`;
			    htmlBody += `	</td>\r\n`;
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
	
	$('#listComponent').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		console.log(button.data('account'));
		var accountData = (button.data('account')) // Extract info from data-* attributes
		
		if(typeof accountData.component_config == "string" || typeof accountData.list_component == "string") {
		accountData.component_config = accountData.component_config ? JSON.parse(accountData.component_config) : [];
		accountData.list_component = accountData.list_component ? JSON.parse(accountData.list_component) : [];
		}
		
		$.chargeConfig = accountData;//set temp data to $.chargeConfig
		
		$("ul.draggable-list").empty();
		accountData.list_component && accountData.list_component.map(item => {
			addNewItem(item);
		});
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
	
	$('#saveComponentEdit').click(function () {
	    $('#saveComponentEditForm').submit();
	});
	
	$('#saveComponentEditForm').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        
        var frmData = $('#saveComponentEditForm').serializeArray();
        var index = null;
        var componentConfig = {};
        frmData.map(item => {
        	if(item.name != 'index') {
        		componentConfig[item.name] = item.value;
        	} else {
        		index = parseInt(item.value, 10);
        	}
        });
        
		$.chargeConfig.component_config[index] = componentConfig;
        $('#saveComponentEditForm').trigger("reset");
        $('#componentEdit').modal('hide');
        return false;
    });
	
	 $('#createGiftCodeForm').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }

        $.post("<?php homePath()?>ajax/createchargeconfig.php", $('#createGiftCodeForm').serialize(), (data) => {
            if (data.success) {
                Lobibox.notify("success", {
                    msg: data.success
                });
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
    
    function dragStart(e) {
    console.log('dragStart');
    console.log(e);
      this.style.opacity = '0.4';
      dragSrcEl = this;
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/html', this.innerHTML);
    };
    
    function dragEnter(e) {
      this.classList.add('over');
    }
    
    function dragLeave(e) {
      e.stopPropagation();
      this.classList.remove('over');
    }
    
    function dragOver(e) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
      return false;
    }
    
    function dragDrop(e) {
      if (dragSrcEl != this) {
        dragSrcEl.innerHTML = this.innerHTML;
        this.innerHTML = e.dataTransfer.getData('text/html');
      }
      return false;
    }
    
    function dragEnd(e) {
    	console.log('dragEnd');
    	console.log(e);
      var listItens = document.querySelectorAll('.draggable');
      [].forEach.call(listItens, function(item) {
        item.classList.remove('over');
      });
      this.style.opacity = '1';
    }
    
    function addEventsDragAndDrop(el) {
      el.addEventListener('dragstart', dragStart, false);
      el.addEventListener('dragenter', dragEnter, false);
      el.addEventListener('dragover', dragOver, false);
      el.addEventListener('dragleave', dragLeave, false);
      el.addEventListener('drop', dragDrop, false);
      el.addEventListener('dragend', dragEnd, false);
    }
    
    var listItens = document.querySelectorAll('.draggable');
    [].forEach.call(listItens, function(item) {
      addEventsDragAndDrop(item);
    });
    
    function addNewItem(textValue = false) {
      var newItem = (!textValue ? document.querySelector('.input').value : textValue);
      if (newItem != '') {
        var li = document.createElement('li');
        var attr = document.createAttribute('draggable');
        li.className = 'draggable';
        attr.value = 'true';
        
        var spanDelete = document.createElement('span');
        spanDelete.classList.add('delete-span');
        spanDelete.innerHTML = "<i class='fa fa-trash' aria-hidden='true'></i>";
        
        var spanEdit = document.createElement('span');
        spanEdit.classList.add('edit-span');
        spanEdit.innerHTML = "<i class='fa fa-edit' aria-hidden='true'></i>";
        
        li.setAttributeNode(attr);
        
        li.appendChild(spanDelete);
        li.appendChild(spanEdit);
        li.appendChild(document.createTextNode(newItem));
        $("ul.draggable-list").append(li);
        addEventsDragAndDrop(li);
      }
    }
    
    $('#addComponent').click(function(e) {
        var maxIndex = 0;
        for(var i = 0;i < $("ul.draggable-list").children().length; i++){
			var item = $("ul.draggable-list").children()[i];
			var innerText = parseInt(item.innerText.split('-')[1], 10);
			// console.log(item);
			if(maxIndex <= parseInt(innerText, 10)) maxIndex = parseInt(innerText, 10) + 1;
		}
		
		var textVal = $('#componentType').val() + '-' + maxIndex;
		
        addNewItem(textVal);
    });
    
    $("ul.draggable-list").on("click", "li span.delete-span", function(event){
        $(this).parent().remove();
        event.stopPropagation(); 
    });
    
    $("ul.draggable-list").on("click", "li span.edit-span", function(event){
    	$('#tags').importTags('');
    	$('#saveComponentEditForm').trigger("reset");
        var index = parseInt($(this).parent()[0].innerText.split('-')[1], 10);
        var modal = $('#componentEdit');
        
        modal.find('.modal-body input[name=index]').val(index);
        if($.chargeConfig.component_config && $.chargeConfig.component_config[index]) {//nếu đã có config thì load config ra
        	console.log($.chargeConfig.component_config[index]);
        } else {//chưa có thì tạo mới
        	if(!$.chargeConfig.component_config) $.chargeConfig.component_config = [];
        	for(var i = 0; i <= index; i++) {//vòng lặp từ đầu tiên tới index, nếu config nào chưa có thì tạo mới
        		if(!$.chargeConfig.component_config[i]) {
        			$.chargeConfig.component_config[i] = {};
        		}
        	}
        	console.log($.chargeConfig.component_config);
        }
        
        Object.keys($.chargeConfig.component_config[index]).map(item => {
            modal.find('.modal-body input[name='+item+']').val($.chargeConfig.component_config[index][item]);
            modal.find('.modal-body select[name='+item+']').val($.chargeConfig.component_config[index][item]);
            if(typeof modal.find('.modal-body input[name='+item+']').importTags  == "function") {
            	modal.find('.modal-body input[name='+item+']').importTags($.chargeConfig.component_config[index][item]);
            }
        });
        
        $('#componentEdit').modal();
    });
    
    $('#tags').tagsInput({
        'width': '100%',
        'height': '75%',
        'interactive': true,
        'defaultText': 'Tên option',
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 40,
        'placeholderColor': '#666666'
	});
	
	$('#listComponentSave').click(function() {
		$.chargeConfig.list_component = [];
		
		for(var i = 0;i < $("ul.draggable-list").children().length; i++){
			var item = $("ul.draggable-list").children()[i];
			$.chargeConfig.list_component.push(item.innerText);
		}
		
		$.chargeConfig.component_config = $.chargeConfig.component_config ? JSON.stringify($.chargeConfig.component_config) : '';
		$.chargeConfig.list_component = $.chargeConfig.list_component ? JSON.stringify($.chargeConfig.list_component) : '';
		
		$.post("<?php homePath()?>ajax/savechargeconfig.php", $.chargeConfig, (data) => {
            if (data.success) {
                Lobibox.notify("success", {
                    msg: data.success
                });
            } else {
                Lobibox.notify("error", {
                    msg: data.error
                });
            }
            $('#listComponent').modal('hide');
        }, "json");
	});
});

</script>
