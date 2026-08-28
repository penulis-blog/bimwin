<script type="text/javascript">
    window.onload = function() {
    };

    $(document).ready(function () {
        $('#menuTable').DataTable({
            fixedColumns: {
                left: 1,
                right: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 415,
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Tambah Data',
                    action: function (e, dt, node, config) {
                        var tambah = {{ get_add() }};
                        if (tambah == 1) {
                            $('#tambahMenu').modal('show');
                        } else if (tambah == 0) {
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Anda tidak diberi akses penambahan data.",
                                icon: "warning",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                }, {
                    text: 'Laporan',
                    action: function (e, dt, node, config) {
                        var laporan = {{ get_laporan() }};
                        if (laporan == 1) {
                            $('#laporanMenu').modal('show');
                        } else if (laporan == 0) {
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Anda tidak diberi akses unduh laporan.",
                                icon: "warning",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                }
            ],
            'processing': true,
            'serverSide': true,
            'deferRender': true,
            'pageLength': 9,
            "ajax": "{{ route('roles.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "nama" },
                { "data": "keterangan" },
                { "data": "status" },
                { "data": "aksi" },
            ]
        });
    });

    // proses tambah
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_menu");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const nama = formData.get("nama_roles")?.trim();
                const keterangan = formData.get("keterangan_roles")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    nama: { value: nama, message: "Maaf, nama group harus diisi." },
                    keterangan: { value: keterangan, message: "Maaf, keterangan harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("tambahMenu");
                showLoader();

                const response = await fetch("{{ url('566c1039-393b-45c0-bd66-1f7d172f07c9') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader();
            }
        });

        // Fungsi bantu
        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "block";
        }

        function hideLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "none";
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.hide();
            }
        }
    });

    Page.Edit = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $.ajax({
                url: "{{ url('2e63a901-770a-49b6-bf72-e61421df58b5') }}/" + val,
                type: 'GET',
                success: function(response){
                    if(response.message == 200){
                        $('#editRoles').modal('show');
                        $('#publicid_roles').attr('value', response.data[0].public_id);
                        $('#edit_nama_roles').attr('value', response.data[0].nama);
                        $('textarea#edit_keterangan_roles').val(response.data[0].keterangan);
                        if(response.data[0].is_trash == 1){
                            document.getElementById('edit_status_roles').value = response.data[0].is_trash;
                        }else if(response.data[0].is_trash == 0){
                            document.getElementById('edit_status_roles').value = response.data[0].is_trash;
                        }
                    }else if(response.message == 404){
                        Swal.fire({
                            title: "Informasi",
                            text: "Maaf, Data tidak ditemukan.",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "OK"
                        });
                    }
                }
            });
        }
    }

    Page.Detail = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $.ajax({
                url: "{{ url('83c15b0c-bc16-4f68-8b3f-972bef7f11d3') }}/" + val,
                type: 'GET',
                success: function(response){
                    if(response.message == 200){
                        $('#detailRoles').modal('show');
                        $('#group').text(response.data[0].nama);
                        $('#keterangan').text(response.data[0].keterangan);
                        $('#status').text(response.data[0].status);
                    }else if(response.message == 404){
                        Swal.fire({
                            title: "Informasi",
                            text: "Maaf, Data tidak ditemukan.",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "OK"
                        });
                    }
                }
            });
        }
    }

    // proses update
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("edit_form_roles");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const enama = formData.get("edit_nama_roles")?.trim();
                const eketerangan = formData.get("edit_keterangan_roles")?.trim();
                const estatus = formData.get("edit_status_roles")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    enama: { value: enama, message: "Maaf, nama group harus diisi." },
                    eketerangan: { value: eketerangan, message: "Maaf, keterangan harus diisi." },
                    estatus: { value: estatus, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("editRoles");
                showLoader();

                const response = await fetch("{{ url('c068d6fa-31f8-48c3-891d-5f0233d1a51b') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader();
            }
        });

        // Fungsi bantu
        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "block";
        }

        function hideLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "none";
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.hide();
            }
        }
    });

    Page.Config = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $.ajax({
                url: "{{ url('fdc799d7-6517-4a6f-b82f-632bb9a41198') }}/" + val,
                type: 'GET',
                success: function(response){
                    if(response.message == 200){
                        createTable(response.data);
                    }else if(response.message == 404){
                        Swal.fire({
                            title: "Informasi",
                            text: "Maaf, Data tidak ditemukan.",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "OK"
                        });
                    }
                }
            });
        }
    }

    function createTable(data)
    {
        var html = '';
        data.forEach(function(row, i){
            html += '<tr>';
            html += '<input type="hidden" name="id[]" value="'+row.id_permissions+'"/>';
            html += '<input type="hidden" name="id_roles[]" value="'+row.id_roles+'"/>';
            html += '<td>'+(i+1)+'</td>';
            html += '<td style="text-align: left !important;">'+row.nama_indent+'</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_view[]" id="isview'+i+'" value="'+row.view+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_add[]" id="isadd'+i+'" value="'+row.add+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_edit[]" id="isedit'+i+'" value="'+row.edit+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_delete[]" id="isdelete'+i+'" value="'+row.delete+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_report[]" id="isreport'+i+'" value="'+row.report+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_password[]" id="ispassword'+i+'" value="'+row.password+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_agree[]" id="isagree'+i+'" value="'+row.agree+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_back[]" id="isback'+i+'" value="'+row.back+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_config[]" id="isconfig'+i+'" value="'+row.config+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_module[]" id="ismodule'+i+'" value="'+row.module+'"/>' + '</td>';
            html += '<td style="margin-top:-7px; margin-left:10px;"><input type="checkbox" name="is_download[]" id="isdownload'+i+'" value="'+row.download+'"/>' + '</td>';
            html += '</tr>';
        });

        $('#permission_data').html(html);
        $('#permissionsRoles').modal('show');
        formchek(data);
    }

    function formchek(data){
        data.forEach(function(row, i){
            if($('#isview'+i).val() == 1){
                $('#isview'+i).prop('checked', true)
            }
            
            $('#isview'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isadd'+i).val() == 1){
                $('#isadd'+i).prop('checked', true)
            }
            
            $('#isadd'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isedit'+i).val() == 1){
                $('#isedit'+i).prop('checked', true)
            }
            
            $('#isedit'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isdelete'+i).val() == 1){
                $('#isdelete'+i).prop('checked', true)
            }
            
            $('#isdelete'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isreport'+i).val() == 1){
                $('#isreport'+i).prop('checked', true)
            }
            
            $('#isreport'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#ispassword'+i).val() == 1){
                $('#ispassword'+i).prop('checked', true)
            }
            
            $('#ispassword'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isagree'+i).val() == 1){
                $('#isagree'+i).prop('checked', true)
            }
            
            $('#isagree'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isback'+i).val() == 1){
                $('#isback'+i).prop('checked', true)
            }
            
            $('#isback'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isconfig'+i).val() == 1){
                $('#isconfig'+i).prop('checked', true)
            }
            
            $('#isconfig'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#ismodule'+i).val() == 1){
                $('#ismodule'+i).prop('checked', true)
            }
            
            $('#ismodule'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });

            if($('#isdownload'+i).val() == 1){
                $('#isdownload'+i).prop('checked', true)
            }
            
            $('#isdownload'+i).on('click', function(){
                if($(this).is(':checked')){
                    $(this).val(1)
                }else{
                    $(this).val(0)
                }
            });
        });
    }

    Page.SavePermissions = function()
    {
        var e               = $('input[name="_token"]').val();
        var id              = $('input[name="id[]"]').map(function(){ return this.value; }).get();
        var id_roles        = $('input[name="id_roles[]"]').map(function(){ return this.value; }).get();
        var is_view         = $('input[name="is_view[]"]').map(function(){ return this.value; }).get();
        var is_add          = $('input[name="is_add[]"]').map(function(){ return this.value; }).get();
        var is_edit         = $('input[name="is_edit[]"]').map(function(){ return this.value; }).get();
        var is_delete       = $('input[name="is_delete[]"]').map(function(){ return this.value; }).get();
        var is_report       = $('input[name="is_report[]"]').map(function(){ return this.value; }).get();
        var is_password     = $('input[name="is_password[]"]').map(function(){ return this.value; }).get();
        var is_agree        = $('input[name="is_agree[]"]').map(function(){ return this.value; }).get();
        var is_back         = $('input[name="is_back[]"]').map(function(){ return this.value; }).get();
        var is_config       = $('input[name="is_config[]"]').map(function(){ return this.value; }).get();
        var is_module       = $('input[name="is_module[]"]').map(function(){ return this.value; }).get();
        var is_download     = $('input[name="is_download[]"]').map(function(){ return this.value; }).get();
        var url             = "{{ url('d85699c3-fd90-4269-94a2-38c546ede95f') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {id:id, id_roles:id_roles, is_view:is_view, is_add:is_add, is_edit:is_edit, is_delete:is_delete, is_report:is_report, 
                is_password:is_password, is_agree:is_agree, is_back:is_back, is_module:is_module, is_config:is_config, is_download:is_download, _token:e},
            beforeSend: function() {
                $('#Loader').show();
                $('#permissionsRoles').modal('hide');
            },
            complete: function(response) {
                $('#Loader').hide();
                $('#permissionsRoles').modal('hide');
            },
            success: function(response){
                $('#permissionsRoles').modal('hide');
                Swal.fire("Berhasil", "Permissions berhasil diperbaharui.", "success").then(() => { window.location.href = window.location.pathname; });
            }
        });
    }

    Page.Delete = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            var a = val;
            var e = $('input[name="_token"]').val();

            Swal.fire({
                title: 'Apa Kamu Yakin?',
                text: "Data akan masuk status nonaktif.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        url: "{{ url('927d25e7-0e35-478c-9b98-26edb2b35561') }}",
                        type: 'POST',
                        data: {val:a, _token:e},
                        success: function(response){
                            if(response.message == 200){
                                Swal.fire("Berhasil", "Data berhasil di nonaktifkan.","success").then( () => {location.href = location.pathname;});
                            }else if(response.message == 201){
                                Swal.fire({
                                    title: "Informasi",
                                    text: "Maaf, Terjadi kesalahan saat menghapus.",
                                    icon: "error",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonText: "OK"
                                });
                            }
                        }
                    });
                }else{
                    Swal.fire('Informasi', 'Data tidak jadi di hapus.', 'info');
                }
            });
        }
    }

    Page.Batal = function()
    {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahMenu').modal('hide');
                $('#detailRoles').modal('hide');
                $('#editRoles').modal('hide');
                $('#permissionsRoles').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    $(function(){
        $("input[name='nama_roles']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9 ]/g, ''));
        });
        $("textarea[name='keterangan_roles']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9., ]/g, ''));
        });
        $("input[name='edit_nama_roles']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9 ]/g, ''));
        });
        $("textarea[name='edit_keterangan_roles']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9., ]/g, ''));
        });
    });
</script>