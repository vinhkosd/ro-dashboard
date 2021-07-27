<?php
use Models\AccountLogin;
use Models\PaymentLogs;
use Models\ChargeCustomLogs;
use Carbon\Carbon;
?>			
      <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
              <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
              <input type="text" class="form-control">
            </div>
            <!--button type="button" class="btn btn-outline-info btn-icon-text mr-2 d-none d-md-block">
              <i class="btn-icon-prepend" data-feather="download"></i>
              Import
            </button>
            <button type="button" class="btn btn-outline-primary btn-icon-text mr-2 mb-2 mb-md-0">
              <i class="btn-icon-prepend" data-feather="printer"></i>
              Print
            </button>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
              <i class="btn-icon-prepend" data-feather="download-cloud"></i>
              Download Report
            </button-->
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
              <div class="col-md-2 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Nạp thẻ</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                      <?php
                        // use Illuminate\Database\Capsule\Manager as DB;
                        $yesterday = Carbon::yesterday();
                        $weekStartDate = Carbon::now()->startOfWeek();
                        $weekEndDate = Carbon::now()->endOfWeek();
                        
                        $monthStartDate = Carbon::now()->startOfMonth();
                        $monthEndDate = Carbon::now()->endOfMonth();

                        $prevWeekStartDate = Carbon::now()->subWeek()->startOfWeek();
                        $prevWeekEndDate = Carbon::now()->subWeek()->endOfWeek();
                        // DB::enableQueryLog(); // Enable query log
                        
                        $paymentSumToday = PaymentLogs::whereBetween('time', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->sum('money');
                        $paymentCountToday = PaymentLogs::whereBetween('time', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->distinct('account')->count();

                        $pendingChargeSumToday = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->sum('money');
                        $pendingChargeCountToday = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->distinct('accid')->count();
                        

                        $paymentSumYesterday = PaymentLogs::whereBetween('time', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->sum('money');
                        $paymentCountYesterday = PaymentLogs::whereBetween('time', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->distinct('account')->count();
                        
                        $pendingChargeSumYesterday = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->sum('money');
                        $pendingChargeCountYesterday = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->distinct('accid')->count();
                        

                        $paymentSumWeek = PaymentLogs::whereBetween('time', [$weekStartDate, $weekEndDate])->sum('money');
                        $paymentCountWeek = PaymentLogs::whereBetween('time', [$weekStartDate, $weekEndDate])->distinct('account')->count();
                        
                        $pendingChargeSumWeek = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [$weekStartDate, $weekEndDate])->sum('money');
                        $pendingChargeCountWeek = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [$weekStartDate, $weekEndDate])->distinct('accid')->count();
                        
                        $paymentSumMonth = PaymentLogs::whereBetween('time', [$monthStartDate, $monthEndDate])->sum('money');
                        $paymentCountMonth = PaymentLogs::whereBetween('time', [$monthStartDate, $monthEndDate])->distinct('account')->count();
                        
                        $pendingChargeSumMonth = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [$monthStartDate, $monthEndDate])->sum('money');
                        $pendingChargeCountMonth = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [$monthStartDate, $monthEndDate])->distinct('accid')->count();
                      ?>
                        <h3 class="mb-2"><?php echo number_format($paymentSumToday + $pendingChargeSumToday, 2);?>$</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span><?php echo number_format($paymentCountToday + $pendingChargeCountToday);?> người nạp</span>
                            <!-- <i data-feather="arrow-up" class="icon-sm mb-1"></i> -->
                          </p>
                        </div>
                      </div>
                      <!-- <div class="col-6 col-md-12 col-xl-7">
                        <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Nạp hôm qua</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo number_format($paymentSumYesterday + $pendingChargeSumYesterday, 2);?>$</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span><?php echo number_format($paymentCountYesterday + $pendingChargeCountYesterday);?> người nạp</span>
                            <!-- <i data-feather="arrow-down" class="icon-sm mb-1"></i> -->
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
                        <!-- <div id="apexChart2" class="mt-md-3 mt-xl-0"></div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Online</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php
                      use Models\AccBase;
                      $column = [
                          'zoneid',
                          'count'
                      ];
                      $getOnline = AccBase::where('zoneid', '<>', 0)->count();
                      ?>
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo $getOnline;?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <!-- <span>+2.8%</span> -->
                            <!-- <i data-feather="arrow-up" class="icon-sm mb-1"></i> -->
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
                        <!-- <div id="apexChart3" class="mt-md-3 mt-xl-0"></div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Tổng nạp tuần</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo number_format($paymentSumWeek + $pendingChargeSumWeek, 2).'$';?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span><?php echo number_format($paymentCountWeek + $pendingChargeCountWeek);?> người nạp</span>
                            <!-- <i data-feather="arrow-up" class="icon-sm mb-1"></i> -->
                          </p>
                        </div>
                      </div>
                      <!--<div class="col-6 col-md-12 col-xl-7">-->
                      <!--  <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>-->
                      <!--</div>-->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Tổng nạp tháng</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo number_format($paymentSumMonth + $pendingChargeSumMonth, 2).'$';?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span><?php echo number_format($paymentCountMonth + $pendingChargeCountMonth);?> người nạp</span>
                            <!-- <i data-feather="arrow-up" class="icon-sm mb-1"></i> -->
                            <?php echo ($pendingChargeSumMonth).'$';?>
                            <?php echo ($paymentSumMonth).'$';?>
                          </p>
                        </div>
                      </div>
                      <!--<div class="col-6 col-md-12 col-xl-7">-->
                      <!--  <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>-->
                      <!--</div>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- row -->
        
        <div class="row">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Đăng nhập ngày</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                      <?php
                        $countLoginToday = AccountLogin::whereBetween('logindate', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->distinct('accid')->count();
                        $countLoginYesterday = AccountLogin::whereBetween('logindate', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->distinct('accid')->count();
                        $countLoginWeek = AccountLogin::whereBetween('logindate', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->distinct('accid')->count();
                        $countLoginMonth = AccountLogin::whereBetween('logindate', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->distinct('accid')->count();
                      ?>
                        <h3 class="mb-2"><?php echo number_format($countLoginToday);?></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Đăng nhập hôm qua</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo number_format($countLoginYesterday);?></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Đăng nhập tuần</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo number_format($countLoginWeek);?></h3>
                        <div class="d-flex align-items-baseline">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Đăng nhập tháng</h6>
                      <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2">
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><?php echo number_format($countLoginMonth); ?></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- row -->

        <div class="row">
          <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                  <h6 class="card-title mb-0">Thống kê</h6>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton3">
                      <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                      <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                      <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                      <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                      <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                    </div>
                  </div>
                </div>
                <div class="row align-items-start mb-2">
                  <div class="col-md-7">
                    <button type="button" class="btn btn-primary" id="paymentChart">
                      Nạp thẻ
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="registerChart">
                      Số lượng đăng ký
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="accountLoginChart">
                      Đăng nhập
                    </button>
                  </div>
                  <div class="col-md-5 d-flex justify-content-md-end">
                    <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                      <!-- <button type="button" class="btn btn-outline-primary">Ngày</button> -->
                      <!-- <button type="button" class="btn btn-outline-primary d-none d-md-block">Tuần</button> -->
                      <!-- <button type="button" class="btn btn-primary">Tháng</button> -->
                      <!-- <button type="button" class="btn btn-outline-primary">Năm</button> -->
                    </div>
                  </div>
                </div>
                <div class="flot-wrapper">
                  <!-- <div id="flotChart1" class="flot-chart"></div> -->
                  <div id="chartPaymentRegister"></div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- row -->
			</div>
      <script type="text/javascript">
      $(document).ready(function() {
        var chartPaymentRegister = {destroy: () => {}};
        function loadChartHome(type = 'payment') {
          // if(type !== 'payment') {
          //   $('#paymentChart').removeClass('btn-primary').addClass('btn-outline-primary');
          //   $('#registerChart').addClass('btn-primary').removeClass('btn-outline-primary');
          // } else {
          //   $('#registerChart').removeClass('btn-primary').addClass('btn-outline-primary');
          //   $('#paymentChart').addClass('btn-primary').removeClass('btn-outline-primary');
          // }

          var listDate = [];

          var date = new Date();
          var countDayOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
          for(var i = 1;i <= countDayOfMonth; i++) {
            // listDate.push(i);
            listDate.push(`Ngày ${i}`);
          }

          var dataChart = [];
          var urlPost = "";
          var dataName = "";
          $('#registerChart').removeClass('btn-primary').addClass('btn-outline-primary');
          $('#paymentChart').removeClass('btn-primary').addClass('btn-outline-primary');
          $('#accountLoginChart').removeClass('btn-primary').addClass('btn-outline-primary');
          
          switch(type) {
            case 'payment':
              urlPost = "<?php homePath()?>ajax/getpaymentchartdata.php";
              $('#paymentChart').addClass('btn-primary').removeClass('btn-outline-primary');
              dataName = "USD";
              break;
            case 'register':
              urlPost = "<?php homePath()?>ajax/getregisterchartdata.php";
              $('#registerChart').addClass('btn-primary').removeClass('btn-outline-primary');
              dataName = "Đăng ký";
              break;
            case 'accountlogin':
              urlPost = "<?php homePath()?>ajax/getaccountloginchartdata.php";
              $('#accountLoginChart').addClass('btn-primary').removeClass('btn-outline-primary');
              dataName = "Đăng nhập";
              break;
          }
          
          $.post(urlPost, (data) => {
            console.log(data);
            for(var i = 1;i <= countDayOfMonth; i++) {
              dataChart.push(parseFloat(data[i] && data[i].agg ? data[i].agg : 0).toFixed(2));
            }
            console.log(dataChart);
            if($('#chartPaymentRegister').length) {
              loadApexCharts(type, listDate, dataChart, dataName);
            }
          });
        }

        function loadApexCharts(type, listDate, dataSet, dataName){
          var options = {
          series: [{
            name:dataName,
            data: dataSet
          }],
            chart: {
            height: 350,
            type: 'line',
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: true
          },
          stroke: {
            curve: 'straight'
          },
          title: {
            text: `Thống kê ${dataName} theo tháng`,
            align: 'left'
          },
          grid: {
            borderColor: '#e7e7e7',
            row: {
              colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
              opacity: 0.5
            },
          },
          xaxis: {
            categories: listDate,
          }
          };
          chartPaymentRegister.destroy();
          chartPaymentRegister = new ApexCharts(document.querySelector("#chartPaymentRegister"), options);
          chartPaymentRegister.render();
      
        }

        loadChartHome();
        $('#paymentChart').click(() => loadChartHome('payment'));
        $('#registerChart').click(() => loadChartHome('register'));
        $('#accountLoginChart').click(() => loadChartHome('accountlogin'));
      });
      </script>