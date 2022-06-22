<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <title>Print PDF</title>
    <style>
        .container {
            padding-left: 10px;
        }
        table {
            border: 1px solid #424242;
            border-collapse: collapse;
            padding: 0;
        }

        th {
            background-color: #f2f2f2;
            color: black;
            padding: 15px;
        }

        tr,
        td {
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 align="center">Laporan <?= $tgl_start; ?> &mdash; <?= $tgl_end; ?></h1>
        <h4>Penjualan</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No. Nota</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total</th>
                    <th scope="col">User</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td width="200"><?= $row['no_nota']; ?></td>
                    <td><?= $row['jumlah']; ?></td>
                    <td width="100"><?= $row['total']; ?></td>
                    <td width="100"><?= $row['nama']; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php 
                $jumlah = 0;
                $total = 0;
                
                foreach ($data as $row) {
                    $jumlah += $row['jumlah'];
                    $total += $row['total'];
                }
                ?>
                <tr>
                    <td colspan="1"></td>
                    <td align="right">Total</td>
                    <td><?= $jumlah; ?></td>
                    <td><?= $total; ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>