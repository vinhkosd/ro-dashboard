<?php
validateLogin(true, false);//check account login
?>
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Paypal</a></li>
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
                    <div class="col-md-6">
                        <h6 class="card-title">Từ ngày</h6>
                        <div class="input-group date datepicker" id="fromDate">
                            <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="card-title">Đến ngày</h6>
                        <div class="input-group date datepicker" id="toDate">
                            <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
    						<th>AccID</th>
    						<th>Tài khoản</th>
    						<th>device</th>
    						<th>LoginDate</th>
    						<th>Email</th>
    						<th>Money</th>
    						<th>Email cũ</th>
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

<script type="text/javascript">
$(document).ready(function() {
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
        loadPayLogs(true);
    });

    
    $('#toDate input').change(function(e) {
        loadPayLogs(true);
    });

    initDatePicker('fromDate');
    initDatePicker('toDate');
    
    var dt = [];

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
		            "url": "<?php homePath()?>ajax/accountlogin.php",
		            "data": function ( d ) {
		                d.fromDate   = $('#fromDate input').val();
		                d.toDate     = $('#toDate input').val();
		            }
		        },
	        "order": [[ 0, "desc" ]],
	        "columns": [
	            { "data": "id", "searchable" : false },
	            { "data": "accid" },
	            { "data": "account" },
	            { "data": "device" },
	            { "data": "timestamp" , "searchable" : false,
                    render: function(data, type, row, meta) {
	                    return moment(data*1000).format('DD/MM/YYYY HH:mm:ss');
                	} 
	            },
	            { "data": "email" },
	            { "data": "money" , "searchable" : false },
	            { "data": "old_email" },
	        ],
		});
		
		 dt.on( 'draw', function () {
		     console.log('draw');
		     console.log(dt.ajax.json());
		     if(dt.ajax.json()) {
                var chiTietDoanhThuBody = "";
                var dataJson = dt.ajax.json();
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Theo bộ lọc</td>\n` ;
                chiTietDoanhThuBody += `    <td>${dt.ajax.json().totalRecord}</td>\n` ;
                chiTietDoanhThuBody += `</tr>\n` ;
                
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Hôm nay</td>\n` ;
                chiTietDoanhThuBody += `    <td>${dt.ajax.json().countToday}</td>\n` ;
                chiTietDoanhThuBody += `</tr>\n` ;
                
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Hôm qua</td>\n` ;
                chiTietDoanhThuBody += `    <td>${dt.ajax.json().countYesterday}</td>\n` ;
                chiTietDoanhThuBody += `</tr>\n` ;
                
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Tuần này</td>\n` ;
                chiTietDoanhThuBody += `    <td>${dt.ajax.json().countWeek}</td>\n` ;
                chiTietDoanhThuBody += `</tr>\n` ;
                
                chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
                chiTietDoanhThuBody += `    <td>Tháng này</td>\n` ;
                chiTietDoanhThuBody += `    <td>${dt.ajax.json().countMonth}</td>\n` ;
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
    var myLineChart = new Chart($('#chartjsPie'), {
		        type: 'pie',
		        data: {
		            labels: ["", ""],
		            datasets: [{
		                label: "USD",
		                backgroundColor: ["#f77eb9","#4d8af0"],
		                data: [0, 0]
		            }]
		        }
		    });
    
    function loadChartPie() {
				var params = {
	                fromDate: $('#fromDate input').val(),
	                toDate: $('#toDate input').val()
	            };
	            var label = [];
	            var dataChart= [];
				$.post("<?php homePath()?>ajax/getlogincountbydevice.php", params, (data) => {
				    data.map(item => {
						label.push(item['device']);
						dataChart.push(item['count']);
					});
					myLineChart.destroy();
		            myLineChart = new Chart($('#chartjsPie'), {
		                type: 'pie',
		                data: {
		                    labels: label,
		                    datasets: [{
		                        label: "Thiết bị",
		                        backgroundColor: [
							      'rgb(255, 99, 132)',
							      'rgb(75, 192, 192)',
							      'rgb(255, 205, 86)',
							      'rgb(201, 203, 207)',
							      'rgb(54, 162, 235)'
							    ],
		                        data: dataChart
		                    }]
		                }
		            });
				}, "json");
		            
		    }
		    
		    loadChartPie();
});

</script>