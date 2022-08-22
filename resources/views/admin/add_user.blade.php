@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Khách Hàng
                </header>
                <?php
                    use Illuminate\Support\Facades\Session;
                    $message=Session::get('message');
                    if($message){
                    echo '<span style="color:red; align-item: center;">',$message,'</span>';
                    Session::put('message',null);
                    }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-user')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Khách Hàng</label>
                                <input type="text" name="user_name" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa Chỉ Khách Hàng</label>
                                <input type="text" name="user_address" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số Điện Thoại</label>
                                <input type="text" name="user_phone" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" name="user_email" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" name="user_password" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <!-- <div class="form-group">
                                <label for="exampleInputFile">Trạng Thái</label>
                                <select name="user_status" class="form-control input-sm m-bot15">
                                    <option value="0">Khóa</option>
                                    <option value="1">Kích Hoạt</option>
                                </select>
                            </div>                                -->
                            <button type="submit" name="add_user" class="btn btn-info">Thêm Khách Hàng</button>
                        </form>
                    </div>
                </div>
            </section>
    </div>
</div>

@endsection