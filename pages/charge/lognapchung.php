<?php
validateLogin(true, false);//check account login
?>
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Account</a></li>
						<li class="breadcrumb-item active" aria-current="page">List Account</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body col-md-12" style="display:flex">
			                    <h6 class="card-title">Log nạp chung</h6>
			                </div>
			                <div class="card-body col-md-12" style="display:flex">
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
								<h6 class="card-title">Account List</h6>
								<p class="card-description"><a id="reloadDataButton" href="javascript:void(0)"> Reload Data </a></p>
								<div class="table-responsive">
									<table id="dataTableExample" class="table">
										<thead>
										<tr>
											<th>ID</th>
											<th>AccID</th>
											<th>Account</th>
											<th>Money</th>
											<th>Time</th>
											<th>Chargetitle</th>
											<th>ChargeType</th>
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
			                                        <th>Từ</th>
			                                        <th>Đến</th>
			                                        <th>Loại</th>
			                                        <th>Số tiền</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                    <tr class="table-info text-dark">
			                                        <td>2021-06-06 06:22:44</td>
			                                        <td>2021-06-06 06:22:44</td>
			                                        <td>Tổng doanh thu</td>
			                                        <td>[so_tien] USD</td>
			                                    </tr>
			                                    <tr class="table-warning text-dark">
			                                        <td>2021-06-06 06:22:44</td>
			                                        <td>2021-06-06 06:22:44</td>
			                                        <td>Tổng thực nhận</td>
			                                        <td>[so_tien] USD</td>
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
		    
			var dt;
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
		        $('#dataTableExample').DataTable().ajax.reload();//reload dữ liệu
		        loadChartPie();
		    });
		
		    
		    $('#toDate input').change(function(e) {
		        $('#dataTableExample').DataTable().ajax.reload();//reload dữ liệu
		        loadChartPie();
		    });
		
		    initDatePicker('fromDate');
		    initDatePicker('toDate');
			function loadAccountList() {
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
				            "url": "<?php homePath()?>ajax/lognapchung_serverside.php",
				            "data": function ( d ) {
				                d.fromDate   = $('#fromDate input').val();
				                d.toDate     = $('#toDate input').val();
				            }
				        },
			        "order": [[ 4, "desc" ]],
			        "columns": [
			            { "data": "id", "searchable" : false },
			            { "data": "accid" },
			            { "data": "account" },
			            { "data": "money" , "searchable" : false },
			            { "data": "createdate" , 
			            	render: function(data, type, row, meta) {
			                    return moment(data*1000).format('DD/MM/YYYY HH:mm:ss');
		                	}
			            },
			            { "data": "charge_title"},
			            { "data": "img" , "searchable" : false,
			                render: function(data, type, row, meta) {
			                    return '<div style="background: white;width: 58px;height: 40px;"><div class="logo" style="width: 58px;height: 40px;border: 1px solid #bebebe;margin: 0 0px;background-size: contain;background-repeat: no-repeat;background-position: 50%;background-image: url(\'<?php homePath()?>'+row.img+'\');"></div></div>';
			                }
			            },
			        ],
				});
			}
			loadAccountList();
			$('#reloadDataButton').click(function(e,t) {
				$('#dataTableExample').DataTable().destroy();loadAccountList(); 
			});
			
			function loadChartPie() {
				var params = {
	                fromDate: $('#fromDate input').val(),
	                toDate: $('#toDate input').val()
	            };
	            var label = ["Paypal"];
	            var dataChart= [];
				$.post("<?php homePath()?>ajax/getlognapchungdoanhthu.php", params, (data) => {
					var tongDoanhThu = 0;
					var chiTietDoanhThuBody = '';
					tongDoanhThu = data['paypal'][0]['money'];
					dataChart = [data['paypal'][0]['money']];
					chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
					chiTietDoanhThuBody += `    <td>${$('#fromDate input').val()}</td>\n` ;
	                chiTietDoanhThuBody += `    <td>${$('#toDate input').val()}</td>\n` ;
	                chiTietDoanhThuBody += `    <td>Paypal</td>\n` ;
	                chiTietDoanhThuBody += `    <td>${data['paypal'][0]['money']}</td>\n` ;
	                chiTietDoanhThuBody += `</tr>\n` ;
					data['other'].map(item => {
						label.push(item['charge_title']);
						dataChart.push(item['money']);
						tongDoanhThu += item['money'];
						chiTietDoanhThuBody += `<tr class=\"table-info text-dark\">\n`;
		                chiTietDoanhThuBody += `    <td>${$('#fromDate input').val()}</td>\n` ;
		                chiTietDoanhThuBody += `    <td>${$('#toDate input').val()}</td>\n` ;
		                chiTietDoanhThuBody += `    <td>${item['charge_title']}</td>\n` ;
		                chiTietDoanhThuBody += `    <td>${parseFloat(item['money']).toFixed(2)}</td>\n` ;
		                chiTietDoanhThuBody += `</tr>\n` ;
					});
					
					myLineChart.destroy();
		            myLineChart = new Chart($('#chartjsPie'), {
		                type: 'pie',
		                data: {
		                    labels: label,
		                    datasets: [{
		                        label: "USD",
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
		            
		            chiTietDoanhThuBody += "<tr class=\"table-info text-dark\">\n" +
		                `                                    <td>${$('#fromDate input').val()}</td>\n` +
		                `                                    <td>${$('#toDate input').val()}</td>\n` +
		                `                                    <td>Tổng doanh thu</td>\n` +
		                `                                    <td>${parseFloat(tongDoanhThu).toFixed(2)} USD</td>\n` +
		                `                                </tr>\n` ;
		            
		            $('#chiTietDoanhThu tbody').html(chiTietDoanhThuBody);
				}, "json");
		            
		    }
		    
		    loadChartPie();
		});
    </script>