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
                            <h2 class="content-header-title float-start mb-0">Program ({{$renstra->periode}}-{{$renstra->periode+5}})</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.index')}}">Program</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('renstra.show', ['renstra' => $renstra->id])}}">{{$renstra->periode}}-{{$renstra->periode+5}}</a>
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
                                <div class="head-label"><h5 class="mt-1">Tabel Program dari Renstra {{$renstra->periode}}-{{$renstra->periode+5}} ({{$renstra->skpd->nama_skpd}})</h5></div>
                                @if (request()->routeIs('renstra.show'))
                                <div class="dt-action-buttons text-end">
                                    <a href="{{route('program.create')}}" class="btn btn-success" id="tombol-tambah">
                                        <i data-feather='plus'></i>
                                    </a>
                                </div>
                            @endif
                            </div>
                            <table class="user-list-table table" id="programtable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        {{-- <th>Kode</th> --}}
                                        <th>Kode</th>
                                        <th>Nama Program</th>
                                        <th>Jenis</th>
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
                    @if (request()->routeIs('renstra.show'))
                        url: '{{ route('renstra.show', ['renstra' => $renstra->id]) }}',
                    @elseif (request()->routeIs('skpd.show'))
                        url: '{{ route('skpd.show', ['skpd' => $renstra->skpd->id]) }}',
                    @endif

                    type: 'GET'
                },

                columns : [
                    {data: 'DT_RowIndex'},
                    { "data": "kode" },
                    { "data": "nama_program" },
                    { "data": "jenis_program" },
                    { "data": "pagu_anggaran" },
                    { "data": "pagu_indikatif" },
                    {data: 'action'}
                ],


                order: [[0, 'asc']],
                "drawCallback" : function( settings ) {
                    feather.replace();
                }
            })
        });


</script>



