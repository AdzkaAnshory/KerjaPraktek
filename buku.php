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
                    <li><a href="">Data Buku</a></li>
                </ul>
                <h4>Data Buku</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row row-stat">
            <div class="col-md-12">
                <button id="addBuku" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</button>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12">
                <table id="TableMain" class="table table-striped">
                    <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="120px">Kode</th>
                        <th width="150px">Judul</th>
                        <th>Penerbit</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Gudang</th>
                        <th>Stok</th>
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
<div class="modal fade" id="bukuModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <form id="form" method="post">
                    <div class="form-group">
                        <label for="kode">Kode Buku</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input class="form-control" id="kode" name="kode" placeholder="ISBN 978-602-8519-93-9">
                    </div>
                    <div class="form-group">
                        <label for="nama">Judul</label>
                        <input class="form-control" id="nama" name="nama" placeholder="Nama Buku">
                    </div>
                    <div class="form-group">
                        <label for="sales">Distributor</label>
                        <select class="form-control" id="sales" name="sales">
                            <option value="" selected>Pilih Sales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gudang">Gudang</label>
                        <select class="form-control" id="gudang" name="gudang">
                            <option value="" selected>Pilih Gudang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="penyusun">Penyusun</label>
                        <input type="text" class="form-control" id="penyusun" name="penyusun" placeholder="Penyusun">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="harga_beli" name="harga_beli" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="harga_jual" name="harga_jual" aria-describedby="basic-addon1">
                        </div>
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
    var jsonBuku ="";
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
    loadSalesDanGudang();

    function loadData() {
        dataTable.clear().draw();
        $.ajax({
            url: "action/buku_aksi.php?load",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                jsonBuku = v.data;
                for (i=0; i < v.data.length; i++) {
                    dataTable.row.add( [
                        "",
                        jsonBuku[i].kode,
                        jsonBuku[i].judul,
                        jsonBuku[i].penerbit,
                        jsonBuku[i].kategori,
                        jsonBuku[i].harga_beli,
                        jsonBuku[i].harga_jual,
                        jsonBuku[i].nama_gudang,
                        jsonBuku[i].stok,
                        ' <button onclick="ubahBuku('+i+')" class="btn btn-success btn-sm" style="margin: 2px"><i class="fa fa-pencil"></i></button>'+
                        ' <button onclick="hapusBuku('+i+')" title="Hapus halaman" class="btn btn-danger btn-sm" style="margin: 2px"><i class="fa fa-trash-o"></i></button>'
                    ] ).draw( false );
                }
            }
        })
    }

    function loadSalesDanGudang() {
        $.ajax({
            url: "action/buku_aksi.php?load_sales_gudang",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (json) {
                var sales = json.sales;
                var gudang = json.gudang;

                //LOAD SALES
                var s = '<option value="" selected>Pilih Sales</option>';
                for (i=0; i < sales.length; i++) {
                    s += '<option value="'+sales[i].id+'">'+sales[i].nama+'</option>'
                }
                $("#sales").html(s);

                //LOAD GUDANG
                var g = '<option value="" selected>Pilih Gudang</option>';
                for (j=0; j < gudang.length; j++) {
                    g += '<option value="'+gudang[j].id+'">'+gudang[j].nama+'</option>'
                }
                $("#gudang").html(g);
            }
        })
    }

    $("#addBuku").on("click", function () {
        addBuku()
    })

    function addBuku() {
        $("#bukuModal").modal("show");
        $("#titleModal").html("Tambah Buku");
        $("#id").val("");
        $("#nama").val("");
        $("#email").val("");
        $("#stok").val("");
        $("#hp").val("");
        $("#alamat").val("");
        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Tambah");
    }

    function ubahBuku(i) {
        $("#bukuModal").modal("show");
        $("#titleModal").html("Ubah Buku");
        $("#id").val(jsonBuku[i].id);
        $("#kode").val(jsonBuku[i].kode);
        $("#nama").val(jsonBuku[i].judul);
        $("#penyusun").val(jsonBuku[i].penyusun);
        $("#kategori").val(jsonBuku[i].kategori);
        $("#stok").val(jsonBuku[i].stok);
        $("#harga_jual").val(jsonBuku[i].harga_jual);
        $("#harga_beli").val(jsonBuku[i].harga_beli);
        $("#sales").val(jsonBuku[i].id_sales);
        $("#gudang").val(jsonBuku[i].id_gudang);

        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Ubah");
    }

    $("#form").on("submit", function (e) {
        e.preventDefault();
        var url = "action/buku_aksi.php?tambah";
        var msg = "Buku Berhasil di Tambah";


        if ($("#id").val() != "") {
            url = "action/buku_aksi.php?ubah";
            msg = "Berhasil mengubah data Buku";
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
                    $("#bukuModal").modal("hide");

                    $.gritter.add({
                        title: 'Success!',
                        text: msg,
                        class_name: 'growl-success',
                        image: 'images/screen.png',
                        sticky: false,
                        time: ''
                    });

                    jsonBuku = v.data;
                    loadData()
                } else {

                }
            }
        })
    })

    function hapusBuku(i) {
        var id = jsonBuku[i].id;
        var url = "action/buku_aksi.php?hapus";

        console.log(jsonBuku[i]);

        var confrim = confirm(jsonBuku[i].judul+", akan dihapus ?");

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
                        $("#bukuModal").modal("hide");

                        $.gritter.add({
                            title: 'Success!',
                            text: "Berhasil menghapus buku",
                            class_name: 'growl-success',
                            image: 'images/screen.png',
                            sticky: false,
                            time: ''
                        });

                        jsonBuku = v.data;
                        loadData()
                    } else {

                    }
                }
            })
        }
    }


</script>
