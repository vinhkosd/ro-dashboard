<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Đấu giá</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách đấu giá</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Danh sách đấu giá</h6>
                    <p class="card-description"><a id="reloadDataButton" href="javascript:void(0)"> Tải lại </a></p>
                    <p class="card-description">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAuction">
                            Thêm mới
                        </button>
                    </p>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>BatchID</th>
                                    <th>ItemID</th>
                                    <th>BasePrice</th>
                                    <th>TradePrice</th>
                                    <th>ZenyPrice</th>
                                    <th>Action House</th>
                                    <th>IsTemp</th>
                                    <th>IsRead</th>
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

<div class="modal fade" id="addAuction" tabindex="-1" role="dialog" aria-labelledby="addAuctionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAuctionLabel">Sửa auctionItem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addAuctionForm">
                    <div class="form-group">
                        <label for="batchid" class="col-form-label">BatchID:</label>
                        <input type="text" class="form-control" name="batchid" value=1 readonly>
                    </div>
                    <div class="form-group">
                        <label for="itemid" class="col-form-label">ItemID:</label>
                        <input type="text" class="form-control" name="itemid" required>
                    </div>
                    <div class="form-group">
                        <label for="base_price" class="col-form-label">BasePrice:</label>
                        <input type="text" name="base_price" class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" required/>
                    </div>
                    <div class="form-group">
                        <label for="trade_price" class="col-form-label">TradePrice:</label>
                        <input type="text" name="trade_price" class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" required/>
                    </div>
                    <div class="form-group">
                        <label for="zeny_price" class="col-form-label">ZenyPrice:</label>
                        <input type="text" name="zeny_price" class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" required/>
                    </div>
                    <div class="form-group">
                        <label for="auction" class="col-form-label">Được gửi vào AuctionHouse:</label>
                        <select class="form-control" name="auction" required>
                            <option value=0 selected>chưa được phép gửi vào AUCTION HOUSE</option>
                            <option value=1>Được phép gửi vào AUCTION HOUSE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="istemp" class="col-form-label">Đưa lên hệ thống:</label>
                        <select class="form-control" name="istemp" required>
                            <option value=0 selected>Đang chỉnh sửa</option>
                            <option value=1>Đưa lên sàn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="isread" class="col-form-label">Đã đưa lên hệ thống:</label>
                        <select class="form-control" name="isread" readonly>
                            <option disabled selected value=0>False</option>
                            <option disabled value=1>True</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
                <button type="button" class="btn btn-primary" id="addAuctionBtn">Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAuction" tabindex="-1" role="dialog" aria-labelledby="editAuctionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAuctionLabel">Sửa auctionItem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAuctionForm">
                    <div class="form-group">
                        <label for="batchid" class="col-form-label">BatchID:</label>
                        <input type="text" class="form-control" name="batchid" readonly>
                    </div>
                    <div class="form-group">
                        <label for="itemid" class="col-form-label">ItemID:</label>
                        <input type="text" class="form-control" name="itemid" readonly>
                    </div>
                    <div class="form-group">
                        <label for="base_price" class="col-form-label">BasePrice:</label>
                        <input type="text" name="base_price" class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" />
                    </div>
                    <div class="form-group">
                        <label for="trade_price" class="col-form-label">TradePrice:</label>
                        <input type="text" name="trade_price" class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" />
                    </div>
                    <div class="form-group">
                        <label for="zeny_price" class="col-form-label">ZenyPrice:</label>
                        <input type="text" name="zeny_price" class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" />
                    </div>
                    <div class="form-group">
                        <label for="auction" class="col-form-label">Được gửi vào AuctionHouse:</label>
                        <select class="form-control" name="auction">
                            <option value=0>chưa được phép gửi vào AUCTION HOUSE</option>
                            <option value=1>Được phép gửi vào AUCTION HOUSE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="istemp" class="col-form-label">Đưa lên hệ thống:</label>
                        <select class="form-control" name="istemp">
                            <option value=0>Đang chỉnh sửa</option>
                            <option value=1>Đưa lên sàn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="isread" class="col-form-label">Đã đưa lên hệ thống:</label>
                        <select class="form-control" name="isread" readonly>
                            <option disabled value=0>False</option>
                            <option disabled value=1>True</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
                <button type="button" class="btn btn-primary" id="editAuctionSaveBtn">Sửa</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteAuction" tabindex="-1" role="dialog" aria-labelledby="deleteAuctionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAuctionLabel">Xoá auctionItem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span></span>
                <form id="deleteAuctionForm" style="display:none">
                    <div class="form-group">
                        <label for="itemid" class="col-form-label">ItemID:</label>
                        <input type="text" class="form-control" name="itemid" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
                <button type="button" class="btn btn-primary" id="deleteAuctionBtn">Xoá</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        function loadItemList() {
            var currentPage = $('#dataTableExample').DataTable().page.info().page;
            console.log(currentPage);
            $('#dataTableExample').DataTable().destroy();
            $('#dataTableExample tbody').html("Loading...");
            $.post("<?php homePath()?>ajax/listauction.php", (data) => {
                var htmlBody = "";
                data.map(item => {
                    htmlBody += "<tr>\r\n";
                    htmlBody += `	<td>${item.batchid}</td>\r\n`;
                    htmlBody += `	<td>${item.itemid}</td>\r\n`;
                    htmlBody += `	<td>${item.base_price}</td>\r\n`;
                    htmlBody += `	<td>${item.trade_price}</td>\r\n`;
                    htmlBody += `	<td>${item.zeny_price}</td>\r\n`;
                    htmlBody += `	<td>${item.auction == 1? 'Được phép đưa vào AuctionHouse' : 'Không đưa vào AuctionHouse'}</td>\r\n`;
                    htmlBody += `	<td>${item.istemp == 1? 'Đưa lên sàn' : 'Đang chỉnh sửa'}</td>\r\n`;
                    htmlBody += `	<td>${item.isread == 1? 'Đã đưa lên sàn' : 'GS chưa lên sàn'}</td>\r\n`;
                    htmlBody += `	<td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAuction" data-account='${JSON.stringify(item)}'>
                            Sửa
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteAuction" data-account='${JSON.stringify(item)}'>
                            Xoá
                        </button>
                    </td>\r\n`;
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
        loadItemList();
        $('#reloadDataButton').click(function(e, t) {
            loadItemList();
        })

        $('#editAuction').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            console.log(button.data('account'));
            var auctionData = (button.data('account')) // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            Object.keys(auctionData).map(item => {
                if (item !== 'password') {
                    modal.find('.modal-body input[name=' + item + ']').val(auctionData[item]);
                    modal.find('.modal-body select[name=' + item + ']').val(auctionData[item]);
                }
            })
            modal.find('.modal-title').text('Edit item : ' + auctionData['itemid'])
        });

        $('#deleteAuction').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            console.log(button.data('account'));
            var auctionData = (button.data('account')) // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            Object.keys(auctionData).map(item => {
                modal.find('.modal-body input[name=' + item + ']').val(auctionData[item]);
                console.log(modal.find('.modal-body input[name=' + item + ']').val());
            });
            var text = "Vui lòng xác nhận xoá auctionItem [itemid]";
            text = text.replace('[itemid]', auctionData.itemid);
            modal.find('.modal-body span').html(text);
        });

        $('#editAuctionSaveBtn').click(function() {
            $.post("<?php homePath()?>ajax/editauction.php", $('#editAuctionForm').serialize(), (data) => {
                    if (data.success) {
                        Lobibox.notify("success", {
                            msg: data.success
                        });
                    } else {
                        Lobibox.notify("error", {
                            msg: data.error
                        });
                    }
                    $('#editAuction').modal('hide');
                }, "json")
                .always(function() {
                    loadItemList();
                });
            return false;
        });

        $('#deleteAuctionBtn').click(function() {
            $.post("<?php homePath()?>ajax/deleteauction.php", $('#deleteAuctionForm').serialize(), (data) => {
                    if (data.success) {
                        Lobibox.notify("success", {
                            msg: data.success
                        });
                    } else {
                        Lobibox.notify("error", {
                            msg: data.error
                        });
                    }
                    $('#deleteAuction').modal('hide');
                }, "json")
                .always(function() {
                    loadItemList();
                });
            return false;
        });

        $('#addAuctionBtn').click(function() {
            $('#addAuctionForm').submit();
        });
        $('#addAuctionForm').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
                return false;
            }

            $.post("<?php homePath()?>ajax/addauction.php", $('#addAuctionForm').serialize(), (data) => {
                if (data.success) {
                    Lobibox.notify("success", {
                        msg: data.success
                    });
                } else {
                    Lobibox.notify("error", {
                        msg: data.error
                    });
                }
                $('#addAuction').modal('hide');
            }, "json")
            .always(function() {
                loadItemList();
            });
            return false;
        });
    });
</script>