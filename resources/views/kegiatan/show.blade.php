@include('layout.header')
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
                            <h2 class="content-header-title float-start mb-0">SUB Kegiatan dari </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.index')}}">Program</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.show', ['program' => $program->id])}}">{{$program->nama_program}}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('kegiatan.show', ['kegiatan' => $kegiatan->id])}}">{{$kegiatan->nama_kegiatan}}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics Start -->
            <section class="app-user-list">
                <!-- list section start -->
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <div class="alert-body">
                        {{$error}}
                    </div>
                  </div>
                @endforeach
                @endif
                    <div class="card">
                        <div style="margin: 10pt">
                            <div class="card-datatable table-responsive pt-0">
                                <div class="card-header p-0">
                                    <div class="head-label"><h5 class="mt-1">SUB Kegiatan dari Kegiatan {{$kegiatan->nama_kegiatan}} ({{$program->renstra->skpd->nama_skpd}})</h5></div>
                                    <div class="dt-action-buttons text-end">
                                        <button type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addsub"
                                        class="delete btn btn-icon btn-success"
                                        data-id="'.$data->id.'" class="btn btn-success" id="tombol-tambah">
                                            <i data-feather='plus'></i>
                                        </button>
                                    </div>
                                </div>
                                <table class="user-list-table table" id="programtable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            {{-- <th>Kode</th> --}}
                                            <th>Kode</th>
                                            <th>Nama Sub Kegiatan</th>
                                            <th>Pagu Anggaran</th>
                                            <th>Pagu Indikatif</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                <!-- list section end -->
            </section>
            @include('layout.component.toast')

        </div>
    </div>
</div>

@include('layout.footer')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{asset('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-number-input.min.js')}}"></script>
<script>
    $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });


        $(document).ready(function(){
        const table = $('#programtable').DataTable(
            {
                serverSide : true,
                processing : true,
                language : {
                    processing : "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>Loading...</span></div>"
                },

                ajax : {
                    @if (request()->routeIs('kegiatan.show'))
                        url: '{{ route('kegiatan.show', ['kegiatan' => $kegiatan->id]) }}',
                    @elseif (request()->routeIs('skpd.show'))
                        url: "{{ route('skpd.show', ['skpd' => $renstra->skpd->id]) }}",
                    @endif

                    type: 'GET'
                },

                columns : [
                    { "data": null, "defaultContent": "", "orderable": false },
                    { "data": "kode" },
                    { "data": "nama_sub" },
                    { "data": "pagu_anggaran" },
                    { "data": "pagu_indikatif" },
                    {data: 'action'}
                ],
                "columnDefs" : [
                    {
                        "targets": 0,
                        "data": null,
                        "render": function (data, type, row, meta) {
                            return meta.row + 1; // Untuk menghasilkan nomor urutan
                        }
                    }
                ],

                order: [[0, 'asc']],
                "drawCallback" : function( settings ) {
                    feather.replace();
                }
            })
        });
</script>


<div class="scrolling-inside-modal">
    <!-- Modal -->
    <div
      class="modal fade"
      id="addsub"
      tabindex="-1"
      aria-labelledby="addsubTitle"
      aria-hidden="true"
    >
      <div class="modal-lg modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addsubTitle">Sub Kegiatan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="update-program" action="{{route('item_kegiatan.store')}}" method="POST" class="form form-horizontal">
                @csrf
                <div class="modal-body">
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
                            <input type="text" id="tahun-kegiatan" class="form-control" value="{{$kegiatan->tahun}}" readonly>
                          </div>
                        </div>
                      </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                            <label class="col-form-label" for="program-input">Nama Kegiatan</label>
                            </div>
                            <div class="col-sm-9">
                            <input type="text" id="id-input" name="id_kegiatan" class="form-control" placeholder="Nama Kegiatan" value="{{$kegiatan->id}}" hidden>
                            <input type="text" id="kegiatan-input" class="form-control" placeholder="Nama Kegiatan" value="{{$kegiatan->nama_kegiatan}}" readonly>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1 row">
                          <div class="col-sm-3">
                            <label class="col-form-label" for="kode-id">Kode Kegiatan</label>
                          </div>
                          <div class="col-sm-4">
                            @php
                                $kode = auth()->user()->skpd->kode;
                                $kode_parts = explode('.', $kode);

                                // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                                $kode_spkd = implode('.', array_slice($kode_parts, 0, 2));
                            @endphp
                            <input type="text" id="kode-opd" class="form-control" value="{{$kode_spkd}}.{{$program->kode}}.{{$kegiatan->kode}}." placeholder="Kode Kegiatan" disabled>
                          </div>
                          <div class="col-sm-5">
                            <input type="text" id="kode-id" class="form-control" name="kode" placeholder="Kode Sub Kegiatan">
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                            <label class="col-form-label" for="program-input">Nama Sub Kegiatan</label>
                            </div>
                            <div class="col-sm-9">
                            <input type="text" id="item-input" class="form-control" name="nama_sub" placeholder="Nama Kegiatan">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                            <label class="col-form-label" for="program-input">Satuan</label>
                            </div>
                            <div class="col-sm-3">
                            <input type="text" name="satuan" class="form-control" placeholder="Satuan">
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
