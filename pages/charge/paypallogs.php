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
                    <div class="col-sm-12 col-md-6">
                        <div id="filterText" class="dataTables_filter">
                            <label>
                                <input type="search" class="form-control" placeholder="Tìm kiếm" aria-controls="dataTableExample">
                            </label>
                        </div>
                    </div>
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
                            <th>Loại</th>
                            <th>Số tiền</th>
                            <th>Thực nhận</th>
                            <th>ID Tài khoản</th>
                            <th>Tài khoản</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Note</th>
                            <th>Thời gian</th>
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
        <input type="text" class="form-control" id="account" name="account">
    </div>
    <div class="form-group">
        <label for="email" class="col-form-label">Email:</label>
        <!-- <input type="text" class="form-control" id="email" name="email"> -->
        <input type="text" id="email" name="email" class="form-control" data-inputmask="'alias': 'email', 'clearIncomplete': true"/>
    </div>
    <div class="form-group">
        <label for="password" class="col-form-label">Mật khẩu (Không sửa thì có thể để trống):</label>
        <input type="text" class="form-control" id="password" name="password">
    </div>
    <div class="form-group">
        <label for="money" class="col-form-label">Money:</label>
        <!-- <input type="text" class="form-control" id="money" name="money"> -->
        <input type="text" id="money" name="money"class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true"/>
    </div>
    <div class="form-group">
        <label for="old_email" class="col-form-label">Email Cũ:</label>
        <!-- <input type="text" class="form-control" id="old_email" name="old_email"> -->
        <input type="text" id="old_email" name="old_email" class="form-control" data-inputmask="'alias': 'email', 'clearIncomplete': true"/>
    </div>
    <div class="form-group">
        <label for="regtime" class="col-form-label">Thời gian đăng ký:</label>
        <!-- <input type="text" class="form-control" id="regtime" name="regtime"> -->
        <input type="text" id="regtime" name="regtime" class="form-control" data-inputmask="'alias': 'datetime', 'clearIncomplete': true" data-inputmask-inputformat="yyyy-mm-dd HH:MM:ss" />
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
<script type="text/javascript">
$(document).ready(function() {
    function initDatePicker(idElement, subMonth = 0) {
        if($(`#${idElement}`).length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth() - subMonth, date.getDate());
            $(`#${idElement}`).datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $(`#${idElement}`).datepicker('setDate', today);
        }
    }
    var timeoutSearch = null;
    $('#filterText input').change(function(e) {
        if(timeoutSearch) {
            clearTimeout(timeoutSearch);
        }

        timeoutSearch = setTimeout(() => {
            loadPayLogs(true);
        }, 200);
    });

    
    $('#fromDate input').change(function(e) {
        loadPayLogs(true);
    });

    
    $('#toDate input').change(function(e) {
        loadPayLogs(true);
    });

    initDatePicker('fromDate');
    initDatePicker('toDate');

    function loadPayLogs(isFilter = false) {
        var currentPage = $('#dataTableExample').DataTable().page.info().page;
        $('#dataTableExample').DataTable().destroy();
        $('#dataTableExample tbody').html("Loading...");
        var dateParams = isFilter ? `fromDate=${$('#fromDate input').val()}&toDate=${$('#toDate input').val()}&filterText=${$('#filterText input').val()}` : '';

        $.post("<?php homePath()?>ajax/paypallogs.php", dateParams, (data) => {
            var chiTietDoanhThuBody = "";
            var htmlBody = "";
            var tongDoanhThu = 0;
            var tongThucNhan = 0;
            data.map(item => {
                htmlBody += "<tr>\r\n";
                htmlBody += `	<td>${item.id}</td>\r\n`;
                htmlBody += `	<td>${item.card_type}</td>\r\n`;
                htmlBody += `	<td>${item.money} USD</td>\r\n`;
                htmlBody += `	<td>${calcutePaypal(item.money)} USD</td>\r\n`;
                htmlBody += `	<td>${item.account_id}</td>\r\n`;
                htmlBody += `	<td>${item.account}</td>\r\n`;
                htmlBody += `	<td>${item.account_email}</td>\r\n`;
                htmlBody += `	<td>${item.status}</td>\r\n`;
                htmlBody += `	<td>${item.note}</td>\r\n`;
                htmlBody += `	<td>${item.time}</td>\r\n`;
                htmlBody += `	<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account='${JSON.stringify(item)}'>Xem</button></td>\r\n`;
                htmlBody += "</tr>\r\n";

                tongDoanhThu += item.money;
                tongThucNhan += parseFloat(calcutePaypal(item.money));
            });
            chiTietDoanhThuBody += "<tr class=\"table-info text-dark\">\n" +
                `                                    <td>2021-06-06 06:22:44</td>\n` +
                `                                    <td>2021-06-06 06:22:44</td>\n` +
                `                                    <td>Tổng doanh thu</td>\n` +
                `                                    <td>${tongDoanhThu} USD</td>\n` +
                `                                </tr>\n` +
                `                                <tr class=\"table-warning text-dark\">\n` +
                `                                    <td>2021-06-06 06:22:44</td>\n` +
                `                                    <td>2021-06-06 06:22:44</td>\n` +
                `                                    <td>Tổng thực nhận</td>\n` +
                `                                    <td>${tongThucNhan.toFixed(2)} USD</td>\n` +
                "                                </tr>";
            loadChartPie([tongThucNhan.toFixed(2), (tongDoanhThu - tongThucNhan).toFixed(2)])
            $('#chiTietDoanhThu tbody').html(chiTietDoanhThuBody);
            $('#dataTableExample tbody').html(htmlBody);


            $('#dataTableExample').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tất cả"]
                ],
                "iDisplayLength": 10,
                // "language": {
                //     search: ""
                // },
                "searching": false,
                "order": [[ 0, "desc" ]],
            });
            $('#dataTableExample').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                // var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                // search_input.attr('placeholder', 'Search');
                // search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
            $('#dataTableExample').DataTable().page(currentPage).draw('page');
        }, "json");
    }

    function calcutePaypal(money) {
        var calculated = (parseFloat(money) - parseFloat((0.044 * money + 0.3).toFixed(2))).toFixed(2);//phí ngoài nước 4.4% + 0.3$
        return calculated;
    }

    loadPayLogs();

    $('#reloadDataButton').click(function(e, t) {
        loadPayLogs(); 
    })

    $('#editAccount').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        console.log(button.data('account'));
        var accountData = (button.data('account')) // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        console.log(accountData)
        Object.keys(accountData).map(item => {
            if(item !== 'password') {
                modal.find('.modal-body input[name='+item+']').val(accountData[item]);
            }
        })
        modal.find('.modal-title').text('Xem : ' + accountData['account'])
    });

    $('#editAccountSaveButton').click(function () {
        // $.post("<?php homePath()?>ajax/editaccount.php",$('#editAccountForm').serialize(), (data) => {
        // if(data.success) {
        //     Lobibox.notify("success", {
        //         msg: data.success
        //     });
        // } else {
        //     Lobibox.notify("error", {
        //         msg: data.error
        //     });
        // }
        // $('#editAccount').modal('hide');
        // }, "json")
        // .always(function() {
        //     loadPayLogs();
        // });
        return false;
    });
    var myLineChart = new Chart($('#chartjsPie'), {
        type: 'pie',
        data: {
            labels: ["Thực nhận", "Chiết khấu"],
            datasets: [{
                label: "USD",
                backgroundColor: ["#f77eb9","#4d8af0"],
                data: [0, 0]
            }]
        }
    });

    function loadChartPie(data = [0, 0]) {
        if($('#chartjsPie').length) {
            myLineChart.destroy();
            myLineChart = new Chart($('#chartjsPie'), {
                type: 'pie',
                data: {
                    labels: ["Thực nhận", "Chiết khấu"],
                    datasets: [{
                        label: "USD",
                        backgroundColor: ["#f77eb9","#4d8af0"],
                        data: data
                    }]
                }
            });
            
            // new Chart($('#chartjsPie'), {
            //     type: 'pie',
            //     data: {
            //         labels: ["Thực nhận", "Chiết khấu"],
            //         datasets: [{
            //             label: "USD",
            //             backgroundColor: ["#f77eb9","#4d8af0"],
            //             data: data
            //         }]
            //     }
            // });
        }
    }
    loadChartPie();
});

</script>