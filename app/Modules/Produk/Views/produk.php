<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>

    <!-- Table Card -->
    <v-card outlined elevation="0">
        <v-card-title>
            <h2>
                <v-icon large>mdi-package</v-icon> Daftar Menu
            </h2>
        </v-card-title>
        <v-toolbar flat>
            <v-btn color="indigo" dark large class="mr-2" href="<?= base_url('produk/baru') ?>" elevation="1">
                <v-icon>mdi-plus</v-icon> <?= lang('App.add') ?>
            </v-btn>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-select v-model="search" label="Kategori" :items="dataKategori" item-text="nama_kategori" item-value="nama_kategori" single-line hide-details style="width: 50px;"></v-select>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line hide-details>
            </v-text-field>
        </v-toolbar>
        <v-data-table v-model="selected" item-key="id_produk" show-select :headers="dataTable" :items="dataProduk" :items-per-page="10" :loading="loading" :search="search" class="elevation-1" loading-text="Sedang memuat... Harap tunggu" dense>
            <template v-slot:item="{ item }">
                <tr>
                    <td>
                        <v-checkbox v-model="selected" :value="item" style="margin:0px;padding:0px" hide-details />
                    </td>
                    <td style="max-width:320px">
                        <a link @click="editItem(item)">
                            <v-list-item class="ma-n3 pa-n3" two-line>
                                <v-list-item-avatar size="50" rounded>
                                    <v-img :src="'<?= base_url() ?>' + '/' + item.media_path" v-if="item.media_path != null"></v-img>
                                    <v-img src="<?= base_url('images/no_image.jpg') ?>" v-else></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <p class="text-subtitle-2 text-underlined primary--text">{{item.nama_produk}}</p>
                                </v-list-item-content>
                            </v-list-item>

                        </a>
                    </td>
                    <td>{{item.barcode}}</td>
                    <td>{{item.nama_kategori}}</td>
                    <td>
                        <v-edit-dialog :return-value.sync="item.harga_beli" @save="" @cancel="getProduk" @open="" @close="getProduk">
                            {{ Ribuan(item.harga_beli) }}
                            <template v-slot:input>
                                <v-text-field v-model="item.harga_beli" type="number" append-icon="mdi-content-save" @click:append="setHargaBeli(item)" single-line single-line></v-text-field>
                            </template>
                        </v-edit-dialog>
                    </td>
                    <td>
                        <v-edit-dialog :return-value.sync="item.harga_jual" @save="" @cancel="getProduk" @open="" @close="getProduk">
                            {{ Ribuan(item.harga_jual) }}
                            <template v-slot:input>
                                <v-text-field v-model="item.harga_jual" type="number" append-icon="mdi-content-save" @click:append="setHargaJual(item)" single-line></v-text-field>
                            </template>
                        </v-edit-dialog>
                    </td>
                    <td>
                        <v-edit-dialog :return-value.sync="item.stok" @save="" @cancel="getProduk" @open="" @close="getProduk">
                            {{item.stok}}
                            <template v-slot:input>
                                <v-text-field v-model="item.stok" type="number" append-icon="mdi-content-save" @click:append="setStok(item)" single-line></v-text-field>
                            </template>
                        </v-edit-dialog>
                    </td>
                    <td>
                        <v-switch v-model="item.active" value="active" false-value="0" true-value="1" color="success" @click="setAktif(item)"></v-switch>
                    </td>
                    <td>
                        <v-menu left bottom min-width="200px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>

                            <v-list dense>
                                <v-list-item @click="editItem(item)">
                                    <v-list-item-icon class="me-3">
                                        <v-icon>mdi-pencil-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Edit</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item @click="deleteItem(item)">
                                    <v-list-item-icon class="me-3">
                                        <v-icon>mdi-delete-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Hapus</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-menu>


                    </td>
                </tr>
            </template>
            <template v-slot:footer.prepend>
                <v-btn color="error" class="me-2" @click="confirmDelete(selected)" v-if="selected != ''" elevation="1">
                    <v-icon>mdi-delete</v-icon> <?= lang('App.delete') ?>
                </v-btn>
            </template>
        </v-data-table>
    </v-card>
    <!-- End Table List -->
</template>

<!-- Modal -->

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
                        <h2 class="font-weight-regular"><?= lang('App.delConfirm') ?></h2>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text large @click="modalDelete = false"><?= lang('App.no') ?></v-btn>
                    <v-btn color="primary" dark large @click="deleteProduk" :loading="loading"><?= lang('App.yes') ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<template>
    <v-row justify="center">
        <v-dialog v-model="modalDeleteMultiple" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> Konfirmasi Hapus
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="mt-5 py-4">
                        <h2 class="font-weight-regular">Apakah anda yakin ingin menghapus semua data?</h2>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="modalDeleteMultiple = false" elevation="0" large>Tutup</v-btn>
                    <v-btn color="red" dark @click="deleteMultiple" :loading="loading" elevation="0" large>Hapus Semua</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->

<template>
    <v-row justify="center">
        <v-dialog v-model="modalBarcode" persistent max-width="300">
            <v-card>
                <v-card-title class="text-h6 mb-3">
                    Jumlah
                </v-card-title>
                <v-card-text>
                    <v-text-field type="number" v-model="jmlBarcode" label="Jumlah" hide-details outlined></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="closeBarcode">
                        Tutup
                    </v-btn>
                    <v-btn color="indigo" text link :href="'<?= base_url('produk/barcode?tipe=JPG&text='); ?>' + barcode + '&jumlah=' + jmlBarcode " target="_blank">
                        Cetak Barcode
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {
            type: contentType
        });
        return blob;
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
        modalAdd: false,
        modalEdit: false,
        modalShow: false,
        modalDelete: false,
        modalDeleteMultiple: false,
        confirmDeleteMultiple: false,
        modalBarcode: false,
        search: "",
        selected: [],
        dataTable: [{
            text: 'Nama Produk',
            value: 'nama_produk'
        }, {
            text: 'BARCODE',
            value: 'barcode'
        }, {
            text: '<?= lang('App.category') ?>',
            value: 'nama_kategori'
        }, {
            text: '<?= lang('App.priceBuy') ?>',
            value: 'harga_beli'
        }, {
            text: '<?= lang('App.priceSell') ?>',
            value: 'harga_jual'
        }, {
            text: '<?= lang('App.stock') ?>',
            value: 'stok'
        }, {
            text: '<?= lang('App.action') ?>',
            value: 'active',
            sortable: false
        }, {
            text: '',
            value: 'sku',
            sortable: false
        }, ],
        dataProduk: [],
        idProduk: "",
        hargaBeli: "",
        hargaJual: "",
        stok: "",
        dataKategori: [],
        barcode: "",
        jmlBarcode: 1,
    }

    createdVue = function() {
        //axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getProduk();
        this.getKategori();
    }

    var watchVue = {

    }

    methodsVue = {
        ...methodsVue,
        // Get Kategori
        getKategori: function() {
            this.loading1 = true;
            axios.get('<?= base_url(); ?>/api/kategori', options)
                .then(res => {
                    // handle success
                    this.loading1 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.dataKategori = data.data;
                        console.log(this.dataKategori);
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

        // Get Produk
        getProduk: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>/api/produk', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataProduk = data.data;
                        //console.log(this.dataProduk);
                        this.selected = [];
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

        // Get Item Edit Product
        editItem: function(item) {
            setTimeout(() => window.location.href = `<?= base_url() ?>/produk/${item.id_produk}/edit`, 100);
        },

        // Get Item Delete Product
        deleteItem: function(item) {
            this.modalDelete = true;
            this.idProduk = item.id_produk;
            this.namaProduk = item.nama_produk;
        },

        // Delete Produk
        deleteProduk: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>/api/produk/delete/${this.idProduk}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProduk();
                        this.modalDelete = false;
                    } else {
                        this.notifType = "error";
                        this.notifMessage = data.message;
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

        setHargaBeli: function(item) {
            this.loading = true;
            this.idProduk = item.id_produk;
            this.hargaBeli = item.harga_beli;
            axios.put(`<?= base_url(); ?>/api/produk/sethargabeli/${this.idProduk}`, {
                    harga_beli: this.hargaBeli,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProduk();
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


        // Set Item Harga Jual
        setHargaJual: function(item) {
            this.loading = true;
            this.idProduk = item.id_produk;
            this.hargaJual = item.harga_jual;
            axios.put(`<?= base_url(); ?>/api/produk/sethargajual/${this.idProduk}`, {
                    harga_jual: this.hargaJual,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProduk();
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

        // Set Item Stok
        setStok: function(item) {
            this.loading = true;
            this.idProduk = item.id_produk;
            this.stok = item.stok;
            axios.put(`<?= base_url(); ?>/api/produk/setstok/${this.idProduk}`, {
                    stok: this.stok,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProduk();
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

        // Set Item Aktif
        setAktif: function(item) {
            this.loading = true;
            this.idProduk = item.id_produk;
            this.active = item.active;
            axios.put(`<?= base_url(); ?>/api/produk/setaktif/${this.idProduk}`, {
                    active: this.active,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProduk();
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

        // Export Excel
        excelMultiple: function(selected) {
            this.loading3 = true;
            var data = JSON.stringify(selected);
            //console.log(data);
            axios.post(`<?= base_url(); ?>/api/produk/exporttoexcel`, {
                    data
                }, options)
                .then(res => {
                    // handle success
                    this.loading3 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        // download file
                        const url = data.data.url;
                        window.location.href = url;
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

        confirmDelete: function(selected) {
            this.modalDeleteMultiple = true;
            this.deleted = JSON.stringify(selected);;
            //console.log(this.deleted);
        },

        deleteMultiple: function() {
            var data = this.deleted;
            this.loading = true;
            axios.post(`<?= base_url(); ?>/api/produk/delete/multiple`, {
                    data
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProduk();
                        this.modalDeleteMultiple = false;
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

        Ribuan(key) {
            var number_string = key.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        },

        // Modal Barcode
        openBarcode: function(item) {
            this.modalBarcode = true;
            this.barcode = item.barcode;
        },

        closeBarcode: function(item) {
            this.modalBarcode = false;
            this.jmlBarcode = 1;
        },

    }
</script>
<?php $this->endSection("js") ?>