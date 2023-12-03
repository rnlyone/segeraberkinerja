@include('layout.header')
@include('layout.component.toast')
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
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Tambah Kegiatan</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.index')}}">Program</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('kegiatan.create')}}">Tambah Kegiatan</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layout.component.toast')
            <div class="col-md-12 col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Tambahkan Kegiatan ({{auth()->user()->skpd->nama_skpd}})</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{route('kegiatan.store')}}" method="POST" class="form form-horizontal">
                        @csrf
                      <div class="row">
                        {{-- <div class="col-12">
                          <div class="mb-1 row">
                            <div class="col-sm-3">
                              <label class="col-form-label" for="pilih-periode">Tahun</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2" id="pilih-periode" name="periode" required>
                                    <option value="">Pilih Periode</option>
                                    @php
                                    $currentYear = $renstra->periode;
                                        @endphp
                                        @for ($i=$currentYear;$i<=$currentYear+5; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                            </div>
                          </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="mb-1 row">
                              <div class="col-sm-3">
                                <label class="col-form-label" for="kegiatan-id">Pada Program</label>
                              </div>
                              <div class="col-sm-9">
                                <input type="text" id="kegiatan-id" class="form-control" disabled value="{{$program->nama_program}}">
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="mb-1 row">
                              <div class="col-sm-3">
                                <label class="col-form-label" for="kegiatan-id">Tahun</label>
                              </div>
                              <div class="col-sm-9">
                                <input type="text" id="kegiatan-id" name="tahun" class="form-control" readonly value="{{$tahun}}">
                              </div>
                            </div>
                          </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                              <div class="col-sm-3">
                                <label class="col-form-label" for="kode-id">Kode Kegiatan</label>
                              </div>
                              <div class="col-sm-2">
                                @php
                                    $kode = auth()->user()->skpd->kode;
                                    $kode_parts = explode('.', $kode);

                                    // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                                    $result = implode('.', array_slice($kode_parts, 0, 2));
                                @endphp
                                <input type="text" id="kode-opd" class="form-control" value="{{$result}}.{{$program->kode}}." placeholder="Kode Kegiatan" disabled>
                              </div>
                              <div class="col-sm-7">
                                <input name="id_program" value="{{$program->id}}" hidden>
                                <input type="text" id="kode-id" class="form-control" name="kode" placeholder="Kode Kegiatan">
                              </div>
                            </div>
                        </div>
                        <div class="col-12">
                          <div class="mb-1 row">
                            <div class="col-sm-3">
                              <label class="col-form-label" for="kegiatan-id">Nama Kegiatan</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" id="kegiatan-id" class="form-control" name="nama_kegiatan" placeholder="Nama Kegiatan">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-9 offset-sm-3">
                          <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                          <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


        </div>
    </div>
</div>
@include('layout.footer')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
{{-- <script src="/app-assets/js/scripts/forms/form-quill-editor.min.js"></script> --}}
<!-- END: Page JS-->





