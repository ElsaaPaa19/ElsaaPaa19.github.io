<?php $this->extend("layouts/frontend"); ?>
<?php $this->section("content"); ?>
<v-container class="indigo px-4 py-0 fill-height mt-n10" fluid>
    <v-layout flex align-center justify-center>
        <v-flex xs12 sm5 md4>
            <v-card elevation="2" outlined>
                <v-card-text class="pa-10">
                    <h1 class="font-weight-normal text-center mb-15">Login</h1>
                    <v-form v-model="valid" ref="form">
                        <v-text-field label="<?= lang('App.labelEmail') ?>" v-model="email" :rules="[rules.email]" :error-messages="emailError" outlined></v-text-field>
                        <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.min]" :type="show1 ? 'text' : 'password'" label="Password" hint="<?= lang('App.minChar') ?>" @click:append="show1 = !show1" :error-messages="passwordError" counter outlined></v-text-field>
                        <v-layout justify-space-between>
                            <v-btn large @click="submit" color="primary" :loading="loading">Login</v-btn>
                            <v-spacer></v-spacer>
                            <p>
                                <!-- <a href="<?= base_url('/password/reset') ?>"><?= lang('App.forgotPass') ?></a><br />
                                <a href="<?= base_url('/register') ?>"><?= lang('App.register') ?></a> -->
                            </p>
                        </v-layout>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    var errorKeys = []
    computedVue = {
        ...computedVue,
    }
    dataVue = {
        ...dataVue,
        show1: false,
        email: "",
        emailError: "",
        password: "",
        passwordError: "",
    }
    methodsVue = {
        ...methodsVue,
        submit() {
            this.loading = true;
            axios.post('<?= base_url() ?>/auth/login', {
                    email: this.email,
                    password: this.password,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        localStorage.setItem('access_token', JSON.stringify(data.access_token));
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.$refs.form.resetValidation();
                        setTimeout(() => window.location.reload(), 1000);
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
                    this.loading = false
                })
        },
        clear() {
            this.$refs.form.reset()
        }
    }
</script>

<?php $this->endSection("js") ?>