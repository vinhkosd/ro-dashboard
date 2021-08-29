<?php
validateLogin(true, false);//check account login
?>
<style>
td.details-control {
    background: url('<?php homePath()?>/assets/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('<?php homePath()?>/assets/images/details_close.png') no-repeat center center;
}
</style>
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Quản lý nạp chậm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử nạp</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body col-md-12" style="display:flex">
                    <h6 class="card-title">Lịch sử nạp</h6>
                </div>
                <div class="card-body col-md-12" style="display:flex">
                    <div class="col-md-4">
		                <h6 class="card-title">Loại thẻ</h6>
		                <div class="input-group">
		                   <select id="typeCard" name="typeCard" value="0">
		                   		<option value=-1>Tất cả</option>
		                   		<option value=0 selected>Thẻ chờ duyệt</option>
		                   		<option value=3>Thẻ thành công</option>
		                   		<option value=2>Thẻ sai mệnh giá</option>
		                   		<option value=1>Thẻ sai/Từ chối</option>
		                   	</select>
		                </div>
		            </div>
		            
                    <div class="col-md-4">
                        <h6 class="card-title">Từ ngày</h6>
                        <div class="input-group date datepicker" id="fromDate">
                            <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="card-title">Đến ngày</h6>
                        <div class="input-group date datepicker" id="toDate">
                            <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <button id="cancelAllRecord" type="button" class="btn btn-primary">Huỷ các lệnh đã chọn</button>
                    <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" name="checkAll" value="checkAll"></th>
                            <th></th>
                            <th>IMG</th>
                            <th>ID</th>
    						<th>AccID</th>
    						<th>Tài khoản</th>
    						<th>CreateDate</th>
    						<th>ChargeID</th>
    						<th>Money(USD)</th>
    						<th>Money(theo vùng)</th>
    						<th>Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                    <div class="row">
                        <div class="table-responsive pt-3 col-md-6">
                            <table class="table table-bordered" id="chiTietDoanhThu">
                                <thead>
                                    <tr>
                                        <th>Đăng nhập</th>
                                        <th>Count Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-info text-dark">
                                        <td>Ngày</td>
                                        <td>[login_count]</td>
                                    </tr>
                                    <tr class="table-warning text-dark">
                                        <td>Tháng</td>
                                        <td>[login_count]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-6 grid-margin stretch-card">
                            <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Biểu đồ</h6>
                                <canvas id="chartjsPie"></canvas>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<div id="suaGiaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="suaGiaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
    			<h5 class="modal-title">Sửa giá</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
    		<div class="modal-body">
    			<form id="suaGiaForm">
    				<input type="hidden" name="dataJson"/>
          			<div class="form-group">
                        <label for="money" class="col-form-label">Nhập giá mới: </label>
                        <input type="text" name="money"class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" required/>
                    </div>
                </form>
          	</div>
          	<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
    			<h5 class="modal-title">Sửa giá</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
    		<div class="modal-body">
    		    <span>Vui lòng xác nhận duyệt cho account!</span>
          	</div>
          	<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
                <button type="button" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php homePath()?>/assets/js/socket.io.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
    const socket = io('ragnarok.mobi:8868');
    socket.on('charge-reload', reloadChargeList);
    console.log(socket);
    
    function reloadChargeList() {
        $('#dataTableExample').DataTable().ajax.reload();//reload dữ liệu
    }
    
    $('#typeCard').change(function(e,t) {
		reloadChargeList(); 
	})
    
    function confirmModal(content, nextaction) {
        $('#confirmModal').find('.modal-body span').html(content);
        $('#confirmModal').modal();
        
        $('#confirmModal .modal-footer button.btn-primary').bind( "click", function() {
            $('#confirmModal .modal-footer button.btn-primary').unbind( "click" );
            console.log('Xác nhận');
            nextaction();
            $('#confirmModal').modal('hide');
            $('#confirmModal .modal-footer button.btn-primary').off();
            return false;
        });
    }
    
    $('#confirmModal').on('hidden.bs.modal', function () {
        $('#confirmModal .modal-footer button.btn-primary').off();
        $('#confirmModal .modal-footer button.btn-primary').unbind( "click" );
    });
    
    
    
    function initDatePicker(idElement, subMonth = 0) {
        if($(`#${idElement}`).length) {
            var date = new Date();
            // var today = new Date(date.getFullYear(), date.getMonth() - subMonth, date.getDate());
            $(`#${idElement}`).datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            // $(`#${idElement}`).datepicker('setDate', today);
        }
    }
    
    $('#fromDate input').change(function(e) {
        reloadChargeList();
    });

    
    $('#toDate input').change(function(e) {
        reloadChargeList();
    });

    initDatePicker('fromDate');
    initDatePicker('toDate');
    
    var dt = [];
    var checkedIds = [];
    
    function format ( d ) {
        var otherData = JSON.parse(d.otherdata);
        var otherDataText = [];
        otherData.map(item => {
            otherDataText += Object.keys(item)[0] + ': ' + Object.values(item)[0] +'<br>';
        });
        return otherDataText;
    }
    
    $('#checkAll').change(function(){
        isCheckAll = $(this).is(":checked");
        if(isCheckAll) {
            checkedIds = [];
            var dataTable = $('#dataTableExample').DataTable().ajax.json();
            checkedIds = dataTable.data.map(item=>item.id);
        } else {
            checkedIds = [];
        }
        console.log(checkedIds);
        $('#dataTableExample').DataTable().draw();//re-render table
    });
    
    $('#cancelAllRecord').click(function(){
        if(checkedIds.length > 0) {
            var dataTable = $('#dataTableExample').DataTable().ajax.json();
            confirmModal(`Vui lòng xác nhận huỷ ${checkedIds.length} lệnh`, () => cancelAllChargeStatus(checkedIds, dataTable));
        } else {
            Lobibox.notify("error", {
		        msg: 'Vui lòng chọn ít nhất 1 lệnh'
		    }); 
        }
    });
    
    function cancelAllChargeStatus(listId, dataTable) {
	    $.post("<?php homePath()?>ajax/chargependingchangeallstatus.php", {checkedIds: listId}, (data) => {
	        if(data.wrong_data && data.wrong_data.length > 0) {
	            data.wrong_data.map(item => {
	                Lobibox.notify("error", {
    			        msg: item
    			    }); 
	            });
	        }
	        
	        if(data.account && data.account.length > 0) {
	            data.account.map(item => {
	                let params = {
	                    account: item
	                };
	                socket.emit('join-room', `reload-account-info-${params.account}`);
			        socket.emit('reload-account-info', params);
	            });
	        }
	        
	        if(data.success && data.success.length > 0) {
	            Lobibox.notify("success", {
			        msg: `Huỷ ${data.success.length} lệnh (IDs: ${data.success.join(', ')}) thành công`
			    });
	        }
	        
	        if(socket.connected) {
			    socket.emit('charge-reload');
			} else {
			    reloadChargeList();
			}
			
			checkedIds = [];
		}, "json");
	}
		
    triggerCheckId = () => {
        $('.checkid').change(function(){
            var id = parseInt($(this).attr('check-id'), 10) || 0;
            isCheck = $(this).is(":checked");
            if(isCheck) {
                if(!checkedIds.includes(id)) {
                    checkedIds.push(id);
                }
            } else {
                if(checkedIds.includes(id)) {
                   const index = checkedIds.indexOf(id);
                    if (index > -1) {
                      checkedIds.splice(index, 1);
                    }
                }
            }
            console.log(checkedIds);
            $('#dataTableExample').DataTable().draw();//re-render table
        });
    }

    function loadPayLogs(isFilter = false) {
        dt = $('#dataTableExample').DataTable().destroy();
		dt = $('#dataTableExample').DataTable({
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
	        "ajax": {
		            "url": "<?php homePath()?>ajax/chargepending.php",
		            "data": function ( d ) {
		                d.fromDate   = $('#fromDate input').val();
		                d.toDate     = $('#toDate input').val();
		                d.status     = $('#typeCard').val();
		            }
		        },
	        "order": [[ 3, "desc" ]],
	        "columns": [
	            {
		                "orderable":      false,
		                "data":           "selectbox",
		                "searchable" : false,
    	                render: function(data, type, row, meta) {
    	                    var checked = checkedIds.includes(row.id);
    	                    return `<input type="checkbox" class="checkid" check-id="${row.id}" id="checked-${row.id}" name="checked-${row.id}" value="checked" ${checked ? "checked" : ""}>`;
    	                }
	            },
	            {
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
	            { "data": "img" , "searchable" : false,
	                render: function(data, type, row, meta) {
	                    return '<div style="background: white;width: 58px;height: 40px;"><div class="logo" style="width: 58px;height: 40px;border: 1px solid #bebebe;margin: 0 0px;background-size: contain;background-repeat: no-repeat;background-position: 50%;background-image: url(\'<?php homePath()?>'+row.img+'\');"></div></div>';
	                }
	            },
	            { "data": "id", "searchable" : false },
	            { "data": "accid" },
	            { "data": "account" },
	            { "data": "createdate" , "searchable" : false },
	            { "data": "charge_title" },
	            { "data": "money" , "searchable" : false },
	            { "data": "region_money" , "searchable" : false },
	            {
		                "orderable":      false,
		                "data":           "function",
		                "searchable" : false
	            },
	        ],
		});
		var detailRows = [];
 
        $('#dataTableExample tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );
     
            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();
     
                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();
     
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );
        
        
        // On each draw, loop over the `detailRows` array and show any child rows
        dt.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
                // $('#checkAll').trigger( 'change' );
            } );
            triggerCheckId();
            
            $('.btn-duyet').click(function() {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var rowData = row.data();
                var params = {
                    ...rowData,
                    status: 3
                }
                console.log(params);
                confirmModal(`Vui lòng xác nhận duyệt nạp ${parseFloat(params.money).toFixed(2)} $ cho account ${params.account}`, () => chargeStatus(params));
            });
            
            $('.btn-sua-gia').click(function() {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var rowData = row.data();
                $('#suaGiaModal').find('.modal-body input[name=dataJson]').val(JSON.stringify(rowData));
                $('#suaGiaModal').modal();
                $('#suaGiaModal .modal-footer button.btn-primary').click(function() {
                    $('#suaGiaModal .modal-footer button.btn-primary').unbind( "click" );
                    $('#suaGiaModal .modal-footer button.btn-primary').off();;
                    $('#suaGiaForm').submit();
                });
            });
            
            $('.btn-tu-choi').click(function() {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var rowData = row.data();
                var params = {
                    ...rowData,
                    status: 1
                }
                console.log(params);
                confirmModal(`Vui lòng xác nhận từ chối nạp account ${params.account}`, () => chargeStatus(params));
                // chargeStatus(params);
            });
        } );
        
        $('#suaGiaForm').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                return false;
            }
            
            var dataJson = $('#suaGiaModal').find('.modal-body input[name=dataJson]').val();
            var money = $('#suaGiaModal').find('.modal-body input[name=money]').val();
            dataJson = dataJson ? JSON.parse(dataJson) : [];
            var params = {
                ...dataJson,
                money,
                status: 2
            }
            confirmModal(`Vui lòng xác nhận sửa giá ${parseFloat(dataJson.money).toFixed(2)} $ thành ${parseFloat(money).toFixed(2)} $ cho account ${params.account}`, () => chargeStatus(params));
            // chargeStatus(params);
            $('#suaGiaModal').modal('hide');
            return false;
        });
		
		function chargeStatus(params) {
		    $.post("<?php homePath()?>ajax/chargependingchangestatus.php", params, (data) => {
    			if(data.success) {
    			    socket.emit('join-room', `reload-account-info-${params.account}`);
    			    socket.emit('reload-account-info', params);
    			    Lobibox.notify("success", {
    			        msg: data.success
    			    });
    			} else {
    			    Lobibox.notify("error", {
    			        msg: data.error
    			    });
    			}
    			if(socket.connected) {
    			    socket.emit('charge-reload');
    			} else {
    			    reloadChargeList();
    			}
    // 			$('#dataTableExample').DataTable().ajax.reload();//reload dữ liệu
    		}, "json");
		}
		
		 dt.on( 'draw', function () {
		  //   console.log('draw');
		  //   console.log(dt.ajax.json());
		     if(dt.ajax.json()) {
                var chiTietDoanhThuBody = "";
                var dataJson = dt.ajax.json();
                // chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                // chiTietDoanhThuBody += `    <td>Số bản ghi</td>\n` ;
                // chiTietDoanhThuBody += `    <td>${dt.ajax.json().totalRecord}</td>\n` ;
                // chiTietDoanhThuBody += `</tr>\n` ;
                
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Doanh thu</td>\n` ;
                chiTietDoanhThuBody += `    <td>${parseFloat(dt.ajax.json().totalAmount ? dt.ajax.json().totalAmount : 0).toFixed(2)} USD</td>\n` ;
                chiTietDoanhThuBody += `</tr>\n` ;
                
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Số người nạp</td>\n` ;
                chiTietDoanhThuBody += `    <td>${dt.ajax.json().countChageFilter}</td>\n` ;
                chiTietDoanhThuBody += `</tr>\n` ;
                
                $('#chiTietDoanhThu tbody').html(chiTietDoanhThuBody);
		     }
		     
        	$('#dataTableExample tbody').on( 'click', 'tr td.function-button', function () {
		        var tr = $(this).closest('tr');
		        var row = $('#dataTableExample').DataTable().row( tr );
		        $(this).find('button').attr('data-account', JSON.stringify(row.data()));
		    });
	    });
    }

    function calcutePaypal(money) {
        var calculated = (parseFloat(money) - parseFloat((0.044 * money + 0.3).toFixed(2))).toFixed(2);//phí ngoài nước 4.4% + 0.3$
        return calculated;
    }

    loadPayLogs();

    $('#reloadDataButton').click(function(e, t) {
        loadPayLogs(); 
    })
});

</script>