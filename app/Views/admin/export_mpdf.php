<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Print PDF</title>
    <style>
        table {
            font-family: sans-serif;
            border: 1px solid #424242;
            border-collapse: collapse;
        }

        th {
            background-color: #04AA6D;
            color: white;
            padding: 5px;
        }

        tr,
        td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 align="center" style="font-size: 24px;font-weight: bold">Sample mPDF</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Deskripsi Produk</th>
                    <th scope="col">Aktif</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>

</body>

</html>