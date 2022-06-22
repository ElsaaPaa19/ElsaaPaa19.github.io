<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<?php

use App\Libraries\Settings;

$setting = new Settings();
$appname = $setting->info['app_name'];
?>
<template>
    <v-alert type="info" icon="mdi-cart" prominent text dense>
        <h3 class="text-truncate mb-2">Detail Transaksi</h3>
        <h4 class="font-weight-regular">Hari Ini: <?= $countTrxHariini; ?>, Total: Rp.<?= $totalTrxHariini ?? "0"; ?></h4>
        <h4 class="font-weight-regular">Kemarin: <?= $countTrxHarikemarin; ?>, Total: Rp.<?= $totalTrxHarikemarin ?? "0"; ?></h4>
    </v-alert>

    <!-- Table List Nota -->
    <v-card outlined elevation="1">
        <v-card-title>
            <h2>Transaksi Penjualan</h2>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line hide-details>
            </v-text-field>
        </v-card-title>

        <v-data-table :headers="headers" :items="dataNota" :items-per-page="10" :loading="loading" :search="search" class="elevation-1" loading-text="Sedang memuat... Harap tunggu" dense>
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.no_nota}}</td>
                    <td>{{item.created_at}}</td>
                    <td>{{item.jumlah}}</td>
                    <td>{{item.total}}</td>
                    <td>{{item.bayar}}</td>
                    <td>{{item.kembali}}</td>
                    <td>
                        <v-btn icon color="primary" class="mr-3" @click="showNota(item)">
                            <v-icon>mdi-receipt</v-icon>
                        </v-btn>
                        <v-btn icon color="red" @click="deleteItem(item)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
    <!-- End Table List Nota -->
</template>

<!-- Modal Nota -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalNota" persistent max-width="300px">
            <v-card class="pa-2">
                <v-card-title class="text-h5">
                    <?= lang('App.receipt') ?>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalNota = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <div class="mb-2 text-center" style="line-height: normal;">
                        <h4 class="text-display1">{{toko.nama_toko}}</h4>
                        <span class="text-display2">{{toko.alamat_toko}}
                            WA: {{toko.telp}}<br />
                    </div>
                    <v-divider></v-divider>
                    <div>
                        No: {{noNota}}<br />
                        Tgl: <?= date('d/m/Y H:i:s') ?><br />
                        Kasir: <?= session()->get('user') ?>
                    </div>
                    <v-divider></v-divider>
                    <div v-for="item in itemNota" :key="item.id_itemnota">
                        {{item.nama_produk}}<br />
                        {{item.qty}} {{item.satuan}} x {{item.harga_jual}}
                        <span class="float-right">{{item.jumlah}}</span>
                    </div>
                    <v-divider></v-divider>
                    <div>
                        Total: <span class="float-right">{{total}}</span><br />
                        Bayar: <span class="float-right">{{bayar}}</span><br />
                        Kembali: <span class="float-right">{{kembali}}</span><br />
                    </div>
                    <v-divider></v-divider>
                    <div class="mt-2 mb-0 text-center" style="font-size: 11px;line-height: normal;">Terima kasih atas kunjungannya di Angkringan 69 Pogog Road, semoga puas dengan pelayanan yang telah kami berikan.</div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Nota -->

<!-- Modal Delete -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalDelete" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> Konfirmasi Hapus
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="mt-5 py-4">
                        <h2 class="font-weight-regular">Apakah anda yakin ingin menghapus?</h2>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="modalDelete = false" large><?= lang('App.close'); ?></v-btn>
                    <v-btn color="red" dark @click="deleteNota" :loading="loading" elevation="1" large><?= lang('App.delete'); ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->

<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    //RawBT
    function pc_print(data) {
        var socket = new WebSocket("ws://127.0.0.1:40213/");
        socket.bufferType = "arraybuffer";
        socket.onerror = function(error) {
            alert("Error! RawBT Websocket Server for PC not found");
        };
        socket.onopen = function() {
            socket.send(data);
            socket.close(1000, "Work complete");
        };
    }

    function android_print(data) {
        window.location.href = data;
    }

    function ajax_print(url, btn) {
        $.get(url, function(data) {
            var ua = navigator.userAgent.toLowerCase();
            var isAndroid = ua.indexOf("android") > -1;
            if (isAndroid) {
                android_print(data);
            } else {
                pc_print(data);
            }
        });
    }

    const token = JSON.parse(localStorage.getItem('access_token'));
    const options = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };

    dataVue = {
        ...dataVue,
        search: "",
        headers: [{
                text: 'Nomor Nota',
                value: 'no_nota'
            },
            {
                text: 'Tanggal',
                value: 'created_at'
            },
            {
                text: 'Jumlah',
                value: 'jumlah'
            },
            {
                text: 'Total',
                value: 'total'
            },
            {
                text: 'Bayar',
                value: 'bayar'
            },
            {
                text: 'Kembali',
                value: 'kembali'
            },
            {
                text: '<?= lang('App.action') ?>',
                value: 'actions',
                sortable: false
            },
        ],
        toko: [],
        dataNota: [],
        nota: [],
        itemNota: [],
        noNota: "",
        idNota: "",
        jumlah: "",
        total: "",
        bayar: "",
        kembali: "",
        modalAdd: false,
        modalEdit: false,
        modalNota: false,
        modalDelete: false,
    }
    createdVue = function() {
        setTimeout(() => this.getNota(), 500);
    }

    methodsVue = {
        ...methodsVue,
        // Get Nota
        getNota: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>/api/nota', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataNota = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        //Get Toko
        getToko: function() {
            axios.get(`<?= base_url(); ?>/api/toko`, options)
                .then(res => {
                    // handle success
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.toko = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        //Show Nota
        showNota: function(item) {
            this.loading3 = true;
            this.modalNota = true;
            this.idNota = item.id_nota;
            this.noNota = item.no_nota;
            this.jumlah = item.jumlah;
            this.total = item.total;
            this.bayar = item.bayar;
            this.kembali = item.kembali;
            this.getToko();
            this.getItemNota();
        },

        //Get Item Nota
        getItemNota: function() {
            this.loading3 = true;
            axios.get(`<?= base_url(); ?>/api/cetaknota/${this.idNota}`, options)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.itemNota = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Item Delete
        deleteItem: function(item) {
            this.modalDelete = true;
            this.idNota = item.id_nota;
        },

        // Delete
        deleteNota: function() {
            this.loading = true;
            axios.delete(`<?= base_url() ?>/api/nota/delete/${this.idNota}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getNota();
                        this.modalDelete = false;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalDelete = true;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },
    }
</script>
<?php $this->endSection("js") ?>