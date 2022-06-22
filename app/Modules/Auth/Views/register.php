<?php $this->extend("layouts/frontend"); ?>
<?php $this->section("content"); ?>
<v-container class="indigo px-4 py-0 fill-height mt-n5" fluid>
    <v-layout flex align-center justify-center>
        <v-flex xs12 sm6 md6>
            <v-card elevation="2" outlined>
                <v-card-text class="pa-6">
                    <h1 class="font-weight-normal text-center mb-10"><?= lang('App.register') ?></h1>
                    <v-alert v-if="notifType != ''" dense :type="notifType">{{notifMessage}}</v-alert>
                    <v-form v-model="valid" ref="form">
                        <v-text-field v-model="email" :rules="[rules.required, rules.email]" label="E-mail" outlined dense required :disabled="submitted"></v-text-field>
                        <v-text-field v-model="username" :rules="[rules.required]" label="Username" maxlength="20" outlined dense required :disabled="submitted"></v-text-field>
                        <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" label="Password" hint="<?= lang('App.minChar') ?>" counter @click:append="show1 = !show1" outlined dense :disabled="submitted"></v-text-field>
                        <v-text-field block v-model="verify" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, passwordMatch]" :type="show1 ? 'text' : 'password'" label="Confirm Password" counter @click:append="show1 = !show1" outlined dense :disabled="submitted"></v-text-field>
                        <v-layout class="mb-3">
                            <v-btn large block color="primary" @click="submit" :loading="loading" :disabled="submitted">Register</v-btn>
                        </v-layout>
                        <a href="<?= base_url('/login') ?>"><?= lang('App.haveAccount') ?></a>
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
        passwordMatch() {
            return () => this.password === this.verify || "<?= lang('App.samePassword') ?>";
        }
    }
    dataVue = {
        ...dataVue,
        show1: false,
        submitted: false,
        username: '',
        password: '',
        verify: '',
        email: '',
    }
    methodsVue = {
        ...methodsVue,
        submit() {
            this.loading = true;
            axios.post('<?= base_url() ?>/auth/register', {
                    email: this.email,
                    username: this.username,
                    password: this.password,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.submitted = true;
                        this.notifType = "success";
                        this.notifMessage = data.message;
                        this.$refs.form.resetValidation();
                        //setTimeout(() => window.location.href = data.data.url, 1000);
                    } else {
                        this.snackbar = true;
                        //this.snackbarType = "error";
                        this.snackbarMessage = data.message.email || data.message.password;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err.response);
                    this.loading = false
                })
        },
        clear() {
            this.$refs.form.reset()
        }
    }
</script>

<?php $this->endSection("js") ?>