<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <h1>Laporan Penjualan <span class="font-weight-medium">{{ startDate }} &mdash; {{ endDate }}</span> &nbsp;
        <template>
            <v-menu v-model="menu" :close-on-content-click="false" offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-filter-menu</v-icon>
                    </v-btn>
                </template>
                <v-card width="250">
                    <v-card-text>
                        <p class="mb-1">Dari Tanggal - Sampai Tanggal</p>
                        <v-text-field v-model="startDate" type="date"></v-text-field>
                        <v-text-field v-model="endDate" type="date"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="menu = false">
                            <?= lang('App.close'); ?>
                        </v-btn>
                        <v-btn color="primary" text @click="handleSubmit" :loading="loading">
                            Filter
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>
        </template>
    </h1>


    <v-tabs>
        <v-tab>
            Barang
        </v-tab>
        <v-tab>
            Penjualan
        </v-tab>
        <v-tab>
            Kategori
        </v-tab>
        <v-tab>
            Laba Rugi
        </v-tab>

        <v-tab-item>
            <v-card outlined>
                <v-data-table :headers="thProduk" :items="dataProdukWithIndex" :items-per-page="-1" class="elevation-1" :loading="loading" ref="testHtml">
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>{{item.index}}</td>
                            <td>{{item.nama_produk}}</td>
                            <td>{{item.qty}}</td>
                            <td>{{item.harga_jual}}</td>
                            <td>{{item.jumlah}}</td>
                        </tr>
                    </template>
                    <template slot="body.append">
                        <tr>
                            <td></td>
                            <td class="text-right">Total</td>
                            <td>{{ sumTotalProduk('qty') }}</td>
                            <td></td>
                            <td>{{ sumTotalProduk('jumlah') }}</td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </v-tab-item>

        <v-tab-item>
            <v-card outlined>
                <v-data-table :headers="thPenjualan" :items="dataPenjualanWithIndex" :items-per-page="-1" class="elevation-1" :loading="loading">
                    <template slot="body.append">
                        <tr>
                            <td></td>
                            <td class="text-right">Total</td>
                            <td>{{ sumTotalPenjualan('jumlah') }}</td>
                            <td>{{ sumTotalPenjualan('total') }}</td>
                            <td></td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </v-tab-item>

        <v-tab-item>
            <v-card outlined>
                <v-data-table :headers="thKategori" :items="dataKategoriWithIndex" :items-per-page="-1" class="elevation-1" :loading="loading">
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>{{item.index}}</td>
                            <td><a @click="showItem(item)">{{item.nama_kategori}}</a></td>
                            <td>{{item.jumlah}}</td>
                            <td>{{item.total}}</td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </v-tab-item>

        <v-tab-item>
            <v-card outlined>
                <!-- Pendapatan -->
                <v-card>
                    <v-card-title>Pendapatan
                        <v-spacer></v-spacer>
                        <!--  <v-btn class="me-3" outlined :href="'<?= base_url('laporan/barang-pdf') ?>' + '?tgl_start=' + startDate + '&tgl_end=' + endDate" target="_blank" v-show="dataProduk != ''">
                            <v-icon>mdi-download</v-icon> PDF
                        </v-btn> -->
                        {{ startDate }} - {{ endDate }}
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="pt-0">
                        <v-list class="pt-0">
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-medium">Penjualan</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item class="ms-7">
                                <v-list-item-content>
                                    <v-list-item-title>Pemasukan (Penjualan)</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{pemasukanPenjualan ?? "0"}}</h3>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item class="ms-7">
                                <v-list-item-content>
                                    <v-list-item-title>Penghasilan Lain</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{pemasukanLain ?? "0"}}</h3>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-medium">Total Pendapatan</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{totalPendapatan ?? "0"}}</h3>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>

                <v-card>
                    <v-card-title>Beban Pokok Penjualan</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="pt-0">
                        <v-list class="pt-0">
                            <v-list-item class="ms-7">
                                <v-list-item-content>
                                    <v-list-item-title>Beban Pokok Pendapatan (HPP)</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{bebanPokokPendapatan ?? "0"}}</h3>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-medium">Total Beban Pokok Penjualan</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{bebanPokokPendapatan ?? "0"}}</h3>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
                <v-card>
                    <v-card-title>Laba Kotor
                        <v-spacer></v-spacer>
                        {{labaKotor}}
                    </v-card-title>
                </v-card>

                <!-- Pengeluaran -->
                <v-card>
                    <v-card-title>Biaya Operasional</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="pt-0">
                        <v-list class="pt-0">
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-medium">Biaya Operasional</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item class="ms-7">
                                <v-list-item-content>
                                    <v-list-item-title>Pengeluaran</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{pengeluaran ?? "0"}}</h3>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item class="ms-7">
                                <v-list-item-content>
                                    <v-list-item-title>Pengeluaran Lain</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{pengeluaranLain ?? "0"}}</h3>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-medium">Total Biaya Operasional</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>
                                <h3 class="font-weight-regular">{{totalPengeluaran ?? "0"}}</h3>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>

                <v-card>
                    <v-card-title>Laba Bersih
                        <v-spacer></v-spacer>
                        {{labaBersih ?? "0"}}
                    </v-card-title>
                </v-card>

            </v-card>
        </v-tab-item>
    </v-tabs>

    <!-- <v-tabs v-model="tab">
        <v-tabs-slider></v-tabs-slider>

        <v-tab href="#subscribe">
            Subscribe
        </v-tab>

        <v-tab href="#contact">
            Contact
        </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
        <v-tab-item :key="1" value="subscribe">
            <v-card flat>
                <v-card-text>subscribe</v-card-text>
            </v-card>
        </v-tab-item>
        <v-tab-item :key="2" value="contact">
            <v-card flat>
                <v-card-text>contact</v-card-text>
            </v-card>
        </v-tab-item>
    </v-tabs-items> -->

</template>

<template>
    <v-dialog v-model="modalShow" scrollable max-width="900">
        <v-card>
            <v-card-title class="text-h5">
                Laporan Detail By Kategori {{namaKategori}}
                <v-spacer></v-spacer>
                <v-btn icon @click="modalShow = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-data-table :headers="thDetailKategori" :items="dataDetailKategori" :items-per-page="-1" class="elevation-1 mt-4" :loading="loading1">
                </v-data-table>
            </v-card-text>
            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn large color="primary" text @click="modalShow = false">
                    OK
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
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
        modalShow: false,
        menu: false,
        startDate: "<?= date('Y-m-d'); ?>",
        endDate: "<?= date('Y-m-d'); ?>",
        tab: "subscribe",
        dataProduk: [],
        dataPenjualan: [],
        dataKategori: [],
        dataDetailKategori: [],
        dataLabaRugi: [],
        thProduk: [{
            text: '#',
            value: 'index'
        }, {
            text: 'Nama Produk',
            value: 'nama_produk'
        }, {
            text: 'Qty',
            value: 'qty'
        }, {
            text: 'Harga',
            value: 'harga_jual'
        }, {
            text: 'Jumlah',
            value: 'jumlah'
        }, ],
        thPenjualan: [{
            text: '#',
            value: 'index'
        }, {
            text: 'No. Nota',
            value: 'no_nota'
        }, {
            text: 'Jumlah',
            value: 'jumlah'
        }, {
            text: 'Total',
            value: 'total'
        }, {
            text: 'User',
            value: 'nama'
        }, ],
        thKategori: [{
            text: '#',
            value: 'index'
        }, {
            text: 'Kategori',
            value: 'nama_kategori'
        }, {
            text: 'Jumlah',
            value: 'jumlah'
        }, {
            text: 'Total',
            value: 'total'
        }],
        idKategori: "",
        namaKategori: "",
        thDetailKategori: [{
            text: '#',
            value: 'no_nota'
        }, {
            text: 'Tanggal',
            value: 'created_at'
        }, {
            text: 'Nama Barang',
            value: 'nama_produk'
        }, {
            text: 'Jumlah',
            value: 'qty'
        }, {
            text: 'Satuan',
            value: 'satuan'
        }, {
            text: 'Total',
            value: 'jumlah'
        }],
        pemasukanPenjualan: 0,
        pemasukanLain: 0,
        totalPendapatan: 0,
        bebanPokokPendapatan: 0,
        labaKotor: 0,
        pengeluaran: 0,
        pengeluaranLain: 0,
        totalPengeluaran: 0,
        labaBersih: 0,
    }

    createdVue = function() {
        this.getLaporanProduk();
        this.getLaporanPenjualan();
        this.getLaporanKategori();
        this.getLaporanLabaRugi();
    }

    computedVue = {
        ...computedVue,
        dataProdukWithIndex() {
            return this.dataProduk.map(
                (items, index) => ({
                    ...items,
                    index: index + 1
                }))
        },

        dataPenjualanWithIndex() {
            return this.dataPenjualan.map(
                (items, index) => ({
                    ...items,
                    index: index + 1
                }))
        },

        dataKategoriWithIndex() {
            return this.dataKategori.map(
                (items, index) => ({
                    ...items,
                    index: index + 1
                }))
        }
    }

    methodsVue = {
        ...methodsVue,

        handleSubmit: function() {
            this.getLaporanProduk();
            this.getLaporanPenjualan();
            this.getLaporanKategori();
            this.getLaporanLabaRugi();
        },

        // Get
        getLaporanProduk: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>/api/laporanproduk?tgl_start=${this.startDate}&tgl_end=${this.endDate}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataProduk = data.data;
                        this.menu = false;
                        console.log(this.dataProduk);
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

        // Get
        getLaporanPenjualan: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>/api/laporanpenjualan?tgl_start=${this.startDate}&tgl_end=${this.endDate}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataPenjualan = data.data;
                        this.menu = false;
                        console.log(this.dataProduk);
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

        // Get
        getLaporanKategori: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>/api/laporankategori?tgl_start=${this.startDate}&tgl_end=${this.endDate}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataKategori = data.data;
                        this.menu = false;
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

        sumTotalProduk(key) {
            // sum data in give key (property)
            let total = 0
            const sum = this.dataProduk.reduce((accumulator, currentValue) => {
                return (total += +currentValue[key])
            }, 0)
            this.total = sum;
            return sum
        },

        sumTotalPenjualan(key) {
            // sum data in give key (property)
            let total = 0
            const sum = this.dataPenjualan.reduce((accumulator, currentValue) => {
                return (total += +currentValue[key])
            }, 0)
            this.total = sum;
            return sum
        },

        // Get Show Edit
        showItem: function(item) {
            this.modalShow = true;
            this.idKategori = item.id_kategori;
            this.namaKategori = item.nama_kategori;
            this.detailLaporanKategori();
        },

        detailLaporanKategori: function() {
            this.loading1 = true;
            axios.get(`<?= base_url(); ?>/api/laporandetailkategori?tgl_start=${this.startDate}&tgl_end=${this.endDate}&id_kategori=${this.idKategori}`, options)
                .then(res => {
                    // handle success
                    this.loading1 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataDetailKategori = data.data;
                        this.menu = false;
                        console.log(this.dataDetailKategori);
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

        getLaporanLabaRugi: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>/api/laporanlabarugi?tgl_start=${this.startDate}&tgl_end=${this.endDate}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataLabaRugi = data.data;
                        this.pemasukanPenjualan = this.dataLabaRugi.pemasukan_penjualan;
                        this.pemasukanLain = this.dataLabaRugi.pemasukan_lain;
                        this.totalPendapatan = this.dataLabaRugi.total_pendapatan;
                        this.bebanPokokPendapatan = this.dataLabaRugi.beban_pokok_pendapatan;
                        this.labaKotor = this.dataLabaRugi.laba_kotor;
                        this.pengeluaran = this.dataLabaRugi.pengeluaran;
                        this.pengeluaranLain = this.dataLabaRugi.pengeluaran_lain;
                        this.totalPengeluaran = this.dataLabaRugi.total_pengeluaran;
                        this.labaBersih = this.dataLabaRugi.laba_bersih;
                        this.menu = false;
                        console.log(this.dataLabaRugi);
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