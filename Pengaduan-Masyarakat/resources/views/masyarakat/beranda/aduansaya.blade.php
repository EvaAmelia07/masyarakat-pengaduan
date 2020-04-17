@extends('layouts.masterAdmin.master')
@section('title','Masyarakat')
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
              <li class="breadcrumb-item"><a href="#" style="color:black;">Halaman Masyarakat</a></li>
            
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
      <div class="row">
                <div class="col-md-12">
                @foreach($u_pengaduan as $aduan)
                    <div class="card">
                        <div class="card-header">
                            <span class="username">
                                <a href="#" style="color:#ff3300;"><b>
                                @if(Auth::user()->hasAnyRole('masyarakat'))
                                {{ $aduan->users->name }}
                                @endif
                                </b></a>
                            </span>
                            <br>
                            <span class="description" style="font-size:10pt;">
                            Dipublikasikan pada, {{ $aduan->tanggal_aduan }}
                            </span>
                        </div>
                        <div class="card-body">
                        <div class="post">
                            <!-- /.user-block -->
                          <h4 class="text-dark">{{ $aduan->judul_aduan }}</h4>
                            <p class="text-justify">
                              {{ str_limit($aduan->isi_aduan, 310, '') }}
                              @if(strlen($aduan->isi_aduan) > 310)
                                <span id="dots">...... <a href="{{route('masyarakat.beranda.detailaduan', $aduan->id)}}" class="text-info">Baca Selengkapnya</a></span>
                              @endif
                            </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
      </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection
