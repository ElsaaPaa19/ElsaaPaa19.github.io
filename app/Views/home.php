<?php $this->extend("layouts/frontend"); ?>
<?php $this->section("content"); ?>
<template>
    <div class="grey lighten-2 pt-5">
        <v-container>
            <v-row align="center" justify="center">
                <v-col cols="12">
                    <v-text-field color="indigo" v-model="pencarian" label="Masukkan Menu yang Diinginkan" prepend-inner-icon="mdi-magnify" :autofocus="true" height="50" solo :loading="loading" loader-height="3"></v-text-field>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<template>
    <v-container>
        <v-card height="350" class="overflow-auto" elevation="1" v-for="item in dataProduk" :key="item.id_produk">
            <v-card-text>
                <v-alert v-if="notifType != ''" border="left" :type="notifType">{{notifMessage}}</v-alert>
                <h2 class="text-h5 font-weight-medium mb-3" v-if="dataProduk != ''">Hasil Pencarian</h2>
                <v-row>
                    <v-col cols="12" md="4">
                        <h4>Nama Produk:</h4>{{item.nama_produk}}
                        <h4>Harga:</h4>Rp.{{item.harga_jual}}
                        <h4>Deskripsi:</h4>{{item.deskripsi}}
                        <h4>Stok:</h4>{{item.stok}}
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<template>
    <v-container>
        <h2 class="mb-3 font-weight-medium">Menu Tersedia</h2>
        <v-row v-if="show == true">
            <v-col v-for="n in 4" :key="n" cols="12" sm="3">
                <v-skeleton-loader class="mx-auto" max-width="300" type="paragraph, heading"></v-skeleton-loader>
            </v-col>
        </v-row>
        <v-row v-if="show == false">
            <v-col v-for="item in produkTerbaru" :key="item.id_produk" cols="12" sm="6" md="4">
                <v-card elevation="1" min-height="150">
                    <v-list-item-avatar size="70" center>
                        <v-img :src="'<?= base_url() ?>' + '/' + item.media_path" v-if="item.media_path != null"></v-img>
                        <v-img src="<?= base_url('images/no_image.jpg') ?>" v-else></v-img>
                    </v-list-item-avatar>
                    <v-card-title class="text-h6">{{item.nama_produk}}</v-card-title>
                    <v-card-subtitle class="text-h6">Rp.{{ item.harga_jual }},-</v-card-subtitle>
                    <v-card-subtitle>{{item.deskripsi}} (Stok : {{item.stok}})</v-card-subtitle>

                </v-card>
            </v-col>
        </v-row>
        <br />
        <paginate :page-count="pageCount" :no-li-surround="true" :container-class="'v-pagination theme--light'" :page-link-class="'v-pagination__item v-btn'" :active-class="'v-pagination__item--active primary'" :disabled-class="'v-pagination__navigation--disabled'" :prev-link-class="'v-pagination__navigation'" :next-link-class="'v-pagination__navigation'" :click-handler="handlePagination">
        </paginate>
    </v-container>
</template>



<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    computedVue = {
        ...computedVue,
    }
    createdVue = function() {
        this.getProdukTerbaru();
    }
    watchVue = {
        pencarian: function() {
            this.cariProduk();
        }
    }
    dataVue = {
        ...dataVue,
        dialogCamera: false,
        /*camera: "auto",
        error: '',*/
        pencarian: null,
        dataProduk: [],
        produkTerbaru: [],
        pageCount: 0,
        currentPage: 1,
    }
    methodsVue = {
        ...methodsVue,
        // Scan Camera
        dialogCameraOpen: function() {
            this.dialogCamera = true;
            this.pencarian = null;
            this.camera = "auto";
        },

        async onScanCamera(decodedText, decodedResult) {
            this.pencarian = decodedText;
            this.dialogCamera = false;
        },


        // Get Product
        // Search Produk
        cariProduk: function() {
            this.getDataProduk();
        },

        // Get Data Produk
        getDataProduk: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>/api/cari_produk?query=${this.pencarian}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.notifType = "";
                        this.notifMessage = "";
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataProduk = data.data;
                    } else {
                        this.notifType = "warning";
                        this.notifMessage = data.message;
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataProduk = data.data;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        // Get produk Limit 10
        getProdukTerbaru: function() {
            this.show = true;
            axios.get(`<?= base_url(); ?>/api/produk/terbaru?page=${this.currentPage}`)
                .then(res => {
                    // handle success
                    var data = res.data;
                    this.produkTerbaru = data.data;
                    this.pageCount = Math.ceil(data.total_page / data.per_page);
                    this.show = false;
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        handlePagination: function(pageNumber) {
            this.show = true;
            axios.get(`<?= base_url(); ?>/api/produk/terbaru?page=${pageNumber}`)
                .then((res) => {
                    var data = res.data;
                    this.produkTerbaru = data.data;
                    this.pageCount = Math.ceil(data.total_page / data.per_page);
                    this.show = false;
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        }
    }
</script>

<?php $this->endSection("js") ?>