<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-toolbar elevation="1">
            <v-btn icon href="<?= base_url('produk') ?>">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-toolbar-title>Tambah Produk</v-toolbar-title>
            <v-spacer></v-spacer>


        </v-toolbar>
        <v-card-text>
            <v-form ref="form" v-model="valid">
                <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>

                <v-row class="mt-n4">
                    <v-col class="mb-n10" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold"><?= lang('App.productImg') ?></p>
                        <p class="text-caption">Format gambar .jpg .jpeg .png </p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-file-input v-model="image" show-size label="Image Upload" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading2"></v-file-input>

                        <div v-show="imagePreview">
                            <v-img :src="imagePreview" max-width="200">
                                <v-overlay v-model="overlay" absolute :opacity="0.1">
                                    <v-btn small class="ma-2" color="error" dark @click="deleteMedia">
                                        Hapus
                                        <v-icon dark right>
                                            mdi-delete
                                        </v-icon>
                                    </v-btn>
                                </v-overlay>
                            </v-img>
                        </div>
                    </v-col>
                </v-row>


                <v-row class="mt-n4">
                    <v-col class="mb-n7" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Barcode</p>
                        <p class="text-caption"></p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-text-field label="Barcode" v-model="barcode" :error-messages="barcodeError" outlined dense></v-text-field>
                    </v-col>
                </v-row>


                <v-row class="mt-n4">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Nama Produk</p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-text-field label="Masukkan Nama Produk *" v-model="namaProduk" :error-messages="nama_produkError" outlined dense></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="mt-n2">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Kategori</p>
                        <p class="text-caption"></p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-select v-model="idKategori" label="<?= lang('App.selectCategory'); ?>" :items="dataKategori" item-text="nama_kategori" item-value="id_kategori" :error-messages="id_kategoriError" :loading="loading2" outlined dense append-outer-icon="mdi-plus-thick" @click:append-outer="addKategori"></v-select>
                    </v-col>
                </v-row>

                <v-row class="mt-n4">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Satuan</p>
                        <p class="text-caption"></p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-select v-model="satuanProduk" label="<?= lang('App.selectUnit'); ?>" :items="dataSatuan" item-text="text" item-value="value" :error-messages="satuan_produkError" :loading="loading2" outlined dense></v-select>
                    </v-col>
                </v-row>

                <v-row class="mt-n4">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Merk</p>
                        <p class="text-caption"></p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-text-field label="<?= lang('App.merk') ?>" v-model="merk" :error-messages="merkError" outlined dense></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="mt-n4">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Deskripsi Produk</p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-textarea v-model="deskripsi" counter maxlength="3000" outlined full-width auto-grow :error-messages="deskripsiError"></v-textarea>
                    </v-col>
                </v-row>

                <v-row class="mt-n4">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-2 text-subtitle-1 font-weight-bold">Harga Produk</p>
                        <p class="text-caption"></p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <p class="mb-2 text-subtitle-1"><?= lang('App.priceBuy') ?></p>
                        <v-text-field label="<?= lang('App.priceBuy') ?> *" v-model="hargaBeli" type="number" :error-messages="harga_beliError" prefix="Rp" outlined dense></v-text-field>
                        <p class="mb-2 text-subtitle-1"><?= lang('App.priceSell') ?></p>
                        <v-text-field label="<?= lang('App.priceSell') ?>" v-model="hargaJual" type="number" :error-messages="harga_jualError" prefix="Rp" outlined dense></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="mt-n4">
                    <v-col class="mb-n8" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Status Produk</p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-switch v-model="active" name="active" false-value="0" true-value="1" color="success" :label="active == false ? 'Tidak Aktif':'Aktif'"></v-switch>
                    </v-col>
                </v-row>

                <v-row class="mt-0">
                    <v-col class="mb-n5" cols="12" md="3">
                        <p class="mb-1 text-subtitle-1 font-weight-bold">Stok Produk</p>
                        <p class="text-caption"></p>
                    </v-col>
                    <v-col cols="12" md="9">
                        <v-text-field label="9999" v-model="stok" type="number" :error-messages="stokError" outlined dense></v-text-field>
                    </v-col>
                </v-row>
                <v-btn color="indigo" dark large @click="saveProduct" :loading="loading">
                    <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                </v-btn>

            </v-form>
        </v-card-text>
    </v-card>
</template>

<!-- Modal -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalKategori" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    Kategori
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalKategoriClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="form" v-model="valid">
                        <v-container>
                            <v-row>
                                <v-col cols="12" md="7">
                                    <v-text-field label="<?= lang('App.categoryName') ?>" v-model="namaKategori" type="text" :error-messages="nama_kategoriError"></v-text-field>
                                </v-col>

                                <v-col cols="12" md="5">
                                    <v-btn color="primary" large @click="saveKategori" :loading="loading2"><?= lang('App.add') ?></v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                    <v-data-table :headers="tbKategori" :items="dataKategori" :items-per-page="5" class="elevation-1" :loading="loading1">
                        <template v-slot:item.actions="{ item }">
                            <v-btn color="error" icon @click="deleteKategori(item)" :loading="loading3">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text large @click="modalKategoriClose"><?= lang('App.close') ?></v-btn>
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

    var errorKeys = []

    dataVue = {
        ...dataVue,
        modalKategori: false,
        dataKategori: [],
        dataSatuan: [{
            text: 'Gelas',
            value: 'gelas'
        }, {
            text: 'Piring',
            value: 'piring'
        }, {
            text: 'Bungkus',
            value: 'bungkus'
        }, {
            text: 'Tusuk',
            value: 'tusuk'
        }],

        idProduk: "<?= $id_produk ?>",
        barcode: "",
        barcodeError: "",
        idKategori: "",
        id_kategoriError: "",
        namaProduk: "",
        nama_produkError: "",
        merk: "",
        merkError: "",
        hargaBeli: "",
        harga_beliError: "",
        hargaJual: "",
        harga_jualError: "",
        satuanProduk: "",
        satuan_produkError: "",
        deskripsi: "",
        deskripsiError: "",
        stok: "",
        stokError: "",
        active: false,
        idMedia: "",
        mediaPath: null,
        image: null,
        imagePreview: null,
        overlay: false,
        namaKategori: "",
        nama_kategoriError: "",
        tbKategori: [{
                text: 'ID',
                value: 'id_kategori'
            },
            {
                text: 'Nama Kategori',
                value: 'nama_kategori'
            },
            {
                text: '<?= lang('App.action') ?>',
                value: 'actions',
                sortable: false
            },
        ],
    }
    createdVue = function() {
        this.getKategori();
    }

    methodsVue = {
        ...methodsVue,
        // Get
        getKategori: function() {
            this.loading1 = true;
            axios.get('<?= base_url(); ?>/api/kategori', options)
                .then(res => {
                    // handle success
                    this.loading1 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.dataKategori = data.data;
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

        // Kategori
        addKategori: function() {
            this.modalKategori = true;

        },

        modalKategoriClose: function() {
            this.modalKategori = false;
            this.$refs.form.resetValidation();
        },

        // Save Category
        saveKategori: function() {
            this.loading2 = true;
            axios.post(`<?= base_url(); ?>/api/kategori/save`, {
                    nama_kategori: this.namaKategori,
                }, options)
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.namaKategori = "";
                        this.getKategori();
                        this.$refs.form.resetValidation();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => this.notifType = "", 4000);
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.$refs.form.validate();
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

        // Delete Category
        deleteKategori: function(item) {
            this.loading3 = true;
            axios.delete(`<?= base_url(); ?>/api/kategori/delete/${item.id_kategori}`, options)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKategori();
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

        onFileChange() {
            const reader = new FileReader()
            reader.readAsDataURL(this.image)
            reader.onload = e => {
                this.imagePreview = e.target.result;
                this.uploadFile(this.imagePreview);
            }
        },

        onFileClear() {
            this.image = null;
            this.imagePreview = null;
            this.overlay = false;
            this.snackbar = true;
            this.snackbarMessage = 'Gambar berhasil dihapus';
            this.deleteMedia();
        },

        uploadFile: function(file) {
            var formData = new FormData() // Split the base64 string in data and contentType
            var block = file.split(";"); // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif" get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            formData.append('image', blob);
            formData.append('id_produk', this.idProduk);
            this.loading2 = true;
            axios.post(`<?= base_url() ?>/api/media/save`, formData, options)
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.idMedia = data.data
                        this.overlay = true;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalAdd = true;
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

        // Delete Product
        deleteMedia: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>/api/media/delete/${this.idMedia}`, options)
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.image = null;
                        this.imagePreview = null;
                        this.overlay = false;
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

        // Save Product
        saveProduct: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>/api/produk/save`, {
                    id_produk: this.idProduk,
                    barcode: this.barcode,
                    id_kategori: this.idKategori,
                    nama_produk: this.namaProduk,
                    merk: this.merk,
                    harga_beli: this.hargaBeli,
                    harga_jual: this.hargaJual,
                    satuan_produk: this.satuanProduk,
                    deskripsi: this.deskripsi,
                    stok: this.stok,
                    active: this.active,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.$refs.form.resetValidation();
                        setTimeout(() => window.location.href = data.data.url, 1000);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => this.notifType = "", 4000);
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.$refs.form.validate();
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

        // Get Item Show Product
        showItem: function(product) {
            this.modalShow = true;
            this.show = false;
            this.notifType = "";
            this.productIdEdit = product.product_id;
            this.productNameEdit = product.product_name;
            this.productPriceEdit = product.product_price;
            this.productDescriptionEdit = product.product_description;
            this.mediaID = product.product_image;
            this.mediaPathEdit = product.media_path;
        },

        // Get Item Edit Product
        editItem: function(product) {
            this.modalEdit = true;
            this.show = false;
            this.notifType = "";
            this.productIdEdit = product.product_id;
            this.productNameEdit = product.product_name;
            this.productPriceEdit = product.product_price;
            this.productDescriptionEdit = product.product_description;
            this.mediaID = product.product_image;
            this.mediaPathEdit = product.media_path;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
        },

        //Update Product
        updateProduct: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>/api/product/update/${this.productIdEdit}`, {
                    product_name: this.productNameEdit,
                    product_price: this.productPriceEdit,
                    product_description: this.productDescriptionEdit,
                    product_image: this.mediaID
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarType = "success";
                        this.snackbarMessage = data.message;
                        this.getProducts();
                        this.modalEdit = false;
                        this.$refs.form.resetValidation();
                    } else {
                        this.notifType = "error";
                        this.notifMessage = data.message;
                        this.modalEdit = true;
                        this.$refs.form.validate();
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

        // Get Item Delete Product
        deleteItem: function(product) {
            this.modalDelete = true;
            this.productIdDelete = product.product_id;
            this.productNameDelete = product.product_name;
        },

        // Delete Product
        deleteProduct: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>/api/product/delete/${this.productIdDelete}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getProducts();
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

        // Set Item Product Price
        setPrice: function(product) {
            this.loading = true;
            this.productIdEdit = product.product_id;
            this.productPrice = product.product_price;
            axios.put(`<?= base_url(); ?>/api/product/setprice/${this.productIdEdit}`, {
                    product_price: this.productPrice,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarType = "success";
                        this.snackbarMessage = data.message;
                        this.getProducts();
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

        // Set Item Active Product
        setActive: function(product) {
            this.loading = true;
            this.productIdEdit = product.product_id;
            this.active = product.active;
            axios.put(`<?= base_url(); ?>/api/product/setactive/${this.productIdEdit}`, {
                    active: this.active,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarType = "success";
                        this.snackbarMessage = data.message;
                        this.getProducts();
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