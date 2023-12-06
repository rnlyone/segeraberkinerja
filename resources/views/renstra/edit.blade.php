<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/katex.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/quill.bubble.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap">
<link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/form-quill-editor.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/form-quill-editor.min.css">
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
                            <h2 class="content-header-title float-start mb-0">Edit Renstra</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('renstra.index')}}">Data Renstra</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('renstra.create')}}">Edit Renstra</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Wizard -->
            <section class="vertical-wizard">
                <div class="bs-stepper vertical vertical-wizard-example">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#periode-renstra" role="tab" id="periode-renstra-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">1</span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Periode</span>
                        <span class="bs-stepper-subtitle">Tentukan Periode Renstra</span>
                        </span>
                    </button>
                    </div>
                    <div class="step" data-target="#visi-renstra" role="tab" id="visi-renstra-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">2</span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Visi</span>
                        <span class="bs-stepper-subtitle">Masukkan Visi Renstra</span>
                        </span>
                    </button>
                    </div>
                    <div class="step" data-target="#misi-renstra" role="tab" id="misi-renstra-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">3</span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Misi</span>
                        <span class="bs-stepper-subtitle">Masukkan Misi Renstra</span>
                        </span>
                    </button>
                    </div>
                    <div class="step" data-target="#tujuan-renstra" role="tab" id="tujuan-renstra-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">4</span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Tujuan</span>
                        <span class="bs-stepper-subtitle">Masukkan Tujuan Renstra</span>
                        </span>
                    </button>
                    </div>
                    <div class="step" data-target="#sasaran-renstra" role="tab" id="sasaran-renstra-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">5</span>
                            <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Sasaran</span>
                            <span class="bs-stepper-subtitle">Masukkan Sasaran Renstra</span>
                            </span>
                        </button>
                        </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="renstra-store" action="{{route('renstra.store')}}" method="post">
                        @csrf
                        <div
                        id="periode-renstra"
                        class="content"
                        role="tabpanel"
                        aria-labelledby="periode-renstra-trigger"
                        >
                        <div class="content-header">
                            <h5 class="mb-0">Periode Rencana Strategis</h5>
                            <small class="text-muted">Masukkan Periode Renstra.</small>
                        </div>
                        <div class="row">
                            <div class="mb-1">
                                <label class="form-label" for="pilih-periode">Periode</label>
                                <select class="form-select select2" id="pilih-periode" name="periode" required>
                                <option value="">Pilih Periode</option>
                                @php
                                $currentYear = intval(date('Y'));
                                    @endphp
                                    @for ($i=$currentYear-10;$i<$currentYear+20; $i++)
                                    <option value="{{$i}}">{{$i}}-{{$i+5}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-secondary btn-prev" disabled>
                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Selanjutnya</span>
                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                        </div>
                        </div>
                        <div id="visi-renstra" class="content" role="tabpanel" aria-labelledby="visi-renstra-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Visi Rencana Strategis</h5>
                                <small class="text-muted">Masukkan Visi Renstra.</small>
                            </div>
                        <div class="row mb-2">
                            <input type="hidden" id="visi-input" name="visi">
                            <div class="col-sm-12 mb-5">
                                <div id="full-wrapper">
                                  <div id="full-container">
                                    <div id="visi-editor" class="editor">
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Selanjutnya</span>
                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                        </div>
                        </div>
                        <div id="misi-renstra" class="content" role="tabpanel" aria-labelledby="misi-renstra-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Misi Rencana Strategis</h5>
                                <small class="text-muted">Masukkan Misi Renstra.</small>
                            </div>
                        <div class="row mb-2">
                            <input type="hidden" id="misi-input" name="misi">
                            <div class="col-sm-12 mb-5">
                                <div id="full-wrapper">
                                  <div id="full-container">
                                    <div id="misi-editor" class="editor">
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Selanjutnya</span>
                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                        </div>
                        </div>
                        <div id="tujuan-renstra" class="content" role="tabpanel" aria-labelledby="tujuan-renstra-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Tujuan Rencana Strategis</h5>
                                <small class="text-muted">Masukkan Tujuan Renstra.</small>
                            </div>
                        <div class="row mb-2">
                            <input type="hidden" id="tujuan-input" name="tujuan">
                            <div class="col-sm-12 mb-5">
                                <div id="full-wrapper">
                                  <div id="full-container">
                                    <div id="tujuan-editor" class="editor">
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none">Selanjutnya</span>
                                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                        <div id="sasaran-renstra" class="content" role="tabpanel" aria-labelledby="sasaran-renstra-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Sasaran Rencana Strategis</h5>
                                <small class="text-muted">Masukkan Sasaran Renstra.</small>
                            </div>
                        <div class="row mb-2">
                            <input type="hidden" id="sasaran-input" name="sasaran">
                            <div class="col-sm-12 mb-5">
                                <div id="full-wrapper">
                                  <div id="full-container">
                                    <div id="sasaran-editor" class="editor">
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                                </button>
                                <button id="renstra-create-submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </section>
            <!-- /Vertical Wizard -->


        </div>
    </div>
</div>
@include('layout.footer')
<script src="/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
<script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="/app-assets/js/scripts/forms/form-wizard.min.js"></script>


<!-- BEGIN: Page Vendor JS-->
<script src="/app-assets/vendors/js/editors/quill/katex.min.js"></script>
<script src="/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
<script src="/app-assets/vendors/js/editors/quill/quill.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
{{-- <script src="/app-assets/js/scripts/forms/form-quill-editor.min.js"></script> --}}
<!-- END: Page JS-->

<script>
    function setEditorContentToHiddenInput(editor, inputId) {
        var editorContent = editor.root.innerHTML;
        $('#' + inputId).val(editorContent);
    }

    $(document).ready(function() {
        var VisiEditor = new Quill('#visi-editor', {
            bounds: "#visi-editor",
            modules: {
                formula: !0,
                syntax: !0,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: "1"
                    }, {
                        header: "2"
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video", "formula"],
                    ["clean"]
                ]
            },
            theme: "snow"
        });

        var MisiEditor = new Quill('#misi-editor', {
            bounds: "#misi-editor",
            modules: {
                formula: !0,
                syntax: !0,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: "1"
                    }, {
                        header: "2"
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video", "formula"],
                    ["clean"]
                ]
            },
            theme: "snow"
        });

        var TujuanEditor = new Quill('#tujuan-editor', {
            bounds: "#tujuan-editor",
            modules: {
                formula: !0,
                syntax: !0,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: "1"
                    }, {
                        header: "2"
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video", "formula"],
                    ["clean"]
                ]
            },
            theme: "snow"
        });

        var SasaranEditor = new Quill('#sasaran-editor', {
            bounds: "#sasaran-editor",
            modules: {
                formula: !0,
                syntax: !0,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: "1"
                    }, {
                        header: "2"
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video", "formula"],
                    ["clean"]
                ]
            },
            theme: "snow"
        });
        $('#renstra-create-submit').on('click', function(event) {
                // event.preventDefault();
                // Memasukkan konten dari masing-masing editor ke dalam input hidden yang sesuai
                setEditorContentToHiddenInput(VisiEditor, 'visi-input');
                setEditorContentToHiddenInput(MisiEditor, 'misi-input');
                setEditorContentToHiddenInput(TujuanEditor, 'tujuan-input');
                setEditorContentToHiddenInput(SasaranEditor, 'sasaran-input');

                // Lanjutkan proses submit form...
                $('renstra-store').submit();
            });

        $('.btn-next').on('click', function(e) {
            // Prevent the default action of the clicked item. In this case that is submit
            e.preventDefault();

            // Make sure the button is not submitted after all!
            return false;
        });
        $('.btn-prev').on('click', function(e) {
            // Prevent the default action of the clicked item. In this case that is submit
            e.preventDefault();

            // Make sure the button is not submitted after all!
            return false;
        });
    });



</script>





