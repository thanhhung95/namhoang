@extends('Layouts.app')

@section('title', 'Thông tin nhân sự - ICTU')
@section('pagetitle', 'THÔNG TIN NHÂN SỰ')

@section('content')



    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Trình độ cán bộ</h5>
                </div>
                <div class="ibox-content" style="padding-top: 1px">
                    <ul class="list-group clear-list m-t" style="margin: 0px;">
                        <li class="list-group-item fist-item">
                            <span class="pull-right">
                                
                            </span>
                            <span class="label label-success">1</span> Tiến sĩ, GS, PGS
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                               
                            </span>
                            <span class="label label-info">2</span> Thạc sĩ
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                               
                            </span>
                            <span class="label label-primary">3</span> Đại học
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                               
                            </span>
                            <span class="label label-default">4</span> Cao đẳng
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                                
                            </span>
                            <span class="label label-primary">5</span> Trình độ khác
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            
                            <h5>Tỷ lệ CBPB / GV</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins" style="text-align: center;"></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Tỷ lệ Nam / Nữ</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins" style="text-align: center;"></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Số kiêm nhiệm</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins" style="text-align: center;"></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Số lãnh đạo / Nhân viên</h5>
                        </div>
                        <div class="ibox-content" style="text-align: center;">
                            <h1 class="no-margins"></h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Số đang học tại nước ngoài</h5>
                        </div>
                        <div class="ibox-content" style="text-align: center;">
                            <h1 class="no-margins"></h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Số đang học trong nước</h5>
                        </div>
                        <div class="ibox-content" style="text-align: center;">
                            <h1 class="no-margins"></h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Đang nghỉ thai sản</h5>
                        </div>
                        <div class="ibox-content" style="text-align: center;">
                            <h1 class="no-margins"></h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4  col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Đang nghỉ chế độ khác</h5>
                        </div>
                        <div class="ibox-content" style="text-align: center;">
                            <h1 class="no-margins"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <ul class="stat-list">
                        <li>
                            <h2 class="no-margins"></h2>
                            <small>Cán bộ có độ tuổi trên 45</small>
                            <div class="stat-percent"></div>
                            <div class="progress progress-mini">
                                <div style="width:10" class="progress-bar"></div>
                            </div>
                        </li>
                        <li>
                            <h2 class="no-margins "></h2>
                            <small>Cán bộ có độ tuổi từ 30 - 45</small>
                            <div class="stat-percent"></div>
                            <div class="progress progress-mini">
                                <div style="width:10" class="progress-bar"></div>
                            </div>
                        </li>
                        <li>
                            <h2 class="no-margins "></h2>
                            <small>Cán bộ có độ tuổi dưới 30</small>
                            <div class="stat-percent"></div>
                            <div class="progress progress-mini">
                                <div style="width: 10" class="progress-bar"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Tình trạng hết hợp đồng</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <small class="stats-label">Còn từ 3 đến 6 tháng</small> <h4></h4>
                                </div>

                                <div class="col-xs-4">
                                    <small class="stats-label">Còn từ 1 đến 3 tháng</small>
                                    <h4></h4>
                                </div>
                                <div class="col-xs-4">
                                    <small class="stats-label">Còn it hơn một tháng</small>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-4 red">
                                    <small class="stats-label">Quá hạn 1 tháng</small>
                                    <h4></h4>
                                </div>

                                <div class="col-xs-4 red">
                                    <small class="stats-label ">Quá hạn 2 tháng</small>
                                    <h4></h4>
                                </div>
                                <div class="col-xs-4 red">
                                    <small class="stats-label">Quá hạn 3 tháng</small>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            
                            <h5>Học tập, bồi dưỡng quá hạn</h5>
                        </div>
                        <div class="ibox-content" style="padding-top: 1px; padding-bottom: 14px;">
                            <ul class="list-group clear-list m-t" style="margin: 0px;">
                                <li class="list-group-item fist-item">
                                    <span class="pull-right">
                                       
                                    </span>
                                    <span class="label label-success">1</span> NCS trong nước
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                    </span>
                                    <span class="label label-info">2</span> NCS nước ngoài
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                    </span>
                                    <span class="label label-primary">3</span> Thạc sĩ
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                    </span>
                                    <span class="label label-default">4</span> Khác
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            
                            <h5>Đến tuổi nghỉ hưu</h5>
                        </div>
                        <div class="ibox-content" style="padding-top: 1px; padding-bottom: 14px;">
                            <ul class="list-group clear-list m-t" style="margin: 0px;">
                                <li class="list-group-item fist-item">
                                    <span class="pull-right">
                                    </span>
                                    <span class="label label-success">1</span> Dưới 1 tháng
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                    </span>
                                    <span class="label label-info">2</span> Dưới 3 tháng
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                    <span class="label label-primary">3</span> Dưới 1 năm
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                    </span>
                                    <span class="label label-default">4</span> Dưới 5 năm
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Báo cáo tình hình nhân sự cho ĐHTN</h5>
                    <h2>65 ngày</h2>
                    <div class="progress progress-mini">
                        <div style="width: 65%;" class="progress-bar"></div>
                    </div>

                    <div class="m-t-sm small">Hạn nộp báo cáo là 00/00/2017</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Hạn kê khai học tập bồi dưỡng hàng năm</h5>
                    <h2>15 ngày</h2>
                    <div class="progress progress-mini">
                        <div style="width: 50%;" class="progress-bar"></div>
                    </div>

                    <div class="m-t-sm small">Hạn cuối chốt đăng ký 00/00/2017</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Kê khai nghiên cứu khoa học</h5>
                    <h2>4 ngày</h2>
                    <div class="progress progress-mini">
                        <div style="width: 8%;" class="progress-bar progress-bar-danger"></div>
                    </div>

                    <div class="m-t-sm small">Hạn cuối chốt kê khai NCKH 00/00/2017 </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Chốt vi phạm kỷ luật trong tháng</h5>
                    <h2>2</h2>
                    <div class="progress progress-mini">
                        <div style="width: 2%;" class="progress-bar progress-bar-danger"></div>
                    </div>

                    <div class="m-t-sm small">Hạn chốt bản vi phạm: 00/00/2017</div>
                </div>
            </div>
        </div>
    </div> 
@endsection