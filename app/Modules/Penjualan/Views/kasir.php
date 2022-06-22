<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<?php

use App\Libraries\Settings;

$setting = new Settings();
$appname = $setting->info['app_name'];
?>
<template>
    <v-row>
        <v-col cols="12" md="7">
            <v-card>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <h1 class="mb-1">KASIR</h1>
                            <h4 class="font-weight-regular"><?= lang('App.cashier'); ?>: <?= session()->get('nama') ?></h4>
                        </v-col>

                    </v-row>
                </v-card-text>
                <v-data-table height="300" :headers="tbkeranjang" :fixed-header="true" :items="keranjang" item-key="id_keranjang" :loading="loading" loading-text="Memuat data, silahkan tunggu...">
                    <template v-slot:item="{ item }">
                        <tr>
                            <td width="60">{{item.id_keranjang}}</td>
                            <td>{{item.nama_produk}}</td>
                            <td width="150">
                                <v-text-field v-model="item.qty" type="number" single-line append-icon="mdi-content-save" @click:append="setJumlah(item)"></v-text-field>
                                <!-- <v-edit-dialog :return-value.sync="item.qty" @save="setJumlah(item)" @cancel="" @open="" @close="">
                                    {{item.qty}}
                                    <template v-slot:input>
                                        <v-text-field v-model="item.qty" type="number" single-line></v-text-field>
                                    </template>
                                </v-edit-dialog> -->
                            </td>
                            <td>Rp.{{item.total}}</td>
                            <td>
                                <v-btn icon @click="hapusItem(item)">
                                    <v-icon color="red">
                                        mdi-delete
                                    </v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                    <template slot="footer.prepend">
                        <h1 style="font-size: 250%;">Rp.{{ sumTotal('total') }}</h1>
                        <div style="display: none;">{{sumTotalHPP('hpp')}}</div>
                    </template>
                </v-data-table>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-btn v-on:click="bayar = 0">0</v-btn>
                            <v-btn v-on:click="bayar += 500">500</v-btn>
                            <v-btn v-on:click="bayar += 1000">1k</v-btn>
                            <v-btn v-on:click="bayar += 2000">2k</v-btn>
                            <v-btn v-on:click="bayar += 5000">5k</v-btn>
                            <v-btn v-on:click="bayar += 10000">10k</v-btn>
                            <v-btn v-on:click="bayar += 20000">20k</v-btn>
                            <v-btn v-on:click="bayar += 50000">50k</v-btn>
                            <v-btn v-on:click="bayar += 100000">100k</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="error" large class="mt-5" @click="modalDelete = true" :disabled="keranjang == '' ? true:false">Reset <v-icon>mdi-cart</v-icon>
                            </v-btn>
                        </v-col>
                        <v-col>
                            <v-text-field label="Bayar" v-model="bayar" type="number" :rules="[rules.zero, rules.required, rules.number]" outlined dense></v-text-field>

                            <v-text-field label="Kembali" v-model="kembali" readonly outlined dense></v-text-field>

                            <v-btn large color="primary" @click="saveNota" :loading="loading2" :disabled="keranjang == '' ? true:false">
                                <v-icon>mdi-cart</v-icon> <?= lang('App.pay') ?>
                            </v-btn>


                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col>

        <v-col cols="12" md="5">
            <v-card height="100%">
                <v-card-text>
                    <v-text-field v-model="pencarian" prepend-inner-icon="mdi-magnify" label="<?= lang('App.searchProduct') ?>" outlined dense hide-details clearable autofocus></v-text-field>
                </v-card-text>
                <v-data-table height="500" :headers="tbproduk" :items="produk" :items-per-page="10" :loading="loading" :search="pencarian" loading-text="Sedang memuat... Harap tunggu">
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>
                                <v-avatar size="50px" rounded>
                                    <img v-bind:src="'<?= base_url() ?>' + '/' + item.media_path" v-if="item.media_path != null" />
                                    <img src="<?= base_url('images/no_image.jpg') ?>" v-else />
                                </v-avatar>
                            </td>
                            <td width="150px">{{item.nama_produk}} Rp.{{item.harga_jual}}</td>
                            <td>{{item.barcode}}</td>
                            <td align="center">
                                <v-btn small color="primary" @click="saveKeranjang(item)" :disabled="item.stok == 0">
                                    <v-icon>mdi-cart</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<!-- Modal Reset Keranjang -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalDelete" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> Konfirmasi
                </v-card-title>
                <v-card-text>
                    <div class="py-3">
                        <h3><?= lang('App.confirmResetCart') ?></h3>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large text @click="modalDelete = false"><?= lang('App.no') ?></v-btn>
                    <v-btn large color="error" dark @click="resetKeranjang" :loading="loading2" elevation="1">
                        <v-icon>mdi-delete</v-icon> <?= lang('App.yes') ?>, <?= lang('App.delete') ?>
                    </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Reset -->

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
                        No: {{nota.no_nota}}<br />
                        Tgl: <?= date('d/m/Y H:i:s') ?><br />
                        Kasir: <?= session()->get('user') ?>
                    </div>
                    <v-divider></v-divider>
                    <div v-for="item in itemnota" :key="item.id_itemnota">
                        {{item.nama_produk}}<br />
                        {{item.qty}} {{item.satuan}} x {{item.harga_jual}}
                        <span class="float-right">{{item.jumlah}}</span>
                    </div>
                    <v-divider></v-divider>
                    <div>
                        Total: <span class="float-right">{{nota.total}}</span><br />
                        Bayar: <span class="float-right">{{nota.bayar}}</span><br />
                        Kembali: <span class="float-right">{{nota.kembali}}</span><br />
                    </div>
                    <v-divider></v-divider>
                    <div class="mt-2 mb-0 text-center" style="font-size: 11px;line-height: normal;">Terima kasih atas kunjungannya di Angkringan 69 Pogog Road, semoga puas dengan pelayanan yang telah kami berikan.</div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Nota -->

<v-dialog v-model="loading4" hide-overlay persistent width="300">
    <v-card>
        <v-card-text class="pt-3">
            Memuat, silahkan tunggu...
            <v-progress-linear indeterminate color="primary" class="mb-0"></v-progress-linear>
        </v-card-text>
    </v-card>
</v-dialog>
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
        //alert("Print Bluetooth Success");
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
    }

    dataVue = {
        ...dataVue,
        pencarian: "",
        produk: [],
        id_produk: "",
        qty: 0,
        hpp: 0,
        total: 0,
        bayar: 0,
        kembali: 0,
        toko: [],
        id_keranjang: "",
        keranjang: [],
        itemkeranjang: [],
        idnota: "",
        nota: [],
        itemnota: [],
        tbkeranjang: [{
            text: '#',
            value: 'id_keranjang'
        }, {
            text: 'Nama',
            value: 'nama_produk'
        }, {
            text: 'Qty',
            value: 'qty'
        }, {
            text: 'Total',
            value: 'total'
        }, {
            text: '',
            value: 'actions'
        }, ],
        tbproduk: [{
            text: '#',
            value: 'media_path'
        }, {
            text: 'Nama',
            value: 'nama_produk'
        }, {
            text: 'Barcode',
            value: 'barcode'
        }, {
            text: '',
            value: 'action'
        }, ],
        modalAdd: false,
        modalEdit: false,
        modalShow: false,
        modalDelete: false,
        modalNota: false,
        modalMember: false,
        dataMember: [],
        id_member: "1",
    }

    createdVue = function() {
        this.getProduk();
        setTimeout(() => this.getKeranjang(), 1000);
        this.getMember();
        this.getNota();
    }

    computedVue = {
        ...computedVue,

    }

    watchVue = {
        ...watchVue,
        bayar: function() {
            this.kembali = this.bayar - this.total;
        },
    }

    mountedVue = function() {

    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function() {
            this.modalAdd = true;
        },

        modalAddClose: function() {
            this.modalAdd = false;
            this.$refs.form.resetValidation();
        },

        // Get Produk
        getProduk: function() {
            this.loading4 = true;
            axios.get(`<?= base_url(); ?>/api/produk/kasir`, options)
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.produk = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.produk = data.data;
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

        // Get Keranjang
        getKeranjang: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>/api/keranjang`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.keranjang = data.data;
                        const itemkeranjang = this.keranjang.map((row) => (
                            [row.id_produk, row.harga_jual, row.stok, row.qty, row.satuan, row.harga_beli]
                        ));
                        this.itemkeranjang = itemkeranjang;
                        //console.log(this.itemkeranjang);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.keranjang = data.data;
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

        // Save Keranjang
        saveKeranjang: function(item) {
            this.loading4 = true;
            axios.post(`<?= base_url(); ?>/api/keranjang/save`, {
                    id_produk: item.id_produk,
                    harga_jual: item.harga_jual,
                    stok: item.stok,
                    qty: 1,
                    id_member: this.id_member,
                }, options)
                .then(res => {
                    // handle success
                    this.loading4 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeranjang();
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

        // Reset Keranjang
        resetKeranjang: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>/api/keranjang/reset`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeranjang();
                        this.bayar = 0;
                        this.modalDelete = false;
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

        // Delete Item Keranjang
        hapusItem: function(item) {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>/api/keranjang/delete/${item.id_keranjang}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeranjang();
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

        sumTotal(key) {
            // sum data in give key (property)
            let total = 0
            const sum = this.keranjang.reduce((accumulator, currentValue) => {
                return (total += +currentValue[key])
            }, 0)
            this.total = sum;
            return sum
        },

        sumTotalHPP(key) {
            // sum data in give key (property)
            let hpp = 0
            const sum = this.keranjang.reduce((accumulator, currentValue) => {
                return (hpp += +currentValue[key])
            }, 0)
            this.hpp = sum;
            console.log(this.hpp);
            return sum
        },

        // Set Jumlah Item
        setJumlah: function(item) {
            this.loading = true;
            this.id_keranjang = item.id_keranjang;
            this.qty = item.qty;
            this.id_produk = item.id_produk;
            axios.put(`<?= base_url(); ?>/api/keranjang/update/${this.id_keranjang}`, {
                    id_produk: this.id_produk,
                    qty: this.qty,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeranjang();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeranjang();
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

        // Save Nota
        saveNota: function(item) {
            this.loading2 = true;
            const data = this.itemkeranjang;
            //console.log(data);
            axios.post(`<?= base_url(); ?>/api/nota/save`, {
                    data: data,
                    bayar: this.bayar,
                    hpp: this.hpp,
                    total: this.total,
                    kembali: this.kembali,
                    id_member: this.id_member,
                }, options)
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.resetKeranjang();
                        this.idnota = data.data.idnota;
                        this.getItemNota();
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

        //Get Nota
        getNota: function() {
            this.loading3 = true;
            axios.get(`<?= base_url(); ?>/api/nota/${this.idnota}`, options)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.nota = data.data;
                        this.getToko();
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

        //Get Item Nota
        getItemNota: function() {
            this.loading3 = true;
            axios.get(`<?= base_url(); ?>/api/cetaknota/${this.idnota}`, options)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.itemnota = data.data;
                        this.modalNota = true;
                        this.getNota();
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

        // Get User
        getMember: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>/api/member', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataMember = data.data;
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
    }
</script>
<?php $this->endSection("js") ?>