<script type="text/javascript">
    window.onload = function() {
    };

    $(document).ready(function () {
        $('#golonganTable').DataTable({
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
            ajax: "{{ route('golongan.table') }}",
            columns: [
                { data: "DT_RowIndex", searchable: false, orderable: false },
                { data: "jabatan", searchable: false, orderable: false },
                { data: "golongan", searchable: false, orderable: false  },
                { data: "instansi" },
                { data: "nama" },
                { data: "no_hp", searchable: false, orderable: false  },
                { data: "email", searchable: false, orderable: false  }
            ]
        });
    });
</script>