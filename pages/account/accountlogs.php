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
						<div class="card-body">
							<h6 class="card-title">Account List</h6>
							<p class="card-description"><a id="reloadDataButton" href="javascript:void(0)"> Reload Data </a></p>
							<div class="table-responsive">
							<table id="dataTableExample" class="table">
								<thead>
								<tr>
									<th>ID</th>
									<th>Account</th>
									<th>CharID</th>
									<th>Title</th>
									<th>Content</th>
									<th>Time</th>
									<th>Type</th>
									<th>Zone</th>
									<th>Signature(RAW JSON)</th>
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
    <script type="text/javascript">
		$(document).ready(function() {
			function loadAccountList() {
				$('#dataTableExample tbody').html("Loading...");
				$.post("<?php homePath()?>ajax/accountlogs.php", (data) => {
					var htmlBody = "";
					data.map(item => {
						htmlBody += "<tr>\r\n";
						htmlBody += `	<td>${item.id}</td>\r\n`;
						htmlBody += `	<td>${item.account}</td>\r\n`;
						htmlBody += `	<td>${item.charid}</td>\r\n`;
						htmlBody += `	<td>${item.log_title}</td>\r\n`;
						htmlBody += `	<td>${item.log_content}</td>\r\n`;
						htmlBody += `	<td>${item.log_time}</td>\r\n`;
						htmlBody += `	<td>${item.zoneid}</td>\r\n`;
						htmlBody += `	<td>${item.type}</td>\r\n`;
						htmlBody += `	<td>${item.signature}</td>\r\n`;
						htmlBody += "</tr>\r\n";
					});
					$('#dataTableExample tbody').html(htmlBody);

					$('#dataTableExample').DataTable({
						"aLengthMenu": [
							[10, 30, 50, -1],
							[10, 30, 50, "All"]
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
				}, "json");
			}
			loadAccountList();
			// $('#reloadDataButton').click(function{
			// 	loadAccountList();
			// });
			$('#reloadDataButton').click(function(e,t) {
				$('#dataTableExample').DataTable().destroy();loadAccountList(); 
			})
		});

		// $('#dataTableExample tbody').html()
    </script>