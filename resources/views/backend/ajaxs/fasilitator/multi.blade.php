<script type="text/javascript">
    window.onload = function() {
    };

    $(document).ready(function () {
        $('#multiTable').DataTable({
            fixedColumns: {
                left: 1,
                right: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 415,
            dom: 'frtip',
            processing: true,
            serverSide: true,
            deferRender: true,
            searchDelay: 600,
            ajax: "{{ route('multi.table') }}",
            columns: [
                { data: "DT_RowIndex", searchable: false, orderable: false },
                { data: "nip" },
                { data: "nama" },
                { data: "judul_acara", searchable: false, orderable: false },
                { data: "tempat", searchable: false, orderable: false  },
                { data: "angkatan", searchable: false, orderable: false  }
            ]
        });
    });
</script>