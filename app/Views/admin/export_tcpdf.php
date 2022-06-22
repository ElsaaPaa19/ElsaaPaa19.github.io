<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">  
    <title>Print PDF</title>
    <style>
        @media print {
            .table {
                font-family: sans-serif;
                color: #232323;
                border-collapse: collapse;
            }

            .table,
            th,
            td {
                border: 1px solid #BDBDBD;
            }
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 align="center">Sample TCPDF</h1>
        <table class="table">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Deskripsi Produk</th>
                <th>Aktif</th>
            </tr>
            <?php $no = 1; ?>
            <?php foreach ($product as $row) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['product_name']; ?></td>
                    <td>Rp.<?= $row['product_price']; ?></td>
                    <td><?= $row['product_description']; ?></td>
                    <td><?= $row['active']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>

</html>