<!DOCTYPE html>
<!--
Template Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
Author: PixInvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/vuexy_admin
Renew Support: https://1.envato.market/vuexy_admin
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Layout blank - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/bordered-layout.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            {{-- directory content --}}
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                </div>
            </div>
            @include('layout.component.toast')
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$kegiatan->nama_kegiatan}}
                            ({{$program->renstra->skpd->nama_skpd}})</h4>
                    </div>
                    <div class="card-body">
                        <form id="add-kegiatan" action="{{route('item_kegiatan.update', ['item_kegiatan' => $item_kegiatan->id])}}" method="POST" class="form form-horizontal">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <table class="table">
                                    <tbody>
                                        <tr style="padding: 10px 0">
                                            <td style="padding: 10px 0"><strong>Pada Program</strong></td>
                                            <td style="padding: 10px 0">:</td>
                                            <td>&nbsp;</td>
                                            <td style="padding: 10px 0">{{$kegiatan->program->nama_program}}</td>
                                        </tr>
                                        <tr style="padding: 10px 0">
                                            <td style="padding: 10px 0"><strong>Pada Kegiatan</strong></td>
                                            <td style="padding: 10px 0">:</td>
                                            <td>&nbsp;</td>
                                            <td style="padding: 10px 0">{{$kegiatan->nama_kegiatan}}</td>
                                        </tr>
                                        <tr style="padding: 10px 0">
                                            @php
                                            $kode = auth()->user()->skpd->kode;
                                            $kode_parts = explode('.', $kode);

                                            // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                                            $kode_spkd = implode('.', array_slice($kode_parts, 0, 2));
                                            @endphp
                                            <td style="padding: 10px 0"><strong>Kode Sub Kegiatan</strong></td>
                                            <td style="padding: 10px 0">:</td>
                                            <td>&nbsp;</td>
                                            <td style="padding: 10px 0">{{$kode_spkd}}.{{$program->kode}}.{{$kegiatan->kode}}</td>
                                        </tr>
                                        <tr style="padding: 10px 0">
                                            <td style="padding: 10px 0"><strong>Nama Sub Kegiatan</strong></td>
                                            <td style="padding: 10px 0">:</td>
                                            <td>&nbsp;</td>
                                            <td style="padding: 10px 0">{{$item_kegiatan->nama_sub}}</td>
                                        </tr>
                                        <tr style="padding: 10px 0">
                                            <td style="padding: 10px 0"><strong>Satuan</strong></td>
                                            <td style="padding: 10px 0">:</td>
                                            <td>&nbsp;</td>
                                            <td style="padding: 10px 0">{{$item_kegiatan->satuan}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            {{-- <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                            <label class="col-form-label" for="program-id">Output</label>
                                            </div>
                                            <div class="col-sm-9">
                                            <textarea name="output" class="form-control" cols="30" rows="10" placeholder="Output"></textarea>
                                            </div>
                                        </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="program-id">Komponen Penyusun</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div id="itemkegiatan" class="table-responsive">
                                                <table id="itemkeg" class="table table-bordered" border="1">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Rek.</th>
                                                            <th>Tipe Komponen</th>
                                                            <th>Nama Komponen</th>
                                                            <th>Satuan</th>
                                                            <th>Harga</th>
                                                            <th>Vol.</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($item_kegiatan->komponens)
                                                            @foreach ($item_kegiatan->komponens as $i => $komponen)
                                                                <tr class="draggable-row">
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><p type="text" class="form-control-static form-control-sm" name="{{$i}}_sub_item_kegiatan" placeholder="Nama Sub" readonly>{{$komponen->satuan->kode_rekening}}</p><input type="hidden" name="{{$i}}_id_item" value="{{$komponen->id_satuan}}"></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><p type="text" class="form-control-static form-control-sm" name="{{$i}}_tipe_item_kegiatan" placeholder="Nama Tipe" readonly>{{$komponen->satuan->kelompok->uraian}}</p></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><p type="text" class="form-control-static form-control-sm" name="{{$i}}_nama_item_kegiatan" placeholder="Nama Item" readonly>{{$komponen->satuan->nama_item}}</p></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><p type="text" class="form-control-static form-control-sm" name="{{$i}}_satuan_item_kegiatan" placeholder="Ex. Kg/Lbr" readonly value="">{{$komponen->satuan->satuan}}</p></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><p type="number" id="harga-input-{{$i}}" class="harga-input form-control-static form-control-sm" readonly>{{number_format(($komponen->satuan->harga),0,',','.')}}</p></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><p type="number" id="volume-input-{{$i}}" class="volume-input form-control-static form-control-sm">{{$komponen->volume}}</p></td>
                                                                    <td style="font-size: .999rem">Rp.<span id="total-row-{{$i}}">{{number_format(($komponen->satuan->harga * $komponen->volume),0,',','.')}}</span></td>
                                                                </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="6">Total Per Sub Kegiatan</th>
                                                            <th>Rp.<span id="grand-total">{{number_format($item_kegiatan->pagu_anggaran,0,',','.')}}</span></th>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th colspan="6">Total * Volume Sub Kegiatan</th>
                                                            <th>Rp.<span id="volume-total"></span></th>
                                                        </tr> --}}
                                                        <tr>
                                                            <th colspan="6">Sisa Pagu Anggaran Kegiatan</th>
                                                            <th>Rp.<span id="sisa-pagu">{{number_format(($item_kegiatan->pagu_indikatif - $item_kegiatan->pagu_anggaran),0,',','.')}}</span></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End: Customizer-->
</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
<p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2023<a
            class="ms-25" href="https://segeraberkinerja.com" target="_blank">Pemerintah Kabupaten Kolaka Utara</a><span
            class="d-none d-sm-inline-block">, All rights Reserved.</span></span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
</body>
<!-- END: Body-->

</html>