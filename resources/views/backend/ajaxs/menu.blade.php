<script type="text/javascript">
    window.onload = function() {
        $('#class_systems').hide();
        $('#class_number').hide();
        $('#Loader').hide();
        $('#edit_class_icon_child').hide();
        $('#id_checkbox').val('false');
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
            "ajax": "{{ route('menu.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "nama" },
                { "data": "icon" },
                { "data": "kategoris" },
                { "data": "methods" },
                { "data": "systems" },
                { "data": "status" },
                { "data": "aksi" },
            ]
        });
    });

    $("#id_checkbox").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } else {
            $(this).attr('value', 'false');
        }

        var hasil = $('#id_checkbox').val();

        if(hasil === 'true'){
            $('#class_induk, #class_parent, #class_subparent, #class_method, #class_controller, #class_action, #class_alias, #class_middleware').hide('slow');
            $('#class_systems').show('slow');
        }else{
            $('#class_systems').hide('slow');
            $('#class_kategori, #class_induk, #class_parent, #class_subparent, #class_nama, #class_icon, #class_method, #class_pranala, #class_controller, #class_action, #class_alias, #class_middleware').show('slow');
        }
    });

    function IS_Systems(val)
    {
        if(val == 1){
            $('#class_number, #class_icon').hide('slow');
            $('#class_method, #class_controller, #class_action, #class_alias, #class_middleware').show('slow');
        }else{
            $('#class_alias').hide('slow');
            $('#class_method, #class_controller, #class_action, #class_middleware, #class_number, #class_icon').show('slow');
        }
    }

    function IS_Kategori(val)
    {
        // 1 = Frontend dan 2 = Backend
        const value_systems = document.getElementById("id_systems").value;

        if(val == 2 && value_systems == 0)
        {
            $.ajax({
                url: "{{ url('619e12a9-4443-48ea-8c55-c42f223a336c') }}/" + val,
                type: 'GET',
                success: function(response){
                    var sel = document.getElementById("id_urutan_menu");

                    // Kosongkan dulu pilihan sebelumnya (opsional)
                    sel.innerHTML = "";

                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    // Tambahkan data dari response
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id;
                        opt.text = response.data[i].nama;
                        sel.add(opt);
                    }
                }
            });
        }else{ // kategori anak menu
            if(val == 1 && value_systems == 'Pilih'){
                $('#class_subparent').hide();
                $('#class_icon').hide();
                $('#class_alias').hide();
                $('#class_middleware').hide();
            }else if(val == 2 && value_systems == 'Pilih'){
                $('#class_alias').hide();
                $('#class_kategori').show();
                $('#class_induk').show();
                $('#class_parent').show();
                $('#class_subparent').show();
                $('#class_nama').show();
                $('#class_icon').show();
                $('#class_method').show();
                $('#class_pranala').show();
                $('#class_controller').show();
                $('#class_action').show();
                $('#class_middleware').show();

                $.ajax({
                    url: "{{ url('619e12a9-4443-48ea-8c55-c42f223a336c') }}/" + val,
                    type: 'GET',
                    success: function(response){
                        var sel = document.getElementById("id_induk");
                        $('#id_induk').children('option').remove();
                        $('#id_parent').children('option').remove();
                        $('#id_child').children('option').remove();

                        // Kosongkan dulu pilihan sebelumnya (opsional)
                        sel.innerHTML = "";

                        var defaultOption = document.createElement("option");
                        defaultOption.value = "";
                        defaultOption.text = "Pilih";
                        sel.add(defaultOption);

                        // Tambahkan data dari response
                        for (var i = 0; i < response.data.length; i++) {
                            var opt = document.createElement("option");
                            opt.value = response.data[i].id;
                            opt.text = response.data[i].nama;
                            sel.add(opt);
                        }
                    }
                });
            }else{
                $.ajax({
                    url: "{{ url('619e12a9-4443-48ea-8c55-c42f223a336c') }}/" + val,
                    type: 'GET',
                    success: function(response){
                        var sel = document.getElementById("id_urutan_menu");
                        
                        // Kosongkan dulu pilihan sebelumnya (opsional)
                        sel.innerHTML = "";

                        var defaultOption = document.createElement("option");
                        defaultOption.value = "";
                        defaultOption.text = "Pilih";
                        sel.add(defaultOption);

                        // Tambahkan data dari response
                        for (var i = 0; i < response.data.length; i++) {
                            var opt = document.createElement("option");
                            opt.value = response.data[i].id;
                            opt.text = response.data[i].nama;
                            sel.add(opt);
                        }
                    }
                });
            }
        }
    }

    function ParentMenu(val)
    {
        $.ajax({
            url: "{{ url('032a49af-4511-41de-8921-0e1f59693a73') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("id_parent");
                $('#id_parent').children('option').remove();
                $('#id_child').children('option').remove();

                // Kosongkan dulu pilihan sebelumnya (opsional)
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "Pilih";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }
            }
        });
    }

    function Edit_ParentMenu(val, id)
    {
        $.ajax({
            url: "{{ url('032a49af-4511-41de-8921-0e1f59693a73') }}/" + val,
            type: 'GET',
            success: function(respo){
                var sel = document.getElementById("edit_id_parent");

                $('#edit_id_parent').children('option').remove();
                $('#edit_id_child').children('option').remove();

                // Kosongkan dulu pilihan sebelumnya (opsional)
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "Pilih";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < respo.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = respo.data[i].id;
                    opt.text = respo.data[i].nama;
                    sel.add(opt);
                    if (String(opt.value) === String(id)) {
                        opt.selected = true;
                    }
                }
            }
        });
    }

    function Edit_ChildParent(val, id)
    {
        $.ajax({
            url: "{{ url('95e4d2c3-1669-44e6-b253-415b44ca6840') }}/" + val,
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("edit_id_child");

                // Kosongkan pilihan sebelumnya
                sel.innerHTML = "";

                // Tambahkan opsi default
                var defaultOption = document.createElement("option");
                defaultOption.value = "Pilih";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Cek jika response kosong atau tidak
                if (response.data.length === 0) {
                    // Tambahkan opsi buatkan menu child
                    var buatOption = document.createElement("option");
                    buatOption.value = "buat_menu_child"; // atau ID khusus lainnya
                    buatOption.text = "Buatkan menu child";
                    sel.add(buatOption);
                } else {
                    // Tambahkan data dari response
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id;
                        opt.text = response.data[i].nama;
                        sel.add(opt);
                        if (String(opt.value) === String(id)) {
                            opt.selected = true;
                        }
                    }
                }
            }
        });
    }

    function ChildParent(val)
    {
        $.ajax({
            url: "{{ url('95e4d2c3-1669-44e6-b253-415b44ca6840') }}/" + val,
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("id_child");

                // Kosongkan pilihan sebelumnya
                sel.innerHTML = "";

                // Tambahkan opsi default
                var defaultOption = document.createElement("option");
                defaultOption.value = "Pilih";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Cek jika response kosong atau tidak
                if (response.data.length === 0) {
                    // Tambahkan opsi buatkan menu child
                    var buatOption = document.createElement("option");
                    buatOption.value = "buat_menu_child"; // atau ID khusus lainnya
                    buatOption.text = "Buatkan menu child";
                    sel.add(buatOption);
                } else {
                    // Tambahkan data dari response
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id;
                        opt.text = response.data[i].nama;
                        sel.add(opt);
                    }
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_menu");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const isChecked = document.getElementById("id_checkbox").checked;
                const systems = formData.get("id_systems")?.trim();
                const kategori = formData.get("id_kategori")?.trim();
                const induk = formData.get("id_induk")?.trim();
                const parent = formData.get("id_parent")?.trim();
                const child = formData.get("id_child")?.trim();
                const number = formData.get("id_urutan_menu")?.trim();
                const nama = formData.get("nama_menu")?.trim();
                const icon = formData.get("icon_menu")?.trim();
                const method = formData.get("id_method")?.trim();
                const pranala = formData.get("uri_pranala")?.trim();
                const controllers = formData.get("controller")?.trim();
                const actions = formData.get("action")?.trim();
                const routes = formData.get("name_route")?.trim();
                const middlewares = formData.get("middleware")?.trim();
                const token = formData.get("_token")?.trim();

                if(isChecked == true){ // kalo checkbox di ceklis
                    if(systems == 'Pilih'){
                        return showError("Maaf, is systems harap dipilih.");
                    }else{
                        if(systems == 1){ // untuk query atau proses menu
                            const fields = {
                                systems: { value: systems, message: "Maaf, is systems harus dipilih.", skipIf: 'Pilih' },
                                kategori: { value: kategori, message: "Maaf, kategori harus dipilih.", skipIf: 'Pilih' },
                                nama: { value: nama, message: "Maaf, nama menu harus diisi." },
                                method: { value: method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                                pranala: { value: pranala, message: "Maaf, pranala menu harus diisi." },
                                controllers: { value: controllers, message: "Maaf, controller harus diisi." },
                                actions: { value: actions, message: "Maaf, actions/function harus diisi." },
                                middlewares: { value: middlewares, message: "Maaf, middleware harus diisi." },
                                token: { value: token, message: "Token harus diisi." }
                            };

                            for (const key in fields) {
                                const { value, message, skipIf } = fields[key];
                                if (!value || value === skipIf) {
                                    return showError(message);
                                }
                            }
                        }else{ // untuk menu induk atau menu utama (bukan menu query)
                            const fields = {
                                systems: { value: systems, message: "Maaf, is systems harus dipilih.", skipIf: 'Pilih' },
                                kategori: { value: kategori, message: "Maaf, kategori harus dipilih.", skipIf: 'Pilih' },
                                // number: { value: number, message: "Maaf, urutan menu harus dipilih.", skipIf: 'Pilih' },
                                nama: { value: nama, message: "Maaf, nama menu harus diisi." },
                                icon: { value: icon, message: "Maaf, icon menu harus diisi." },
                                method: { value: method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                                pranala: { value: pranala, message: "Maaf, pranala menu harus diisi." },
                                controllers: { value: controllers, message: "Maaf, controller harus diisi." },
                                actions: { value: actions, message: "Maaf, actions/function harus diisi." },
                                middlewares: { value: middlewares, message: "Maaf, middleware harus diisi." },
                                token: { value: token, message: "Token harus diisi." }
                            };

                            for (const key in fields) {
                                const { value, message, skipIf } = fields[key];
                                if (!value || value === skipIf) {
                                    return showError(message);
                                }
                            }
                        }
                    }
                }else{
                    if(kategori == 'Pilih'){
                        return showError("Maaf, kategori harus dipilih.");
                    }else{
                        if(kategori == 1){ // pembuatan menu frontend
                            const fields = {
                                kategori: { value: kategori, message: "Maaf, kategori harus dipilih.", skipIf: 'Pilih' },
                                induk: { value: induk, message: "Maaf, induk menu harus dipilih.", skipIf: 'Pilih' },
                                parent: { value: parent, message: "Maaf, parent menu harus dipilih.", skipIf: 'Pilih' },
                                nama: { value: nama, message: "Maaf, nama menu harus diisi." },
                                method: { value: method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                                pranala: { value: pranala, message: "Maaf, pranala menu harus diisi." },
                                controllers: { value: controllers, message: "Maaf, controller harus diisi." },
                                actions: { value: actions, message: "Maaf, actions/function harus diisi." },
                                token: { value: token, message: "Token harus diisi." }
                            };

                            for (const key in fields) {
                                const { value, message, skipIf } = fields[key];
                                if (!value || value === skipIf) {
                                    return showError(message);
                                }
                            }
                        }else{ // pembuatan menu backend (parent atau child parent)
                            if(child === 'Pilih' || child == null || child === undefined){ // mau di buat menu parent
                                const fields = {
                                    kategori: { value: kategori, message: "Maaf, kategori harus dipilih.", skipIf: 'Pilih' },
                                    induk: { value: induk, message: "Maaf, induk menu harus dipilih.", skipIf: 'Pilih' },
                                    // parent: { value: parent, message: "Maaf, parent menu harus dipilih.", skipIf: 'Pilih' },
                                    nama: { value: nama, message: "Maaf, nama menu harus diisi." },
                                    icon: { value: icon, message: "Maaf, icon menu harus diisi." },
                                    method: { value: method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                                    pranala: { value: pranala, message: "Maaf, pranala menu harus diisi." },
                                    controllers: { value: controllers, message: "Maaf, controller harus diisi." },
                                    actions: { value: actions, message: "Maaf, actions/function harus diisi." },
                                    middlewares: { value: middlewares, message: "Maaf, middleware harus diisi." },
                                    token: { value: token, message: "Token harus diisi." }
                                };

                                for (const key in fields) {
                                    const { value, message, skipIf } = fields[key];
                                    if (!value || value === skipIf) {
                                        return showError(message);
                                    }
                                }
                            }else{ // mau di buat anak menu (child parent)
                                const fields = {
                                    kategori: { value: kategori, message: "Maaf, kategori harus dipilih.", skipIf: 'Pilih' },
                                    induk: { value: induk, message: "Maaf, induk menu harus dipilih.", skipIf: 'Pilih' },
                                    parent: { value: parent, message: "Maaf, parent menu harus dipilih.", skipIf: 'Pilih' },
                                    nama: { value: nama, message: "Maaf, nama menu harus diisi." },
                                    icon: { value: icon, message: "Maaf, icon menu harus diisi." },
                                    method: { value: method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                                    pranala: { value: pranala, message: "Maaf, pranala menu harus diisi." },
                                    controllers: { value: controllers, message: "Maaf, controller harus diisi." },
                                    actions: { value: actions, message: "Maaf, actions/function harus diisi." },
                                    middlewares: { value: middlewares, message: "Maaf, middleware harus diisi." },
                                    token: { value: token, message: "Token harus diisi." }
                                };

                                for (const key in fields) {
                                    const { value, message, skipIf } = fields[key];
                                    if (!value || value === skipIf) {
                                        return showError(message);
                                    }
                                }
                            }
                        }
                    }
                }

            try {
                hideModal("tambahMenu");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('8d9e26a0-367f-47f1-8b53-423f43d0042e') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    // Jangan set Content-Type saat pakai FormData
                    // CSRF token sudah ada di formData
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, kode satker sudah tersedia.", "error");
                    showModal("tambahMenu");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader(); // sembunyikan loader jika ada
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

    Page.Batal = function()
    {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahMenu').modal('hide');
                $('#detailMenu').modal('hide');
                $('#editMenu').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

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
                url: "{{ url('9bbc379d-cd7a-4831-816a-676a17987aa8') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editMenu').modal('show');
                    $('#edit_public').attr('value', response.data[0].public_id);
                    if (response.data[0].is_systems == 1) {
                        $('#edit_id_checkbox').prop('checked', true);
                        $('#edit_class_induk').hide();
                        $('#edit_class_parent').hide();
                        $('#edit_class_subparent').hide();
                        $('#edit_class_number').hide();
                        $('#edit_class_icon').hide();
                        if(response.data[0].is_systems == 1){
                            document.getElementById('edit_id_systems').value = response.data[0].is_systems;
                        }else if(response.data[0].is_systems == 0){
                            document.getElementById('edit_id_systems').value = response.data[0].is_systems;
                        }
                        if(response.data[0].kategori == 1){
                            document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                        }else if(response.data[0].kategori == 2){
                            document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                        }
                        $('#edit_nama_menu').attr('value', response.data[0].nama);
                        if(response.data[0].method == 1){
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }else if(response.data[0].method == 2){
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }else if(response.data[0].method == 3){
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }else{
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }
                        $('#edit_uri_pranala').attr('value', response.data[0].uri);
                        $('#edit_controller').attr('value', response.data[0].controller);
                        $('#edit_action').attr('value', response.data[0].action);
                        if(response.data[0].name == null || response.data[0].name == ''){
                            $('#edit_class_alias').hide();
                        }else{
                            $('#edit_class_alias').show();
                        }
                        $('#edit_middleware').attr('value', response.data[0].middleware);
                        if(response.data[0].is_trash == 1){
                            document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                        }else if(response.data[0].is_trash == 2){
                            document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                        }
                    }else if(response.data[0].is_systems == 0 && response.data[0].id_parent != 0){
                        if (!response.data[0].id_parent_child) {
                            $('#edit_id_checkbox').prop('checked', false);
                            $('#edit_class_systems').hide();
                            $('#edit_class_number').hide();
                            $('#edit_class_alias').hide();
                            if(response.data[0].kategori == 1){
                                document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                            }else if(response.data[0].kategori == 2){
                                document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                            }
                            $.ajax({
                                url: "{{ url('c3986aae-acf8-4300-8415-a5c321ff23f2') }}",
                                type: 'GET',
                                dataType: 'json',
                                success: function(resp){
                                    var sel = document.getElementById("edit_id_induk");

                                    sel.innerHTML = "";

                                    var defaultOption = document.createElement("option");
                                    defaultOption.value = "Pilih";
                                    defaultOption.text = "Pilih";
                                    sel.add(defaultOption);

                                    for (var i = 0; i < resp.data.length; i++) {
                                        var opt = document.createElement("option");
                                        opt.value = resp.data[i].id;
                                        opt.text = resp.data[i].nama;
                                        sel.add(opt);
                                        if (String(opt.value) === String(response.data3)) {
                                            opt.selected = true;
                                        }
                                    }
                                }
                            });
                            Edit_ParentMenu(response.data[0].id_parent, response.data[0].id);
                            $('#edit_nama_menu').attr('value', response.data[0].nama);
                            $('#edit_icon_menu').attr('value', response.data[0].icon);
                            if(response.data[0].icon_parent !== '' && response.data[0].icon_parent !== null){
                                $('#edit_class_icon_child').show();
                                $('#edit_icon_menu_child').attr('value', response.data[0].icon_parent);
                            }else{
                                $('#edit_class_icon_child').hide();
                                $('#edit_icon_menu_child').attr('value', response.data[0].icon_parent);
                            }
                            if(response.data[0].method == 1){
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }else if(response.data[0].method == 2){
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }else if(response.data[0].method == 3){
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }else{
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }
                            $('#edit_uri_pranala').attr('value', response.data[0].uri);
                            $('#edit_controller').attr('value', response.data[0].controller);
                            $('#edit_action').attr('value', response.data[0].action);
                            $('#edit_middleware').attr('value', response.data[0].middleware);
                            if(response.data[0].is_trash == 1){
                                document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                            }else if(response.data[0].is_trash == 2){
                                document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                            }
                        } else {
                            $('#edit_id_checkbox').prop('checked', false);
                            $('#edit_class_systems').hide();
                            $('#edit_class_number').hide();
                            $('#edit_class_alias').hide();
                            if(response.data[0].kategori == 1){
                                document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                            }else if(response.data[0].kategori == 2){
                                document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                            }
                            $.ajax({
                                url: "{{ url('c3986aae-acf8-4300-8415-a5c321ff23f2') }}",
                                type: 'GET',
                                dataType: 'json',
                                success: function(resp){
                                    var sel = document.getElementById("edit_id_induk");

                                    sel.innerHTML = "";

                                    var defaultOption = document.createElement("option");
                                    defaultOption.value = "Pilih";
                                    defaultOption.text = "Pilih";
                                    sel.add(defaultOption);
                                    
                                    for (var i = 0; i < resp.data.length; i++) {
                                        var opt = document.createElement("option");
                                        opt.value = resp.data[i].id;
                                        opt.text = resp.data[i].nama;
                                        sel.add(opt);
                                        if (String(opt.value) === String(response.id_)) {
                                            opt.selected = true;
                                        }
                                    }
                                }
                            });
                            Edit_ParentMenu(response.id_, response.data[0].id_parent);
                            Edit_ChildParent(response.data[0].id_parent_child, response.data[0].id);
                            $('#edit_nama_menu').attr('value', response.data[0].nama);
                            $('#edit_icon_menu').attr('value', response.data[0].icon);
                            if(response.data[0].icon_parent !== '' && response.data[0].icon_parent !== null){
                                $('#edit_class_icon_child').show();
                                $('#edit_icon_menu_child').attr('value', response.data[0].icon_parent);
                            }else{
                                $('#edit_class_icon_child').hide();
                                $('#edit_icon_menu_child').attr('value', response.data[0].icon_parent);
                            }
                            if(response.data[0].method == 1){
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }else if(response.data[0].method == 2){
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }else if(response.data[0].method == 3){
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }else{
                                document.getElementById('edit_id_method').value = response.data[0].method;
                            }
                            $('#edit_uri_pranala').attr('value', response.data[0].uri);
                            $('#edit_controller').attr('value', response.data[0].controller);
                            $('#edit_action').attr('value', response.data[0].action);
                            $('#edit_middleware').attr('value', response.data[0].middleware);
                            if(response.data[0].is_trash == 1){
                                document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                            }else if(response.data[0].is_trash == 2){
                                document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                            }
                        }
                    }else if(response.data[0].is_systems == 0){
                        $('#edit_id_checkbox').prop('checked', true);
                        $('#edit_class_induk').hide();
                        $('#edit_class_parent').hide();
                        $('#edit_class_subparent').hide();
                        if(response.data[0].is_systems == 1){
                            document.getElementById('edit_id_systems').value = response.data[0].is_systems;
                        }else if(response.data[0].is_systems == 0){
                            document.getElementById('edit_id_systems').value = response.data[0].is_systems;
                        }
                        if(response.data[0].kategori == 1){
                            document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                        }else if(response.data[0].kategori == 2){
                            document.getElementById('edit_id_kategori').value = response.data[0].kategori;
                        }
                        $.ajax({
                            url: "{{ url('619e12a9-4443-48ea-8c55-c42f223a336c') }}/"+ response.data[0].kategori,
                            type: 'GET',
                            dataType: 'json',
                            success: function(resp){
                                var sel = document.getElementById("edit_id_urutan_menu");

                                sel.innerHTML = "";

                                var defaultOption = document.createElement("option");
                                defaultOption.value = "Pilih";
                                defaultOption.text = "Pilih";
                                sel.add(defaultOption);

                                for (var i = 0; i < resp.data.length; i++) {
                                    var opt = document.createElement("option");
                                    opt.value = resp.data[i].id;
                                    opt.text = resp.data[i].nama;
                                    sel.add(opt);

                                    if (String(opt.value) === String(response.data2)) {
                                        opt.selected = true;
                                    }
                                }
                            }
                        });
                        $('#edit_nama_menu').attr('value', response.data[0].nama);
                        $('#edit_icon_menu').attr('value', response.data[0].icon);
                        if(response.data[0].method == 1){
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }else if(response.data[0].method == 2){
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }else if(response.data[0].method == 3){
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }else{
                            document.getElementById('edit_id_method').value = response.data[0].method;
                        }
                        $('#edit_uri_pranala').attr('value', response.data[0].uri);
                        $('#edit_controller').attr('value', response.data[0].controller);
                        $('#edit_action').attr('value', response.data[0].action);
                        $('#edit_middleware').attr('value', response.data[0].middleware);
                        if(response.data[0].is_trash == 1){
                            document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                        }else if(response.data[0].is_trash == 2){
                            document.getElementById('edit_is_trash').value = response.data[0].is_trash;
                        }
                        $('#edit_class_alias').hide();
                    }
                }
            });
        }
    }

    function isEmpty(value) {
        return (
            value === undefined ||
            value === null ||
            (typeof value === "string" && value.trim().length === 0) ||
            (typeof value === "object" && Object.keys(value).length === 0)
        );
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("edit_form_menu");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                // const isChecked = document.getElementById("edit_id_checkbox").checked;
                // const systems = formData.get("edit_id_systems")?.trim();
                // const kategori = formData.get("edit_id_kategori")?.trim();
                // const induk = formData.get("edit_id_induk")?.trim();
                // const parent = formData.get("edit_id_parent")?.trim();
                // const child = formData.get("edit_id_child")?.trim();
                const e_public = formData.get("edit_public")?.trim();
                const e_number = formData.get("edit_id_urutan_menu")?.trim();
                const e_nama = formData.get("edit_nama_menu")?.trim();
                const e_icon = formData.get("edit_icon_menu")?.trim();
                const e_icon_parent = formData.get("edit_icon_menu_child")?.trim();
                const e_method = formData.get("edit_id_method")?.trim();
                const e_pranala = formData.get("edit_uri_pranala")?.trim();
                const e_controllers = formData.get("edit_controller")?.trim();
                const e_actions = formData.get("edit_action")?.trim();
                const e_routes = formData.get("edit_name_route")?.trim();
                const e_middlewares = formData.get("edit_middleware")?.trim();
                const edit_is_trash = formData.get("edit_is_trash")?.trim();
                const token = formData.get("_token")?.trim();

                if (!isEmpty(e_number)) {
                    const fields = {
                        e_public: { value: e_public, message: "Maaf, id form tidak boleh kosong." },
                        e_number: { value: e_number, message: "Maaf, urutan menu harus dipilih." },
                        e_nama: { value: e_nama, message: "Maaf, nama menu harus diisi." },
                        e_icon: { value: e_icon, message: "Maaf, icon menu harus diisi." },
                        e_method: { value: e_method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                        e_pranala: { value: e_pranala, message: "Maaf, pranala menu harus diisi." },
                        e_controllers: { value: e_controllers, message: "Maaf, controller harus diisi." },
                        e_actions: { value: e_actions, message: "Maaf, actions/function harus diisi." },
                        e_middlewares: { value: e_middlewares, message: "Maaf, middleware harus diisi." },
                        edit_is_trash: { value: edit_is_trash, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                        token: { value: token, message: "Token harus diisi." }
                    };

                    for (const key in fields) {
                        const { value, message, skipIf } = fields[key];
                        if (!value || value === skipIf) {
                            return showError(message);
                        }
                    }
                } else if (!isEmpty(e_icon_parent)) {
                    const fields = {
                        e_public: { value: e_public, message: "Maaf, id form tidak boleh kosong." },
                        e_nama: { value: e_nama, message: "Maaf, nama menu harus diisi." },
                        e_icon: { value: e_icon, message: "Maaf, icon menu harus diisi." },
                        e_icon_parent: { value: e_icon_parent, message: "Maaf, icon menu parent harus diisi." },
                        e_method: { value: e_method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                        e_pranala: { value: e_pranala, message: "Maaf, pranala menu harus diisi." },
                        e_controllers: { value: e_controllers, message: "Maaf, controller harus diisi." },
                        e_actions: { value: e_actions, message: "Maaf, actions/function harus diisi." },
                        e_middlewares: { value: e_middlewares, message: "Maaf, middleware harus diisi." },
                        edit_is_trash: { value: edit_is_trash, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                        token: { value: token, message: "Token harus diisi." }
                    };

                    for (const key in fields) {
                        const { value, message, skipIf } = fields[key];
                        if (!value || value === skipIf) {
                            return showError(message);
                        }
                    }
                } else {
                    const fields = {
                        e_public: { value: e_public, message: "Maaf, id form tidak boleh kosong." },
                        e_nama: { value: e_nama, message: "Maaf, nama menu harus diisi." },
                        e_method: { value: e_method, message: "Maaf, method harus dipilih.", skipIf: 'Pilih' },
                        e_pranala: { value: e_pranala, message: "Maaf, pranala menu harus diisi." },
                        e_controllers: { value: e_controllers, message: "Maaf, controller harus diisi." },
                        e_actions: { value: e_actions, message: "Maaf, actions/function harus diisi." },
                        e_middlewares: { value: e_middlewares, message: "Maaf, middleware harus diisi." },
                        edit_is_trash: { value: edit_is_trash, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                        token: { value: token, message: "Token harus diisi." }
                    };

                    for (const key in fields) {
                        const { value, message, skipIf } = fields[key];
                        if (!value || value === skipIf) {
                            return showError(message);
                        }
                    }
                }

            try {
                hideModal("editMenu");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('e76f3906-0408-4c92-8b45-60c5cf5987e6') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    // Jangan set Content-Type saat pakai FormData
                    // CSRF token sudah ada di formData
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
                hideLoader(); // sembunyikan loader jika ada
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
                url: "{{ url('7cfa1d05-995e-4a3c-b8ed-6bca989247c9') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#detailMenu').modal('show');
                    $('#d_menu').text(response.data[0].nama);
                    $('#d_icon').text(response.data[0].icon);
                    $('#d_ktgr').text(response.data[0].kategoris);
                    $('#d_mtd').text(response.data[0].methods);
                    $('#d_cont').text(response.data[0].controller);
                    $('#d_uri').text(response.data[0].uri);
                    $('#d_is').text(response.data[0].systems);
                    $('#d_stat').text(response.data[0].status);
                }
            });
        }
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
                        url: "{{ url('2bb56ea6-016c-4c8c-81b2-b18e8ff45194') }}",
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

    $(function(){
        $("input[name='nama_menu']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9 ]/g, ''));
        });
        $("input[name='icon_menu']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-= ]/g, ''));
        });
        $("input[name='uri_pranala']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9{}/-]/g, ''));
        });
        $("input[name='controller']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9_]/g, ''));
        });
        $("input[name='action']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9/_-]/g, ''));
        });
        $("input[name='name_route']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.-]/g, ''));
        });
        $("input[name='middleware']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ]/g, ''));
        });
        $("input[name='edit_nama_menu']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9. ]/g, ''));
        });
        $("input[name='edit_icon_menu']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-= ]/g, ''));
        });
        $("input[name='edit_icon_menu_child']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-= ]/g, ''));
        });
        $("input[name='edit_uri_pranala']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9{}/-]/g, ''));
        });
        $("input[name='edit_controller']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9_]/g, ''));
        });
        $("input[name='edit_action']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9/_-]/g, ''));
        });
        $("input[name='edit_name_route']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.-]/g, ''));
        });
        $("input[name='edit_middleware']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ]/g, ''));
        });
    });
</script>