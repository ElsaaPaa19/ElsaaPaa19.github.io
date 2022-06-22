<!DOCTYPE html>
<html lang="en">
<?php

use App\Libraries\Settings;

$setting = new Settings();
$appname = $setting->info['app_name'];
$icon = $setting->info['img_favicon'];
$logo = $setting->info['img_logo'];
$background = $setting->info['img_background'];
?>


<!--header-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Angkringan 69 Pogog Road">
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="<?= base_url() . "/" . $icon; ?>" />
    <meta name="robots" content="noindex,nofollow">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="<?= base_url('assets/css/materialdesignicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/vuetify.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<!--sidebar-->

<body>
    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
        <div class="loader">
            <div class="loader-logo"><img src="<?= base_url() . "/" . $logo ?>" alt="Preloader" width="64" style="margin-top: 5px;"></div>
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader end -->
    <div id="app">
        <v-app>
            <v-app-bar app color="blue-grey lighten-5" light elevation="2">
                <v-app-bar-nav-icon @click.stop="sidebarMenu = !sidebarMenu"></v-app-bar-nav-icon>
                <v-toolbar-title></v-toolbar-title>
                <v-spacer></v-spacer>
                <?php if (!empty(session()->get('username'))) : ?>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn text v-bind="attrs" v-on="on">
                                <v-icon>mdi-account-circle</v-icon> <?= session()->get('username') ?> <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>

                        <v-list>
                            <v-subheader>Login: &nbsp;<v-chip color="primary" small><?= session()->get('role') == 1 ? 'admin/kasir' : 'owner'; ?></v-chip>
                            </v-subheader>
                            <v-list-item>Halo, <?= session()->get('username') ?></v-list-item>
                            <v-divider></v-divider>
                            <v-list-item link href="<?= base_url('logout'); ?>" @click="localStorage.removeItem('access_token')">
                                <v-list-item-icon>
                                    <v-icon>mdi-logout</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Logout</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                <?php endif; ?>

            </v-app-bar>

            <v-navigation-drawer v-model="sidebarMenu" color="light-blue darken-4" dark app floating :permanent="sidebarMenu" :mini-variant.sync="mini" v-if="!isMobile">
                <v-list dense>
                    <v-list-item>
                        <v-list-item-action>
                            <v-icon @click.stop="toggleMini = !toggleMini">mdi-chevron-left</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                <h1>ANGKRINGAN 69</h1> <br />
                                <h2>POGOG ROAD</h2>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-divider></v-divider>
                <v-list>
                    <?php $uri = new \CodeIgniter\HTTP\URI(current_url()); ?>
                    <v-list-item-group>
                        <!--BACKEND ADMIN-->
                        <?php if (session()->get('role') == 1) : ?>
                            <v-list-item link href="<?= base_url('dashboard'); ?>" <?php if ($uri->getSegment(1) == "dashboard") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="<?= lang('App.dashboard') ?>" alt="<?= lang('App.dashboard') ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-home</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Dashboard</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item link href="<?= base_url('produk'); ?>" <?php if ($uri->getSegment(1) == "produk") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Produk" alt="<?= lang('App.product') ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-tag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Daftar Menu</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-group color="white" prepend-icon="mdi-basket" <?php if ($uri->getSegment(1) == "kasir" || $uri->getSegment(1) == "nota") : ?><?php echo 'value="true"'; ?><?php endif; ?>>
                                <template v-slot:activator>
                                    <v-list-item-content>
                                        <v-list-item-title>Penjualan</v-list-item-title>
                                    </v-list-item-content>
                                </template>

                                <v-list-item link href="<?= base_url('kasir'); ?>" <?php if ($uri->getSegment(1) == "kasir") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="<?= lang('App.cashier'); ?>" alt="<?= lang('App.cashier'); ?>">
                                    <v-list-item-icon>
                                        <v-icon>mdi-cash-register</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>KASIR</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item link href="<?= base_url('nota'); ?>" <?php if ($uri->getSegment(1) == "nota") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Detail Transaksi" alt="<?= lang('App.receipt') ?>">
                                    <v-list-item-icon>
                                        <v-icon>mdi-receipt</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Detail Transaksi</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-group>

                            <v-divider></v-divider>

                            <v-list-group color="white" prepend-icon="mdi-cash" <?php if ($uri->getSegment(1) == "kas" || $uri->getSegment(1) == "laporan") : ?><?php echo 'value="true"'; ?><?php endif; ?>>
                                <template v-slot:activator>
                                    <v-list-item-content>
                                        <v-list-item-title>Keuangan</v-list-item-title>
                                    </v-list-item-content>
                                </template>

                                <v-list-item link href="<?= base_url('kas'); ?>" <?php if ($uri->getSegment(1) == "kas") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Kas" alt="Kas">
                                    <v-list-item-icon>
                                        <v-icon>mdi-file-document</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Kas Angkringan</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>

                            </v-list-group>

                            <v-list-item link href="<?= base_url('toko'); ?>" <?php if ($uri->getSegment(1) == "toko") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Profil" alt="<?= lang('App.store') ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-store</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Profil</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item link href="<?= base_url('user'); ?>" <?php if ($uri->getSegment(1) == "user") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Users" alt="Users">
                                <v-list-item-icon>
                                    <v-icon>mdi-account-multiple</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Users</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item link href="<?= base_url('setting'); ?>" <?php if ($uri->getSegment(1) == "setting") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Setting" alt="Setting">
                                <v-list-item-icon>
                                    <v-icon>mdi-cog</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Setting</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                        <?php endif; ?>



                        <!--BACKEND OWNER-->
                        <?php if (session()->get('role') == 2) : ?>
                            <v-list-item link href="<?= base_url('dashboard'); ?>" <?php if ($uri->getSegment(1) == "dashboard") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="<?= lang('App.dashboard') ?>" alt="<?= lang('App.dashboard') ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-home</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title><?= lang('App.dashboard') ?></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item link href="<?= base_url('produk'); ?>" <?php if ($uri->getSegment(1) == "produk") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Produk" alt="<?= lang('App.product') ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-tag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Daftar Menu</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-group color="white" prepend-icon="mdi-cash" <?php if ($uri->getSegment(1) == "kas" || $uri->getSegment(1) == "laporan") : ?><?php echo 'value="true"'; ?><?php endif; ?>>
                                <template v-slot:activator>
                                    <v-list-item-content>
                                        <v-list-item-title>Keuangan</v-list-item-title>
                                    </v-list-item-content>
                                </template>

                                <v-list-item link href="<?= base_url('kas'); ?>" <?php if ($uri->getSegment(1) == "kas") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Kas" alt="Kas">
                                    <v-list-item-icon>
                                        <v-icon>mdi-file-document</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Kas Angkringan</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item link href="<?= base_url('laporan'); ?>" <?php if ($uri->getSegment(1) == "laporan") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="<?= lang('App.report') ?>" alt="<?= lang('App.report') ?>">
                                    <v-list-item-icon>
                                        <v-icon>mdi-file-percent</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Laporan Penjualan</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>

                            </v-list-group>

                            <v-list-item link href="<?= base_url('nota'); ?>" <?php if ($uri->getSegment(1) == "nota") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Detail Transaksi" alt="<?= lang('App.receipt') ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-receipt</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Detail Transaksi</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item link href="<?= base_url('user'); ?>" <?php if ($uri->getSegment(1) == "user") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> title="Users" alt="Users">
                                <v-list-item-icon>
                                    <v-icon>mdi-account-multiple</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Users</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                        <?php endif; ?>

                    </v-list-item-group>
                </v-list>

            </v-navigation-drawer>

            <v-main>
                <div class="pa-5 mb-8">
                    <?= $this->renderSection('content') ?>
                </div>
            </v-main>

            <v-snackbar v-model="snackbar" :color="snackbarType" :timeout="timeout" style="bottom:20px;">
                <span v-if="snackbar">{{snackbarMessage}}</span>
                <template v-slot:action="{ attrs }">
                    <v-btn text v-bind="attrs" @click="snackbar = false">
                        OK
                    </v-btn>
                </template>
            </v-snackbar>
        </v-app>
    </div>

    <script src="<?= base_url('assets/js/vue.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vuetify.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vuetify-image-input.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/axios.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vuejs-paginate.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/Chart.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vue-chartjs.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main.js') ?>" type="text/javascript"></script>

    <script>
        var vue = null;
        var computedVue = {
            mini: {
                get() {
                    return this.$vuetify.breakpoint.smAndDown || !this.toggleMini;
                },
                set(value) {
                    this.toggleMini = value;
                }
            },
            isMobile() {
                if (this.$vuetify.breakpoint.smAndDown) {
                    return this.sidebarMenu = false
                }
            },
            themeText() {
                return this.$vuetify.theme.dark ? '<?= lang('App.dark') ?>' : '<?= lang('App.light') ?>'
            }
        }
        var createdVue = function() {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        }
        var mountedVue = function() {
            const theme = localStorage.getItem("dark_theme");
            if (theme) {
                if (theme === "true") {
                    this.$vuetify.theme.dark = true;
                    this.dark = true;
                } else {
                    this.$vuetify.theme.dark = false;
                    this.dark = false;
                }
            } else if (
                window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            ) {
                this.$vuetify.theme.dark = false;
                localStorage.setItem(
                    "dark_theme",
                    this.$vuetify.theme.dark.toString()
                );
            }
        }
        var watchVue = {}
        var dataVue = {
            sidebarMenu: true,
            rightMenu: false,
            toggleMini: false,
            dark: false,
            group: null,
            search: '',
            loading: false,
            loading1: false,
            loading2: false,
            loading3: false,
            loading4: false,
            loading5: false,
            valid: true,
            notifMessage: '',
            notifType: '',
            snackbar: false,
            timeout: 4000,
            snackbarType: '',
            snackbarMessage: '',
            show: false,
            show1: false,
            rules: {
                email: v => !!(v || '').match(/@/) || '<?= lang('App.emailValid'); ?>',
                length: len => v => (v || '').length <= len || `<?= lang('App.invalidLength'); ?> ${len}`,
                password: v => !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
                    '<?= lang('App.strongPassword'); ?>',
                min: v => v.length >= 8 || '<?= lang('App.minChar'); ?>',
                required: v => !!v || '<?= lang('App.isRequired'); ?>',
                number: v => Number.isInteger(Number(v)) || "<?= lang('App.isNumber'); ?>",
                zero: v => v > 0 || "<?= lang('App.isZero'); ?>"
            },
        }
        var methodsVue = {
            toggleTheme() {
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
                localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
            }
        }
        Vue.component('paginate', VuejsPaginate)
    </script>
    <?= $this->renderSection('js') ?>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            computed: computedVue,
            data: dataVue,
            mounted: mountedVue,
            created: createdVue,
            watch: watchVue,
            methods: methodsVue
        })
    </script>
</body>

</html>