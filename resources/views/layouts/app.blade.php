<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
    </script>
@endif