<?php include 'header.php'; ?>
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-th-list"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="">Data Sales</a></li>
                </ul>
                <h4>Data Sales</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row row-stat">
            <div class="col-md-12">
                <button id="addSales" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</button>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12">
                <table id="TableMain" class="table table-striped">
                    <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="150px">Nama Sales</th>
                        <th width="120px">Telepon</th>
                        <th>Penerbit</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="bodytable">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div><!-- mainpanel -->

<!--//ADD MODAL-->
<div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <form id="form" method="post">
                    <div class="form-group">
                        <label for="nama">Nama Sales</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input class="form-control" id="nama" name="nama" placeholder="Nama Sales">
                    </div>

                    <div class="form-group">
                        <label for="nama">Penerbit</label>
                        <input class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="hp">No. HP</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">+62</span>
                            <input type="text" class="form-control" placeholder="8123456789" id="hp" name="hp" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-8">
                        <div id="status" style="padding-top: 10px;text-align: left"></div>
                    </div>
                    <div class="col-md-4">
                        <button id="btn-modal" type="submit" class="btn btn-primary"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>

<script>
    var jsonSales ="";

    var dataTable = $("#TableMain").DataTable({
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": "no-sort"
        } ],
        // "order": [[ 1, 'asc' ]]
    });
    dataTable.on( 'order.dt search.dt', function () {
        dataTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = "<span style='display:block' class='text-center'>"+(i+1)+"</span>";
        } );
    } ).draw();

    loadData();

    function loadData() {
        dataTable.clear().draw();
        $.ajax({
            url: "action/sales_aksi.php?load",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                jsonSales = v.data;
                for (i=0; i < v.data.length; i++) {
                    dataTable.row.add( [
                        "",
                        jsonSales[i].nama,
                        jsonSales[i].tlp,
                        jsonSales[i].penerbit,
                        jsonSales[i].email,
                        jsonSales[i].alamat,
                        jsonSales[i].date_add,
                        '&nbsp;<button onclick="ubahSales('+i+')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>'+
                        ' <button onclick="hapusSales('+i+')" title="Hapus halaman" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>'
                    ] ).draw( false );
                }
            }
        })
    }

    $("#addSales").on("click", function () {
        addSales()
    })

    function addSales() {
        $("#salesModal").modal("show");
        $("#titleModal").html("Tambah Sales");
        $("#id").val("");
        $("#nama").val("");
        $("#penerbit").val("");
        $("#email").val("");
        $("#hp").val("");
        $("#alamat").val("");
        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Tambah");
    }

    function ubahSales(i) {
        $("#salesModal").modal("show");
        $("#titleModal").html("Ubah Sales");
        $("#id").val(jsonSales[i].id);
        $("#penerbit").val(jsonSales[i].penerbit);
        $("#nama").val(jsonSales[i].nama);
        $("#email").val(jsonSales[i].email);
        $("#hp").val(jsonSales[i].tlp);
        $("#alamat").val(jsonSales[i].alamat);
        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Ubah");
    }

    $("#form").on("submit", function (e) {
        e.preventDefault();
        var url = "action/sales_aksi.php?tambah";
        var msg = "Sales Berhasil di Tambah";

        if ($("#id").val() != "") {
            url = "action/sales_aksi.php?ubah";
            msg = "Berhasil mengubah data Sales";
        }

        $.ajax({
            url: url,
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#btn-modal").attr("disabled", true);
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                if (v.status == 1) {
                    $("#salesModal").modal("hide");

                    $.gritter.add({
                        title: 'Success!',
                        text: msg,
                        class_name: 'growl-success',
                        image: 'images/screen.png',
                        sticky: false,
                        time: ''
                    });

                    jsonSales = v.data;
                    loadData()
                } else {

                }
            }
        })
    })

    function hapusSales(i) {
        var id = jsonSales[i].id;
        var url = "action/sales_aksi.php?hapus";

        var confrim = confirm(jsonSales[i].nama+", akan dihapus ?");

        if (confrim) {
            $.ajax({
                url: url,
                data: { "id" : id },
                method: "POST",
                dataType: "JSON",
                beforeSend: function (e) {
                    $("#btn-modal").attr("disabled", true);
                    $("#status").html("Mohon menunggu...");
                },
                success: function (v) {
                    if (v.status == 1) {
                        $("#salesModal").modal("hide");

                        $.gritter.add({
                            title: 'Success!',
                            text: "Berhasil menghapus sales",
                            class_name: 'growl-success',
                            image: 'images/screen.png',
                            sticky: false,
                            time: ''
                        });

                        jsonSales = v.data;
                        loadData()
                    } else {

                    }
                }
            })
        }
    }


</script>
