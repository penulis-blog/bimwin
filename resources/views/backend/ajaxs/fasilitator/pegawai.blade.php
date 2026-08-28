<script type="text/javascript">
    window.onload = function() {
    };

    $(document).ready(function () {
        $('#pegawaiTable').DataTable({
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
            ajax: "{{ route('pegawai.table') }}",
            columns: [
                { data: "DT_RowIndex", searchable: false, orderable: false },
                { data: "nama" },
                { data: "jabatan", searchable: false, orderable: false },
                { data: "pegawai" },
                { data: "instansi", searchable: false, orderable: false },
                { data: "no_hp", searchable: false, orderable: false  },
                { data: "email", searchable: false, orderable: false  }
            ]
        });
    });
</script>