<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<h2 class="mb-2">Export PDF</h2>
<v-row class="fill-height">
    <v-col>
        <v-card outlined elevation="1">
            <v-card-title>TCPDF</v-card-title>
            <v-card-text>
                TCPDF adalah kelas PHP perangkat lunak sumber bebas dan terbuka untuk menghasilkan dokumen PDF. TCPDF adalah satu-satunya pustaka berbasis PHP yang menyertakan dukungan lengkap untuk UTF-8 Unicode dan bahasa kanan-ke-kiri, termasuk algoritma dua arah.
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" href="<?= base_url('admin/export-tcpdf') ?>">
                    Lihat PDF
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
    <v-col>
        <v-card outlined elevation="1">
            <v-card-title>mPDF</v-card-title>
            <v-card-text>
                mPDF is a PHP library which generates PDF files from UTF-8 encoded HTML.

                It is based on FPDF and HTML2FPDF with a number of enhancements.

                The original author, Ian Back, wrote mPDF to output PDF files 'on-the-fly' from his website, handling different languages. It is slower than the original scripts
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" href="<?= base_url('admin/export-mpdf') ?>">
                    Lihat PDF
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
</v-row>
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