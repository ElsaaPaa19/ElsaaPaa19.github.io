<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <h1 class="mb-2 font-weight-medium"><?= $title; ?></h1>
    <v-card class="mb-3" elevation="2">
        <v-card-title class="mb-3">File Upload
            <v-btn color="green white--text" outlined class="ms-2" link href="<?= base_url('files/Format_Import_Excel.xlsx'); ?>" elevation="1">
                <v-icon>mdi-download</v-icon> Download Format
            </v-btn>
        </v-card-title>
        <v-card-text>
            <template>
                <?php
                if (session()->getFlashdata('error')) {
                ?>
                    <v-alert text outlined color="deep-orange" icon="mdi-fire" dense>
                        <?= session()->getFlashdata('error') ?>
                    </v-alert>
                <?php } ?>

                <?php if (session()->getFlashdata('success')) { ?>
                    <v-alert text outlined outlined type="success" dense>
                        <?= session()->getFlashdata('success') ?>
                    </v-alert>
                <?php } ?>

                <form method="post" action="/excel/simpanExcel" enctype="multipart/form-data">
                    <v-file-input show-size label="Upload File anda disini" id="file" name="fileexcel" class="mb-2" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" :rules="[rules.required]" filled required></v-file-input>
                    <v-btn large type="submit" color="primary" elevation="1">
                        <v-icon>mdi-upload</v-icon> Upload
                    </v-btn>
                </form>

            </template>
        </v-card-text>
        <v-card-actions>

        </v-card-actions>
    </v-card>
</template>
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

    dataVue = {
        ...dataVue,

    }
    createdVue = function() {

    }

    methodsVue = {
        ...methodsVue,

    }
</script>
<?php $this->endSection("js") ?>