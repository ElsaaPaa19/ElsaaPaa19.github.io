<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h1><?= $title ?></h1>
            <v-spacer></v-spacer>
            <h2 class="font-weight-medium">Saldo Rp.{{saldo}}</h2>
        </v-card-title>
        <v-toolbar flat>
            <v-btn large color="indigo" dark @click="modalAddOpen" elevation="1">
                <v-icon>mdi-plus</v-icon> <?= lang('App.add'); ?> Kas
            </v-btn>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
            </v-text-field>
        </v-toolbar>
        <v-data-table :headers="dataTable" :items="dataKas" :items-per-page="10" :loading="loading" :search="search" loading-text="Sedang memuat... Harap tunggu">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.kode}}</td>
                    <td>{{item.created_at}}</td>
                    <td>{{item.jenis}}</td>
                    <td>{{item.nominal}}</td>
                    <td>{{item.keterangan}}</td>
                    <td>{{item.nama}}</td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<!-- Modal Add -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalAdd" persistent max-width="600px">
            <v-card>
                <v-card-title><?= lang('App.add') ?> Kas
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalAddClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-5">
                    <v-form v-model="valid" ref="form">
                        <v-select v-model="jenis" label="<?= lang('App.type'); ?>" :items="dataJenis" item-text="text" item-value="value" :error-messages="jenisError" outlined></v-select>

                        <v-text-field v-model="nominal" type="number" label="Nominal" :error-messages="nominalError" outlined></v-text-field>

                        <v-textarea v-model="keterangan" label="<?= lang('App.description'); ?>" :error-messages="keteranganError" rows="3" outlined></v-textarea>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveKas" :loading="loading1" elevation="1">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Add -->

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
        search: "",
        dataKas: [],
        dataTable: [{
            text: '#',
            value: 'kode'
        }, {
            text: 'Tanggal',
            value: 'created_at'
        }, {
            text: 'Jenis',
            value: 'jenis'
        }, {
            text: 'Nominal (Rp)',
            value: 'nominal'
        }, {
            text: 'Keterangan',
            value: 'keterangan'
        }, {
            text: 'User',
            value: 'id_login'
        }, ],
        idKas: "",
        jenis: "",
        jenisError: "",
        dataJenis: [{
            text: 'Pemasukan',
            value: 'Pemasukan'
        }, {
            text: 'Pengeluaran',
            value: 'Pengeluaran'
        }],
        nominal: "",
        nominalError: "",
        keterangan: "",
        keteranganError: "",
        saldo: 0,
    }

    var errorKeys = []

    createdVue = function() {
        this.getKas();
        this.getSaldo();
    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function() {
            this.modalAdd = true;
        },

        modalAddClose: function() {
            this.jenis = "";
            this.nominal = "";
            this.keterangan = "";
            this.modalAdd = false;
            this.$refs.form.resetValidation();
        },

        // Get
        getKas: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>/api/kas', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataKas = data.data;
                        //console.log(this.settingData);
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

        getSaldo: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>/api/kas/saldo', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.saldo = data.data.saldo;
                        console.log(this.saldo);
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

        // Save
        saveKas: function() {
            this.loading1 = true;
            axios.post('<?= base_url(); ?>/api/kas/save', {
                    jenis: this.jenis,
                    nominal: this.nominal,
                    keterangan: this.keterangan
                }, options)
                .then(res => {
                    // handle success
                    this.loading1 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKas();
                        this.getSaldo();
                        this.jenis = "";
                        this.nominal = "";
                        this.keterangan = "";
                        this.modalAdd = false;
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
                        this.modalAdd = true;
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