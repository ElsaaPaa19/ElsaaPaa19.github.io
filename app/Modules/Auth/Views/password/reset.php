<?php $this->extend("layouts/frontend"); ?>
<?php $this->section("content"); ?>
<v-container class="indigo px-4 py-0 fill-height mt-n10" fluid>
    <v-layout flex align-center justify-center>
        <v-flex xs12 sm6 md6>
            <v-card elevation="2" outlined>
                <v-card-text class="pa-10">
                    <h1 class="font-weight-normal text-center mb-10"><?= lang('App.forgotPass') ?></h1>
                    <v-alert v-if="notifType != ''" dense :type="notifType">{{notifMessage}}</v-alert>
                    <v-form v-model="valid" ref="form">
                        <v-text-field label="<?= lang('App.labelEmail') ?>" v-model="email" :rules="[rules.required, rules.email]" outlined :disabled="submitted"></v-text-field>
                        <v-layout justify-space-between>
                            <p>
                            <a href="<?= base_url('/login') ?>">Login</a><br/>
                            <a href="<?= base_url('/register') ?>"><?= lang('App.register') ?></a>
                            </p>
                            <v-spacer></v-spacer>
                            <v-btn large @click="submit" color="primary" :loading="loading" :disabled="submitted">Reset Password</v-btn>
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
    computedVue = {
        ...computedVue,
    }
    dataVue = {
        ...dataVue,
        show1: false,
        submitted: false,
        email: '',
    }
    methodsVue = {
        ...methodsVue,
        submit() {
            this.loading = true;
            axios.post('<?= base_url() ?>/api/auth/resetPassword', {
                    email: this.email
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.submitted = true;
                        this.notifMessage = data.message;
                        this.$refs.form.resetValidation();
                        //setTimeout(() => window.location.reload(), 1000);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message.email || data.message.password;
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