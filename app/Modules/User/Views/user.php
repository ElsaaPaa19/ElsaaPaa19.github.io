<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h2><?= $title; ?></h2>
        </v-card-title>
        <v-toolbar flat>
            <v-btn color="indigo" dark @click="modalAddOpen" large elevation="1">
                <v-icon>mdi-account</v-icon> <?= lang('App.add') ?>
            </v-btn>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="<?= lang("App.search") ?>" single-line hide-details>
            </v-text-field>
        </v-toolbar>
        <v-data-table :headers="headers" :items="users" :items-per-page="10" :loading="loading" :search="search" class="elevation-1" loading-text="Sedang memuat... Harap tunggu" dense>
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.id_login}}</td>
                    <td>{{item.email}}</td>
                    <td>{{item.username}}</td>
                    <td>
                        <!--owner disable-->
                        <span v-if="item.username == ''">
                            <v-select v-model="item.role" name="role" :items="roles" item-text="label" item-value="value" label="Select" single-line disabled></v-select>
                        </span>
                        <span v-else>
                            <v-select v-model="item.role" name="role" :items="roles" item-text="label" item-value="value" label="Select" single-line @change="setRole(item)"></v-select>
                        </span>

                    </td>
                    <td>
                        <span v-if="item.username == ''">
                            <v-switch v-model="item.active" name="active" false-value="0" true-value="1" color="success" disabled></v-switch>
                        </span>
                        <span v-else>
                            <v-switch v-model="item.active" name="active" false-value="0" true-value="1" color="success" @click="setActive(item)"></v-switch>
                        </span>
                    </td>
                    <td>
                        <v-btn color="indigo" class="mr-3" @click="editItem(item)" icon>
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn color="grey darken-2" @click="changePassword(item)" class="mr-3" icon>
                            <v-icon>mdi-key-variant</v-icon>
                        </v-btn>
                        <span v-if="item.username == ''">
                            <v-btn color="red" icon disabled>
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </span>
                        <span v-else>
                            <v-btn color="red" @click="deleteItem(item)" icon>
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </span>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
    <!-- End Table List -->
</template>

<!-- Modal Add -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalAdd" persistent max-width="700px">
            <v-card>
                <v-card-title><?= lang('App.add') ?> User
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalAddClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-5">
                    <v-form v-model="valid" ref="form">
                        <v-text-field v-model="email" :rules="[rules.email]" label="E-mail" :error-messages="emailError" outlined></v-text-field>

                        <v-text-field v-model="userName" label="Username" maxlength="20" :error-messages="usernameError" outlined required></v-text-field>

                        <v-text-field label="Nama Lengkap *" v-model="nama" :error-messages="namaError" outlined></v-text-field>

                        <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.min]" :type="show1 ? 'text' : 'password'" label="Password" hint="<?= lang('App.minChar') ?>" counter @click:append="show1 = !show1" :error-messages="passwordError" outlined></v-text-field>

                        <v-text-field block v-model="verify" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[passwordMatch]" :type="show1 ? 'text' : 'password'" label="Confirm Password" counter @click:append="show1 = !show1" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveUser" :loading="loading">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Add -->

<!-- Modal Edit -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalEdit" persistent max-width="700px">
            <v-card>
                <v-card-title><?= lang('App.editUser') ?> {{emailEdit}}
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalEditClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-5">
                    <v-form ref="form" v-model="valid">
                        <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                        <v-text-field label="Email *" v-model="emailEdit" :rules="[rules.email]" outlined></v-text-field>

                        <v-text-field label="Username *" v-model="userNameEdit" :error-messages="usernameError" outlined disabled></v-text-field>

                        <v-text-field label="Nama Lengkap *" v-model="namaEdit" :error-messages="namaError" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateUser" :loading="loading">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.update') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Edit -->

<!-- Modal Password -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalPassword" persistent max-width="700px">
            <v-card>
                <v-card-title>Password {{emailEdit}}
                    <v-spacer></v-spacer>
                    <v-btn icon @click="changePassClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-5">
                    <v-form ref="form" v-model="valid">

                        <v-text-field label="Email *" v-model="emailEdit" :rules="[rules.email]" outlined disabled></v-text-field>

                        <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.min]" :type="show1 ? 'text' : 'password'" label="Password Baru" hint="<?= lang('App.minChar') ?>" counter @click:append="show1 = !show1" :error-messages="passwordError" outlined></v-text-field>

                        <v-text-field block v-model="verify" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[passwordMatch]" :type="show1 ? 'text' : 'password'" label="Confirm Password" counter @click:append="show1 = !show1" :error-messages="verifyError" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updatePassword" :loading="loading">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.update') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal -->

<!-- Modal Delete -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalDelete" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> Konfirmasi Hapus
                </v-card-title>
                <v-card-text>
                    <div class="mt-4">
                        <h2 class="font-weight-medium"><?= lang('App.delConfirm') ?></h2>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text large @click="modalDelete = false"><?= lang("App.no") ?></v-btn>
                    <v-btn color="primary" dark large @click="deleteUser" :loading="loading"><?= lang("App.yes") ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<!-- End Modal Delete -->
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
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
        search: "",
        headers: [{
            text: 'ID',
            value: 'id_login'
        }, {
            text: 'E-mail',
            value: 'email'
        }, {
            text: 'Username',
            value: 'username'
        }, {
            text: 'Role',
            value: 'role'
        }, {
            text: '<?= lang('App.action') ?>',
            value: 'actions',
            sortable: false
        }, ],
        users: [],
        roles: [{
            label: 'Admin',
            value: '1'
        }, {
            label: 'Owner',
            value: '2'
        }, ],
        modalAdd: false,
        modalEdit: false,
        modalDelete: false,
        modalPassword: false,
        userName: "",
        email: "",
        nama: "",
        role: "",
        active: "",
        userIdEdit: "",
        userNameEdit: "",
        emailEdit: "",
        namaEdit: "",
        userIdDelete: "",
        userNameDelete: "",
        show1: false,
        password: "",
        verify: "",
        verifyError: "",
        emailError: "",
        namaError: "",
        usernameError: "",
        passwordError: "",
        roleError: "",
        activeError: "",
    }

    createdVue = function() {
        this.getUsers();
    }

    computedVue = {
        ...computedVue,
        passwordMatch() {
            return () => this.password === this.verify || "<?= lang('App.samePassword') ?>";
        }
    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function() {
            this.modalAdd = true;
            this.notifType = "";
        },
        modalAddClose: function() {
            this.userName = "";
            this.email = "";
            this.modalAdd = false;
            this.$refs.form.resetValidation();
        },

        // Get User
        getUsers: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>/api/user', options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.users = data.data;
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

        // Save User
        saveUser: function() {
            this.loading = true;
            axios.post('<?= base_url(); ?>/api/user/save', {
                    email: this.email,
                    username: this.userName,
                    nama: this.nama,
                    password: this.password,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getUsers();
                        this.userName = "";
                        this.email = "";
                        this.nama = "";
                        this.password = "",
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

        // Get Item Edit
        editItem: function(user) {
            this.modalEdit = true;
            this.show = false;
            this.notifType = "";
            this.userIdEdit = user.id_login;
            this.userNameEdit = user.user;
            this.emailEdit = user.email;
            this.namaEdit = user.nama;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
        },

        //Update
        updateUser: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>/api/user/update/${this.userIdEdit}`, {
                    user: this.userNameEdit,
                    email: this.emailEdit,
                    nama: this.namaEdit,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getUsers();
                        this.modalEdit = false;
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

        // Get Item Delete
        deleteItem: function(item) {
            this.modalDelete = true;
            this.userIdDelete = item.id_login;
            this.userNameDelete = item.user;
        },

        // Delete
        deleteUser: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>/api/user/delete/${this.userIdDelete}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getUsers();
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

        // Set Item Active
        setActive: function(item) {
            this.loading = true;
            this.userIdEdit = item.id_login;
            this.active = item.active;
            axios.put(`<?= base_url(); ?>/api/user/setactive/${this.userIdEdit}`, {
                    active: this.active,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getUsers();
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

        // Set Role
        setRole: function(item) {
            this.loading = true;
            this.userIdEdit = item.id_login;
            this.role = item.role;
            axios.put(`<?= base_url(); ?>/api/user/setrole/${this.userIdEdit}`, {
                    role: this.role,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getUsers();
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

        // Change Password
        changePassword: function(user) {
            this.modalPassword = true;
            this.userIdEdit = user.id_login;
            this.userNameEdit = user.user;
            this.emailEdit = user.email;
            this.namaEdit = user.nama;
        },
        changePassClose: function() {
            this.modalPassword = false;
            this.$refs.form.resetValidation();
        },

        updatePassword() {
            this.loading = true;

            axios.post('<?= base_url() ?>/api/user/changepassword', {
                    email: this.emailEdit,
                    password: this.password,
                    verify: this.verify
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.submitted = true;
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.password = "";
                        this.verify = "";
                        this.modalPassword = false;
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
                        this.modalPassword = true;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading = false
                })
        },
    }
</script>
<?php $this->endSection("js") ?>