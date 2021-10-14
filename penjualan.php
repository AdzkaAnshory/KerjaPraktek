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
                    <li><a href="">Data Penjualan</a></li>
                </ul>
                <h4>Data Penjualan</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row row-stat">
            <div class="col-md-12">
                <button id="addPenjualan" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</button>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12">
                <table id="TableMain" class="table table-striped">
                    <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="150px">Invoice</th>
                        <th width="120px">Pembeli</th>
                        <th>Pembayaran</th>
                        <th>Qty</th>
                        <th>Total Harga</th>
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
<div class="modal fade" id="penjualanModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <form id="form" method="post">
                    <div class="form-group">
                        <label for="nama">Nama Penjualan</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input class="form-control" id="nama" name="nama" placeholder="Nama Penjualan">
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

<!--//DETAIL MODAL-->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="detailModalTitle">Detail Pembelian</h4>
            </div>
            <div class="modal-body">
                <table id="TableDetail" class="table table-striped">
                    <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="150px">Nama Barang</th>
                        <th width="120px">Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Diskon</th>
                        <th>Harga Total</th>
                    </tr>
                    </thead>
                    <tbody id="bodytable">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-8">
                        <div id="statusDetail" style="padding-top: 10px;text-align: left"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--//RETUR MODAL-->
<div class="modal fade" id="returModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Retur</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="hp">No. Invoice</label>
                    <div class="input-group mb15">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">INV-</span>
                            <input type="text" class="form-control" placeholder="8123456789" id="nomorInvoice" name="nomorInvoice" aria-describedby="basic-addon1">
                        </div>
                        <span class="input-group-btn">
                            <button type="button" id="cariInvoiceBtn" class="btn btn-default">Cari</button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Barang">Barang</label>
                    <select class="form-control" id="selectBarang" name="selectBarang">
                        <option value="">Pilih Barang</option>
                    </select>
                </div>

                <div class="form-group">
                    <button id="returBtn" class="btn btn-primary pull-right">Retur</button>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-8">
                        <div id="statusRetur" style="padding-top: 10px;text-align: left"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>

<script>
    var jsonPenjualan ="";

    var dataTable = $("#TableMain").DataTable({
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": "no-sort"
        } ],
        "order": [[ 6, 'desc' ]]
    });
    dataTable.on( 'order.dt search.dt', function () {
        dataTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = "<span style='display:block' class='text-center'>"+(i+1)+"</span>";
        } );
    } ).draw();

    var dataDetailTable = $("#TableDetail").DataTable({
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": "no-sort"
        } ],
        // "order": [[ 1, 'asc' ]]
    });
    dataDetailTable.on( 'order.dt search.dt', function () {
        dataDetailTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = "<span style='display:block' class='text-center'>"+(i+1)+"</span>";
        } );
    } ).draw();

    loadData();

    function loadData() {
        $.ajax({
            url: "action/penjualan_aksi.php?load",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                jsonPenjualan = v.data;
                for (i=0; i < v.data.length; i++) {
                    dataTable.row.add( [
                        "",
                        jsonPenjualan[i].invoice,
                        jsonPenjualan[i].pelanggan,
                        jsonPenjualan[i].metode,
                        jsonPenjualan[i].total,
                        jsonPenjualan[i].harga,
                        jsonPenjualan[i].date_add,
                        ' <button onclick="loadDetailBelanja('+i+')" title="Detail" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>'
                    ] ).draw( false );
                }
            }
        })
    }

    $("#addPenjualan").on("click", function () {
        addPenjualan()
    })

    function addPenjualan() {
        $("#penjualanModal").modal("show");
        $("#titleModal").html("Tambah Penjualan");
        $("#id").val("");
        $("#nama").val("");
        $("#email").val("");
        $("#hp").val("");
        $("#alamat").val("");
        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Tambah");
    }

    $("#form").on("submit", function (e) {
        e.preventDefault();
        var url = "action/penjualan_aksi.php?tambah";
        var msg = "Penjualan Berhasil di Tambah";


        if ($("#id").val() != "") {
            url = "action/penjualan_aksi.php?ubah";
            msg = "Berhasil mengubah data Penjualan";
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
                    $("#penjualanModal").modal("hide");

                    $.gritter.add({
                        title: 'Success!',
                        text: msg,
                        class_name: 'growl-success',
                        image: 'images/screen.png',
                        sticky: false,
                        time: ''
                    });

                    jsonPenjualan = v.data;
                    loadData()
                } else {

                }
            }
        })
    })

    function loadDetailBelanja(i) {
        var id = jsonPenjualan[i].id;
        var url = "action/penjualan_aksi.php?detail";

        $("#detailModal").modal("show");

        $.ajax({
            url: url,
            data: { "id" : id },
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#statusDetail").html("Mohon menunggu...");
            },
            success: function (v) {
                var d = v.data;
                dataDetailTable.clear().draw();
                $("#statusDetail").html("");
                for (i=0; i < d.length; i++) {
                    dataDetailTable.row.add( [
                        "",
                        d[i].barang,
                        d[i].jumlah,
                        d[i].harga,
                        d[i].diskon+"%",
                        d[i].total
                    ] ).draw( false );
                }
            }
        })
    }

    $("#returBuku").on("click", function () {
        returPenjualan()
    })

    function returPenjualan() {
        $("#returModal").modal("show");
    }

    $("#cariInvoiceBtn").on("click", function () {
        $.ajax({
            url: "action/penjualan_aksi.php?cariInv",
            data: { "invoice" : $("#nomorInvoice").val()},
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#statusRetur").html("Mohon menunggu...");
            },
            success: function (v) {
                console.log(v);
                $("#statusRetur").html("");

                var a = "";
                for (var i = 0; i < v.data.length; i++) {
                    a += '<option value="'+v.data[i].id+'#'+v.data[i].id_penjualan+'#'+v.data[i].jumlah+'">'+v.data[i].barang+'</optoin>'
                }

                $("#selectBarang").html(a);
            }
        })
    })

    $("#returBtn").on("click", function () {
        if ($("#selectBarang").val() == "") {
            $("#statusRetur").html("Barang belum dipilih")
            return
        }

        $.ajax({
            url: "action/penjualan_aksi.php?doRetur",
            data: { "content" : $("#selectBarang").val()},
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#statusRetur").html("Mohon menunggu...");
            },
            success: function (v) {
                if (v.status == "1") {
                    $("#returModal").modal("hide");
                    $("#nomorInvoice").val("");
                    $("#selectBarang").html('<option value="">Pilih Barang</option>')
                } else {
                    $("#statusRetur").html(v.msg);
                }
            }
        })
    })
</script>
