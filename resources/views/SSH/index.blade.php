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
                            <h2 class="content-header-title float-start mb-0">{{strtoupper($anujenissatuan)}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('satuan.index', ['satuan' => $anujenissatuan])}}">{{strtoupper($anujenissatuan)}}</a>
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
                                <div class="head-label"><h5 class="mt-1">Tabel Standar Satuan Harga</h5></div>
                                <div class="dt-action-buttons text-end">
                                    <a href="{{route('satuan.create', ['jenis_satuan' => $anujenissatuan])}}"
                                    class="btn btn-icon btn-success" id="tombol-tambah">
                                        <i data-feather='plus'></i>
                                    </a>
                                    <button type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addsatuan"
                                    class="btn btn-success" id="tombol-tambah">
                                        <i data-feather='upload'></i>
                                        Unggah Standar Harga
                                    </button>
                                </div>
                            </div>
                            <table class="user-list-table table" id="satuantable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Kelompok</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Item</th>
                                        <th>Spesifikasi</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Kode Rekening</th>
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
        const table = $('#satuantable').DataTable(
            {
                // serverSide : true,
                processing : true,
                language : {
                    processing : "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>Loading...</span></div>"
                },

                ajax : {
                    url: '{{ route('satuan.index', ['satuan' => $anujenissatuan]) }}',
                    type: 'GET'
                },

                columns : [
                    {data: 'DT_RowIndex'},
                    { "data": "id_kelompok" },
                    { "data": "kode" },
                    { "data": "nama_item" },
                    { "data": "spesifikasi" },
                    { "data": "satuan" },
                    { "data": "harga" },
                    { "data": "kode_rekening" },
                    {data: 'action'}
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
      id="addsatuan"
      tabindex="-1"
      aria-labelledby="addsatuanTitle"
      aria-hidden="true"
    >
      <div class="modal-sm modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addsatuanTitle">Tambah Standar Harga</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="import-satuan" action="{{route('import.satuan')}}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 mb-1 mb-sm-0">
                        <label for="formFile" class="form-label">Jenis</label>
                        <input class="form-control" type="input" readonly id="jenis_satuan" name="jenis_satuan" value="{{$anujenissatuan}}"/>
                      </div>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 mb-1 mb-sm-0">
                        <label for="formFile" class="form-label">Upload XLSX Standar Harga</label>
                        <input class="form-control" type="file" id="excel_file" name="excel_file" />
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

