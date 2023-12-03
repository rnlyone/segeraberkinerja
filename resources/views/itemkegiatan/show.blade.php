<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/select/select2.min.css">
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
                            <h2 class="content-header-title float-start mb-0">Edit Sub Kegiatan</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('program.index')}}">Program</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{route('program.show', ['program' => $program->id])}}">Kegiatan</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('kegiatan.create')}}">Tambah
                                            Sub Kegiatan</a>
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
                        <h4 class="card-title">Edit Sub Kegiatan untuk Kegiatan {{$kegiatan->nama_kegiatan}}
                            ({{$program->renstra->skpd->nama_skpd}})</h4>
                    </div>
                    <div class="card-body">
                        <form id="add-kegiatan" action="{{route('item_kegiatan.update', ['item_kegiatan' => $item_kegiatan->id])}}" method="POST" class="form form-horizontal">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                      <div class="col-sm-3">
                                        <label class="col-form-label" for="program-id">Pada Program</label>
                                      </div>
                                      <div class="col-sm-9">
                                        <input type="text" id="program-id" class="form-control" disabled value="{{$kegiatan->program->nama_program}}">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="mb-1 row">
                                      <div class="col-sm-3">
                                        <label class="col-form-label" for="kegiatan-id">Pada Kegiatan</label>
                                      </div>
                                      <div class="col-sm-9">
                                        <input type="text" id="kegiatan-id" class="form-control" disabled value="{{$kegiatan->nama_kegiatan}}">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="mb-1 row">
                                      <div class="col-sm-3">
                                        <label class="col-form-label" for="kode-id">Kode Sub Kegiatan</label>
                                      </div>
                                      <div class="col-sm-2">
                                        @php
                                            $kode = auth()->user()->skpd->kode;
                                            $kode_parts = explode('.', $kode);

                                            // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                                            $kode_spkd = implode('.', array_slice($kode_parts, 0, 2));
                                        @endphp
                                        <input type="text" id="kode-opd" class="form-control" value="{{$kode_spkd}}.{{$program->kode}}.{{$kegiatan->kode}}" placeholder="Kode Kegiatan" disabled>
                                      </div>
                                      <div class="col-sm-7">
                                        <input name="id_kegiatan" value="{{$kegiatan->id}}" hidden>
                                        <input type="text" id="kode-id" class="form-control" name="kode" placeholder="Kode Sub Kegiatan" value="{{$item_kegiatan->kode}}" readonly>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="program-id">Nama Sub Kegiatan</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="program-id" class="form-control" name="nama_kegiatan"
                                                placeholder="Nama Sub Kegiatan" value="{{$item_kegiatan->nama_sub}}" readonly>
                                        </div>
                                    </div>
                                </div>
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
                                            <label class="col-form-label" for="program-id">Satuan</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="satuan"
                                                placeholder="Contoh : Cm, M, Kg2" value="{{$item_kegiatan->satuan}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="program-id">Komponen Penyusun</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div id="itemkegiatan" class="table-responsive">
                                                <table id="itemkeg" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="8"></th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="8"></th>
                                                        </tr>
                                                        <tr>
                                                            <th>No. Rek.</th>
                                                            <th>Tipe Komponen</th>
                                                            <th>Nama Komponen</th>
                                                            <th>Satuan</th>
                                                            <th>Harga</th>
                                                            <th>Vol.</th>
                                                            <th>Total</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($item_kegiatan->komponens)
                                                            @foreach ($item_kegiatan->komponens as $i => $komponen)
                                                                <tr class="draggable-row">
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="{{$i}}_sub_item_kegiatan" placeholder="Nama Sub" readonly>{{$komponen->satuan->kode_rekening}}</textarea><input type="hidden" name="{{$i}}_id_item" value="{{$komponen->id_satuan}}"></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="{{$i}}_tipe_item_kegiatan" placeholder="Nama Tipe" readonly>{{$komponen->satuan->kelompok->uraian}}</textarea></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="{{$i}}_nama_item_kegiatan" placeholder="Nama Item" readonly>{{$komponen->satuan->nama_item}}</textarea></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input type="text" class="form-control form-control-sm" name="{{$i}}_satuan_item_kegiatan" placeholder="Ex. Kg/Lbr" readonly value="{{$komponen->satuan->satuan}}"></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input style="width: 100px;" type="number" id="harga-input-{{$i}}" class="harga-input form-control form-control-sm" name="{{$i}}_harga_item_kegiatan" placeholder="" value="{{$komponen->satuan->harga}}" oninput="updateTotal({{$i}}); updateGrandTotal();" readonly></td>
                                                                    <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input style="width: 100px;" type="number" id="volume-input-{{$i}}" class="volume-input form-control form-control-sm" name="{{$i}}_volume_item_kegiatan" placeholder="" oninput="updateTotal({{$i}}); updateGrandTotal();" value="{{$komponen->volume}}"></td>
                                                                    <td style="font-size: .999rem">Rp.<span id="total-row-{{$i}}">{{number_format(($komponen->satuan->harga * $komponen->volume),0,',','.')}}</span></td>
                                                                    <td><a class="delete btn btn-icon btn-danger deleteRowBtn">x</a></td>
                                                                </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="6">Total Per Sub Kegiatan</th>
                                                            <th>Rp.<span id="grand-total">{{number_format($item_kegiatan->pagu_anggaran,0,',','.')}}</span></th>
                                                            <th></th>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th colspan="6">Total * Volume Sub Kegiatan</th>
                                                            <th>Rp.<span id="volume-total"></span></th>
                                                            <th></th>
                                                        </tr> --}}
                                                        <tr>
                                                            <th colspan="6">Sisa Pagu Anggaran Kegiatan</th>
                                                            <th>Rp.<span id="sisa-pagu">{{number_format(($item_kegiatan->pagu_indikatif - $item_kegiatan->pagu_anggaran),0,',','.')}}</span></th>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="8"></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">Tipe</th>
                                                            <th colspan="2">Nama</th>
                                                            <th colspan="1">Harga</th>
                                                            <th colspan="1">Volume</th>
                                                            <th colspan="1">Total</th>
                                                            <th colspan="2"></th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                <select class="select2 form-select" id="select-tipe" onchange="updateTipeSearch(this)" style="width: 150px;">
                                                                    <option value="">Pilih Tipe</option>
                                                                    @foreach ($kelompoks as $kelompok)
                                                                        <option value="{{$kelompok->id}}" data-id="{{$kelompok->id}}">{{$kelompok->uraian}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th colspan="2">
                                                                <select class="select2 form-select" id="select-satuan" onchange="updateSearch(this)" style="width: 150px;">
                                                                    <option value="">Pilih Komponen</option>
                                                                </select>
                                                            </th>
                                                            <th>Rp.<span id="harga-input"></span></th>
                                                            <th style="padding-right: 0.3rem; padding-left: 0.3rem;"><input type="number" id="volume-input" class="form-control" name="volume" oninput="updateTotalSearch();";
                                                                placeholder="Contoh : Cm, M, Kg2" value="1"></th>
                                                            <th>Rp.<span id="total-search"></span></th>
                                                            <th><a id="addRowBtn" class="btn-sm btn-icon btn-success waves-effect">+</a></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <button id="kegiatan-submit"
                                        class="btn btn-primary me-1 waves-effect waves-float waves-light justify-content-end">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DANGER --}}
<div class="modal fade modal-danger text-start" id="insufficient" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel120">Melewati Batas</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      Maaf, Pagu Indikatif telah terlewati, tidak dapat menyimpan.
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
    </div>
  </div>
</div>
</div>

@include('layout.footer')
<script src="/app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
<script src="/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
<script src="/app-assets/js/scripts/forms/form-input-mask.min.js"></script>
<script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="/app-assets/js/scripts/forms/form-select2.min.js"></script>

<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
{{-- <script src="/app-assets/js/scripts/forms/form-quill-editor.min.js"></script> --}}
<!-- END: Page JS-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>

    let komponen;
    let totaltotal;

    function updateTotal(counter) {
            const harga = parseFloat($(`#harga-input-${counter}`).val()) || 0;
            const volume = parseFloat($(`#volume-input-${counter}`).val()) || 0;
            const total = harga * volume;
            $(`#total-row-${counter}`).text(total.toLocaleString('id-ID'));
        }

    function updateTipeSearch(selectElement) {
        var selectedId = selectElement.value;

        // Ambil elemen select untuk satuan
        var satuanSelect = document.getElementById('select-satuan');

        // Hapus semua opsi kecuali yang pertama (placeholder)
        satuanSelect.options.length = 1;

        // Jika tipe belum dipilih, hentikan eksekusi lebih lanjut
        if (!selectedId) {
            return '';
        }

        $.ajax({
            url: `/kelompok/PLACEHOLDER/get_data`.replace('PLACEHOLDER', selectedId),
            type: 'GET',
            success: function(response) {
                console.log(response.satuan)
                // Buat opsi untuk setiap satuan yang difilter dan tambahkan ke select element
                let satuanSelect = document.getElementById('select-satuan');
                satuanSelect.innerHTML = ''; // Kosongkan opsi sebelum menambahkan yang baru

                let satuans = response.data.satuans;
                // Buat opsi untuk setiap satuan yang difilter dan tambahkan ke select element
                let option = document.createElement('option');
                    option.value = "";
                    option.text = `Pilih Komponen`;
                    satuanSelect.appendChild(option);
                satuans.forEach(function(satuan) {
                    let option = document.createElement('option');
                    option.value = satuan.id;
                    option.text = `${satuan.nama_item}`;
                    satuanSelect.appendChild(option);
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function updateTotalSearch() {
        const harga = parseFloat($(`#harga-input`).text()) || 0;
        const volume = parseFloat($(`#volume-input`).val()) || 0;
        const total = harga * volume;
        totaltotal = total;
        $(`#total-search`).text(total.toLocaleString('id-ID'));
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        let pagu = {{$item_kegiatan->pagu_indikatif}};
        $('#itemkegiatan tbody tr').each(function() {
            const totalRow = $(this).find('td:nth-last-child(2)').text(); // Adjust this selector based on your table structure
            const totalValue = parseFloat(totalRow.replace(/\D/g, '')) || 0; // Extract numeric values
            grandTotal += totalValue;
        });

        const volumeTotal = (grandTotal);
        const sisaPagu = pagu - grandTotal;
        $('#grand-total').text(grandTotal.toLocaleString('id-ID'));
        $('#volume-total').text(volumeTotal.toLocaleString('id-ID'));
        $('#sisa-pagu').text(sisaPagu.toLocaleString('id-ID'));
    }



    function updateSearch(selectElement) {
        let selectedId = selectElement.value;
        // console.log(selectedId);
        $.ajax({
                url: `/satuan/PLACEHOLDER/get_data`.replace('PLACEHOLDER', selectedId),
                type: "GET",
                cache: false,
                success: function(response) {
                    komponen = response.data;
                    $('#harga-input').text(response.data.harga);
                    totaltotal = parseFloat(response.data.harga) * parseFloat($('#volume-input').val());
                    $('#total-search').text(totaltotal);
                    updateGrandTotal();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
        });
    }
</script>



<script>
    $(document).ready(function() {

        // Fungsi untuk menghitung total dan memperbarui total setiap kali ada perubahan pada input harga atau volume

        let counter = 1;

        $('#addRowBtn').click(function() {
            const newRow = `<tr class="draggable-row">
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="${counter}_sub_item_kegiatan" placeholder="Nama Sub" readonly>${komponen.kode_rekening}</textarea><input type="hidden" name="${counter}_id_item" value="${komponen.id}"></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="${counter}_tipe_item_kegiatan" placeholder="Nama Tipe" readonly>${komponen.kelompok.uraian}</textarea></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="${counter}_nama_item_kegiatan" placeholder="Nama Item" readonly>${komponen.nama_item}</textarea></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input type="text" class="form-control form-control-sm" name="${counter}_satuan_item_kegiatan" placeholder="Ex. Kg/Lbr" readonly value="${komponen.satuan}"></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input style="width: 100px;" type="number" id="harga-input-${counter}" class="harga-input form-control form-control-sm" name="${counter}_harga_item_kegiatan" placeholder="" value="${$('#harga-input').text()}" oninput="updateTotal(${counter}); updateGrandTotal();" readonly></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input style="width: 100px;" type="number" id="volume-input-${counter}" class="volume-input form-control form-control-sm" name="${counter}_volume_item_kegiatan" placeholder="" oninput="updateTotal(${counter}); updateGrandTotal();" value="${$('#volume-input').val()}"></td>
                                <td style="font-size: .999rem">Rp.<span id="total-row-${counter}">${totaltotal.toLocaleString('id-ID')}</span></td>
                                <td><a class="delete btn btn-icon btn-danger deleteRowBtn">x</a></td>
                            </tr>`;

            $('#itemkegiatan tbody').append(newRow);
            counter++;
            updateGrandTotal();
        });

        $('#itemkeg tbody').sortable({
            items: 'tr',
            cursor: 'move',
            axis: 'y'
        });

        $(document).on('click', '.deleteRowBtn', function() {
            $(this).closest('tr').remove();
            updateGrandTotal();
        });

        $(document).on('click', '#kegiatan-submit', function(e) {
            e.preventDefault();
            console.log(parseFloat($('#sisa-pagu').html()));
            if (parseFloat($('#sisa-pagu').html()) < 0){
                $('#insufficient').modal('show')
            } else {
                $('#add-kegiatan').submit();
            }
        });
    });
</script>
