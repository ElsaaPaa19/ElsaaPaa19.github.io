<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-row>
        <v-col lg="3" cols="sm" class="pb-2">
            <v-card link>
                <div class="pa-4">
                    <h2 class="font-weight-medium mb-0">Penjualan <v-icon large class="green--text text--lighten-1 float-right">mdi-cart</v-icon>
                    </h2>
                    <h4 class="font-weight-medium">Hari Ini: <?= $countTrxHariini; ?>, Total: Rp.<?= $totalTrxHariini ?? "0"; ?></h4>
                    <h4 class="font-weight-medium">Kemarin: <?= $countTrxHarikemarin; ?>, Total: Rp.<?= $totalTrxHarikemarin ?? "0"; ?></h4>
                </div>
            </v-card>
        </v-col>

        <v-col lg="3" cols="sm" class="pb-2">
            <v-card link>
                <div class="pa-4">
                    <h2 class="font-weight-medium mb-0">Jumlah Menu <v-icon large class="blue--text text--lighten-1 float-right">mdi-package</v-icon>
                    </h2>
                    <h1 class="pa-0 ma-0"><?= $jmlProduk; ?></h1>
                </div>
            </v-card>
        </v-col>

        <v-col lg="3" cols="sm" class="pb-2">
            <v-card link>
                <div class="pa-4">
                    <h2 class="font-weight-medium mb-0">User <v-icon large class="red--text text--lighten-1 float-right">mdi-account-multiple</v-icon>
                    </h2>
                    <h1 class="pa-0 ma-0"><?= $jmlUser; ?></h1>
                </div>
            </v-card>
        </v-col>
    </v-row>


</template>

<br />

<template>
    <v-card>
        <v-card-title>Transaksi Hari ini</v-card-title>
        <v-card-subtitle><?= date('d-m-Y'); ?></v-card-subtitle>
        <v-card-text>
            <bar-chart1></bar-chart1>
        </v-card-text>
    </v-card>
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
        products: [],
        pageCount: 0,
        currentPage: 1,
    }

    createdVue = function() {
        this.getProducts();

        Vue.component('bar-chart1', {
            extends: VueChartJs.Bar,
            mounted() {
                this.renderChart({
                    labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '00'],
                    datasets: [{
                        data: JSON.parse('<?= json_encode($harian) ?>'),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                }, {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        xAxes: [{
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: true,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            },
                            ticks: {
                                maxTicksLimit: 31
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: true,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                })
            }

        })
    }

    mountedVue = function() {

    }

    methodsVue = {
        ...methodsVue,
        // Get Product
        getProducts: function() {
            this.show = true;
            axios.get(`<?= base_url(); ?>/api/produk/terbaru?page=${this.currentPage}`, options)
                .then(res => {
                    // handle success
                    var data = res.data;
                    if (data.status == true) {
                        this.products = data.data;
                        this.pageCount = Math.ceil(data.total_page / data.per_page);
                        this.show = false;
                    } else {
                        this.snackbar = true;
                        this.snackbarType = "warning";
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
        handlePagination: function(pageNumber) {
            this.show = true;
            axios.get(`<?= base_url(); ?>/api/produk/terbaru?page=${pageNumber}`, options)
                .then((res) => {
                    var data = res.data;
                    this.products = data.data;
                    this.pageCount = Math.ceil(data.total_page / data.per_page);
                    this.show = false;
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
        }
    }
</script>
<?php $this->endSection("js") ?>