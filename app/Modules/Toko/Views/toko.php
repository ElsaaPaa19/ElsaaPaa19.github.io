<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <h1 class="mb-1">Profil Angkringan</h1>
    <v-tabs>
        <v-tab>
            Profil Angkringan
        </v-tab>

        <v-tab-item>
            <v-card outlined>
                <v-card-text class="elevation-1">
                    <v-form ref="form" v-model="valid">
                        <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                        <v-row>
                            <v-col>
                                <p class="mb-3 text-subtitle-1">Nama Angkringan</p>
                                <v-text-field v-model="namaToko" :error-messages="nama_tokoError" outlined></v-text-field>
                            </v-col>

                            <v-col>
                                <p class="mb-3 text-subtitle-1">Nama Pemilik</p>
                                <v-text-field v-model="namaPemilik" :error-messages="nama_pemilikError" outlined></v-text-field>
                            </v-col>
                        </v-row>

                        <p class="mb-3 text-subtitle-1">Alamat Angkringan</p>
                        <v-textarea v-model="alamatToko" :error-messages="alamat_tokoError" rows="2" outlined></v-textarea>

                        <v-row>
                            <v-col>
                                <p class="mb-3 text-subtitle-1">Nomor Telepon</p>
                                <v-text-field v-model="telp" :error-messages="telpError" outlined></v-text-field>
                            </v-col>
                            <v-col>
                                <p class="mb-3 text-subtitle-1">E-mail</p>
                                <v-text-field v-model="email" :error-messages="emailError" outlined></v-text-field>
                            </v-col>
                        </v-row>

                    </v-form>

                    <v-btn large color="primary" @click="update" :loading="loading2" elevation="1">
                        <v-icon>mdi-content-save</v-icon> Simpan
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-tab-item>

    </v-tabs>
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
        modalEdit: false,
        tokoData: [],
        idToko: "",
        namaToko: "",
        nama_tokoError: "",
        alamatToko: "",
        alamat_tokoError: "",
        telp: "",
        telpError: "",
        email: "",
        emailError: "",
        namaPemilik: "",
        nama_pemilikError: "",
        image: null,
        imagePreview: null,
        overlay: false,

    }

    var errorKeys = []

    createdVue = function() {
        this.getToko();
    }

    methodsVue = {
        ...methodsVue,
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
            this.snackbarMessage = 'Image dihapus';
        },
        uploadFile: function(file) {
            var formData = new FormData() // Split the base64 string in data and contentType
            var block = file.split(";"); // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif" get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            formData.append('image', blob);
            formData.append('id', this.settingId);
            this.loading2 = true;
            axios.post(`<?= base_url() ?>/api/toko/upload`, formData, options)
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.valueEdit = data.data
                        this.overlay = true;
                        this.getToko();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalEdit = true;
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

        // Get
        getToko: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>/api/toko', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.tokoData = data.data;
                        this.idToko = this.tokoData.id_toko;
                        this.namaToko = this.tokoData.nama_toko;
                        this.alamatToko = this.tokoData.alamat_toko;
                        this.telp = this.tokoData.telp;
                        this.email = this.tokoData.email;
                        this.namaPemilik = this.tokoData.nama_pemilik;
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

        //Update
        update: function() {
            this.loading2 = true;
            axios.put(`<?= base_url() ?>/api/toko/update/${this.idToko}`, {
                    nama_toko: this.namaToko,
                    alamat_toko: this.alamatToko,
                    telp: this.telp,
                    email: this.email,
                    nama_pemilik: this.namaPemilik,
                }, options)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getToko();
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

        setAktifPrinterUsb: function() {
            this.loading2 = true;
            axios.put(`<?= base_url() ?>/api/toko/setaktifprinterusb/${this.idToko}`, {
                    printer_usb: this.printerUsb,
                }, options)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getToko();
                        this.$refs.form.resetValidation();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
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

        setAktifPrinterBT: function() {
            this.loading2 = true;
            axios.put(`<?= base_url() ?>/api/toko/setaktifprinterbt/${this.idToko}`, {
                    printer_bluetooth: this.printerBT,
                }, options)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getToko();
                        this.$refs.form.resetValidation();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
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
    }
</script>
<?php $this->endSection("js") ?>