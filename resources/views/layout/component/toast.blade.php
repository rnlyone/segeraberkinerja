<div class="toast-container">
    <!-- Sukses -->
    @if (session()->get('success'))
    <div class="toast basic-toast position-fixed top-0 end-0 m-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="ms-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div class="alert alert-success" role="alert">
                <div class="alert-body"><strong>{{ session('success') }}</strong></div>
              </div>
        </div>
    </div>
    @endif

    <!-- Error -->
    @if (session()->get('failed'))
    <div class="toast basic-toast position-fixed top-0 end-0 m-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Gagal</strong>
            <button type="button" class="ms-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div class="alert alert-danger" role="alert">
                <div class="alert-body"><strong>{{ session('failed') }}</strong></div>
              </div>
        </div>
    </div>
    @endif

    <!-- Pesan Validasi -->
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="toast basic-toast position-fixed top-0 end-0 m-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Error</strong>
                <button type="button" class="ms-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-body"><strong>{{$error}}</strong></div>
                  </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<script>
    // Trigger untuk menampilkan toast ketika kondisi terpenuhi
    document.addEventListener('DOMContentLoaded', function () {
        // Tentukan trigger untuk menampilkan toast
        // Misalnya, saat pesan sukses atau error tersedia
        @if (session()->has('success') || session()->has('error'))
        // Pilih semua toast dengan class basic-toast
        const toasts = document.querySelectorAll('.basic-toast');

        // Untuk setiap toast, tampilkan dengan delay 1 detik
        toasts.forEach((toast, index) => {
            setTimeout(() => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
            }, index * 1000); // Delay per toast
        });
        @endif
    });
</script>
