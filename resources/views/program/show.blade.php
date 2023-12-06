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
                            <h2 class="content-header-title float-start mb-0">Kegiatan Program</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.index')}}">Program</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.show', ['program' => $program->id])}}">{{$program->nama_program}}</a>
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

                @for ($i = $program->renstra->periode; $i <= $program->renstra->periode+5; $i++)
                    <div class="card">
                        <div style="margin: 10pt">
                            <div class="card-datatable table-responsive pt-0">
                                <div class="card-header p-0">
                                    <div class="head-label"><h5 class="mt-1">Kegiatan dari Program {{$program->nama_program}} Tahun {{$i}} ({{$program->renstra->skpd->nama_skpd}})</h5></div>
                                    @if (!request()->routeIs('penganggaran.program.show'))
                                    <div class="dt-action-buttons text-end">
                                        <a href="{{route('kegiatan.create', ['tahun' => $i, 'program' => $program->id])}}" class="btn btn-success" id="tombol-tambah">
                                            <i data-feather='plus'></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                <table class="user-list-table table" id="programtable-{{$i}}">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode</th>
                                            <th>Kegiatan</th>
                                            <th>Pagu Anggaran</th>
                                            <th>Pagu Indikatif</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                @endfor
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
        for (let i = {{$program->renstra->periode}}; i <= {{$program->renstra->periode+5}}; i++) {
            const table = $('#programtable-'+i).DataTable(
            {
                serverSide : true,
                processing : true,
                language : {
                    processing : "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>Loading...</span></div>"
                },

                ajax : {
                    @if (request()->routeIs('penganggaran.program.show'))
                        url: "{{ route('penganggaran.program.get.tahun', ['program' => $program->id, 'tahun' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', i),
                    @else
                        url: "{{ route('program.get.tahun', ['program' => $program->id, 'tahun' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', i),
                    @endif
                    type: 'GET'
                },

                columns : [
                    {data: 'DT_RowIndex'},
                    { "data": "kode" },
                    { "data": "nama_kegiatan" },
                    { "data": "pagu_anggaran" },
                    { "data": "pagu_indikatif" },
                    {data: 'action'}
                ],


                order: [[0, 'asc']],
                "drawCallback" : function( settings ) {
                    feather.replace();
                }
            })
        }
        });

        @if (request()->routeIs('penganggaran.program.show'))
            $('body').on('click', '.btn-edit-kegiatan', function () {
                let post_id = $(this).data('id');

                //fetch detail post with ajax
                $.ajax({
                    url: `{{ route('penganggaran.program.get.data', ['kegiatan' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', post_id),
                    type: "GET",
                    cache: false,
                    success:function(response){
                        //fill data to form
                        $('#update-kegiatan').attr('action', '/kegiatan/PLACEHOLDER/updatepagu'.replace('PLACEHOLDER', post_id));
                        $('#id-input').val(response.data.id);
                        $('#kegiatan-input').val(response.data.nama_kegiatan);
                        $('#tahun-kegiatan').val(response.data.tahun);
                        $('#kode-id').val(response.data.kode);
                        $('#pagu-input').val(response.data.pagu_indikatif);

                        // Clear the table before appending new rows
                        $('#subkegiatantable tbody').empty();

                        @php
                            $kode = $program->renstra->skpd->kode;
                            $kode_parts = explode('.', $kode);

                            // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                            $result = implode('.', array_slice($kode_parts, 0, 2));

                            $kode_sub =  $result;
                        @endphp

                        // Iterate over items and append rows to the table
                        $.each(response.items, function(index, item) {
                            $('#subkegiatantable tbody').append(`
                                <tr>
                                    <td>{{$kode_sub}}{{$program->renstra->kode}}.{{$program->kode}}.${response.data.kode}.${item.kode} <input type="text" hidden name="id" value="${item.id}"></td>
                                    <td>${item.nama_sub}</td>
                                    <td><input type="number" class="form-control" name="${item.id}_pagu_indikatif" value="${item.pagu_indikatif}"></td>
                                </tr>
                            `);
                        });

                        //open modal
                        $('#detailprogram').modal('show');
                    }
                });
            });
        @endif
</script>


@if (request()->routeIs('penganggaran.program.show'))
<div class="scrolling-inside-modal">
    <!-- Modal -->
    <div
      class="modal fade"
      id="detailprogram"
      tabindex="-1"
      aria-labelledby="detailprogramTitle"
      aria-hidden="true"
    >
      <div class="modal-lg modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailprogramTitle">Detail Kegiatan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="update-kegiatan" action="" method="POST" class="form form-horizontal">
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
                            <input type="text" id="tahun-kegiatan" name="tahun" class="form-control" readonly>
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
                                $kode = $program->renstra->skpd->kode;
                                $kode_parts = explode('.', $kode);

                                // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                                $result = implode('.', array_slice($kode_parts, 0, 2));

                                $kode_sub =  $result;
                            @endphp
                            <input type="text" id="kode-opd" class="form-control" value="{{$kode_sub}}.{{$program->kode}}." placeholder="Kode Kegiatan" disabled>
                          </div>
                          <div class="col-sm-5">
                            <input name="id_program" value="{{$program->id}}" hidden>
                            <input type="text" id="kode-id" class="form-control" name="kode" placeholder="Kode Kegiatan" readonly>
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
                            <input type="text" id="id-input" name="id" class="form-control" placeholder="Nama Kegiatan" hidden>
                            <input type="text" id="kegiatan-input" class="form-control" placeholder="Nama Kegiatan" disabled>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                            <label class="col-form-label" for="program-input">Sub Kegiatan</label>
                            </div>
                            <div class="col-sm-12">
                                <table class="user-list-table table" id="subkegiatantable">
                                    <thead class="table-light">
                                        <tr>
                                            {{-- <th>Kode</th> --}}
                                            <th>Kode</th>
                                            <th>Nama Sub Kegiatan</th>
                                            <th>Pagu Indikatif</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@endif
