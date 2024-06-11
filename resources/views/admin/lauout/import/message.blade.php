<script src="{{asset('admin-assets/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<script>
    var soundfile = "{{asset('intuition.mp3')}}";

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            var audplay = new Audio(soundfile)
            audplay.play();
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;

        }
    });
</script>
@if(session('error'))
    <script>

        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        })

    </script>
@endif
@if(session('success'))
    <script>

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        })

    </script>
@endif

