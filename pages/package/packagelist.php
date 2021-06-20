<?php
use Models\DepositType;
use Carbon\Carbon;

$listDepType = DepositType::get();
?>	
<div class="page-content">

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">In-Game</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách gói</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <h6 class="card-title">Danh sách gói</h6>
            <p class="card-description"><a id="reloadDataButton" href="javascript:void(0)"> Tải lại </a></p>
            <div class="table-responsive">
            <table id="dataTableExample" class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ItemID</th>
                    <th>Loại</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Loại mua</th>
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
    <h5 class="modal-title" id="editAccountLabel">Sửa gói</h5>
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
        <label for="ItemID" class="col-form-label">ItemID:</label>
        <input type="text" class="form-control" name="ItemID"/>
    </div>
    <div class="form-group">
        <label for="Type" class="col-form-label">Loại:</label>
        <select class="form-control" name="Type">
            <?php 
            $listDepType->map(function ($item, $key) {
                echo "<option value=".$item['Type'].">".$item['Title']."</option>";
            });
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="Price" class="col-form-label">Giá:</label>
        <input type="text" name="Price"class="form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoUnmask' : true" />
    </div>
    <div class="form-group">
        <label for="Title" class="col-form-label">Tên gói:</label>
        <input type="text" name="Title" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="BuyType" class="col-form-label">Loại mua:</label>
        <select class="form-control" name="BuyType">
            <option value=1>Mua 1 lần 1 tuần</option>
            <option value=2>Mua 1 lần duy nhất</option>
            <option value=0>Mua không giới hạn</option>
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
<script type="text/javascript">
$(document).ready(function() {
    var listType = JSON.parse('<?php echo json_encode($listDepType->keyBy('Type'));?>');
function loadAccountList() {

    var listBuyType = {
        1: 'Mua hàng tuầN',
        2: 'Mua 1 lần',
        0: 'Mua không giới hạn'
    }

var currentPage = $('#dataTableExample').DataTable().page.info().page;
console.log(currentPage);
$('#dataTableExample').DataTable().destroy();
$('#dataTableExample tbody').html("Loading...");
$.post("<?php homePath()?>ajax/packagelist.php", (data) => {
var htmlBody = "";
data.map(item => {
    htmlBody += "<tr>\r\n";
    htmlBody += `	<td>${item.id}</td>\r\n`;
    htmlBody += `	<td>${item.ItemID}</td>\r\n`;
    htmlBody += `	<td>${listType[item.Type].Title}</td>\r\n`;
    htmlBody += `	<td>${item.Title}</td>\r\n`;
    htmlBody += `	<td>${item.Price}.00</td>\r\n`;
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
})

$('#editAccount').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
console.log(button.data('account'));
var accountData = (button.data('account')) // Extract info from data-* attributes
// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
var modal = $(this);
Object.keys(accountData).map(item => {
if(item !== 'password') {
    modal.find('.modal-body input[name='+item+']').val(accountData[item]);
    modal.find('.modal-body select[name='+item+']').val(accountData[item]);
}
})
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
});

</script>