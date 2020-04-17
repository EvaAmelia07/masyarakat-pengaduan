@extends('layouts.masterAdmin.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Halaman Admin</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container- -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-light">
              <div class="card-header"style="background-color:#ff3300; color:white;">
                <h3 class="card-title">Cetak Laporan</h3>
                <br>
                <p>Silahkan pilih tanggal</p>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('admin.cetak.aduan') }}">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="tanggal">Tanggal Awal</label>
                    <input type="date" class="form-control" name="tanggal_awal" id="tanggal">
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="tanggal_akhir" id="tanggal">
                  </div>
                 
                <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-dark">tambahkan</button>
                    </div>
                    </div>
            </form>
                </div>
            <!-- /.card -->

          </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection
