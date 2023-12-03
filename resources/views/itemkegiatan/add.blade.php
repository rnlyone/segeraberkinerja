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
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Sub Kegiatan untuk Kegiatan {{$kegiatan->nama_kegiatan}}
                            ({{$program->renstra->skpd->nama_skpd}})</h4>
                    </div>
                    <div class="card-body">
                        <form id="add-kegiatan" action="{{route('kegiatan.store')}}" method="POST" class="form form-horizontal">
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
                                        <input type="text" id="kode-id" class="form-control" name="kode" placeholder="Kode Sub Kegiatan">
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
                                                placeholder="Nama Sub Kegiatan">
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
                                                placeholder="Contoh : Cm, M, Kg2">
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
                                                            <th>Sub</th>
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
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="6">Total Per Sub Kegiatan</th>
                                                            <th>Rp.<span id="grand-total"></span></th>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="6">Total * Volume Sub Kegiatan</th>
                                                            <th>Rp.<span id="volume-total"></span></th>
                                                            <th></th>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th colspan="6">Sisa Pagu Anggaran Kegiatan "{{$program->nama_program}}" ({{$renstra->periode}}-{{$renstra->periode+5}})</th>
                                                            <th>Rp.<span id="sisa-pagu">{{$sisa_pagu_anggaran}}</span></th>
                                                            <th></th>
                                                        </tr> --}}
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <a id="addRowBtn" class="btn btn-outline-secondary waves-effect">Tambah Komponen</a>
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
<div
class="modal fade modal-danger text-start"
id="insufficient"
tabindex="-1"
aria-labelledby="myModalLabel120"
aria-hidden="true"
>
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
{{-- <script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script> --}}

<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
{{-- <script src="/app-assets/js/scripts/forms/form-quill-editor.min.js"></script> --}}
<!-- END: Page JS-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>
    function updateTotal(counter) {
            const harga = parseFloat($(`#harga-input-${counter}`).val()) || 0;
            const volume = parseFloat($(`#volume-input-${counter}`).val()) || 0;
            const total = harga * volume;
            $(`#total-row-${counter}`).text(total.toLocaleString('id-ID'));
        }

    function updateGrandTotal() {
        let grandTotal = 0;
        $('#itemkegiatan tbody tr').each(function() {
            const totalRow = $(this).find('td:nth-last-child(2)').text(); // Adjust this selector based on your table structure
            const totalValue = parseFloat(totalRow.replace(/\D/g, '')) || 0; // Extract numeric values
            grandTotal += totalValue;
        });

        const volumeTotal = (grandTotal);
        // const sisaPagu = pagu - (grandTotal * volume);
        $('#grand-total').text(grandTotal.toLocaleString('id-ID'));
        $('#volume-total').text(volumeTotal.toLocaleString('id-ID'));
        // $('#sisa-pagu').text(sisaPagu.toLocaleString('id-ID'));
    }
</script>

padding-right: 0rem; padding-left: 0rem;

<script>
    $(document).ready(function() {

        // Fungsi untuk menghitung total dan memperbarui total setiap kali ada perubahan pada input harga atau volume

        let counter = 1;

        $('#addRowBtn').click(function() {
            const newRow = `<tr class="draggable-row">
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="${counter}_sub_item_kegiatan" placeholder="Nama Sub"></textarea></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="${counter}_tipe_item_kegiatan" placeholder="Nama Tipe"></textarea></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><textarea type="text" class="form-control form-control-sm" name="${counter}_nama_item_kegiatan" placeholder="Nama Item"></textarea></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input type="text" class="form-control form-control-sm" name="${counter}_satuan_item_kegiatan" placeholder="Ex. Kg/Lbr"></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input style="width: 100px;" type="number" id="harga-input-${counter}" class="harga-input form-control form-control-sm" name="${counter}_harga_item_kegiatan" placeholder="" oninput="updateTotal(${counter}); updateGrandTotal();"></td>
                                <td style="padding-right: 0.3rem; padding-left: 0.3rem;"><input style="width: 100px;" type="number" id="volume-input-${counter}" class="volume-input form-control form-control-sm" name="${counter}_volume_item_kegiatan" placeholder="" oninput="updateTotal(${counter}); updateGrandTotal();" value="1"></td>
                                <td>Rp.<span id="total-row-${counter}"></span></td>
                                <td><a class="delete btn btn-icon btn-danger deleteRowBtn">x</a></td>
                            </tr>`;

            $('#itemkegiatan tbody').append(newRow);
            counter++;
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
