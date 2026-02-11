<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: 'Jersey 10', Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 680px;
            margin: 20px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            border-top: 4px solid #079C40;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            color: #079C40;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2rem;
            color: #000000;
            line-height: 1.5;
        }

        .invoice-meta {
            margin: 12px 0 20px;
            font-size: 1rem;
            color: #444;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border-bottom: 1px solid #e6e6e6;
            padding: 10px;
            text-align: left;
            font-size: 1rem;
        }

        .table th {
            background: #f7f7f7;
            color: #222;
        }

        .total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            color: #079C40;
            margin-top: 15px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #C5C4C4;
            text-align: center;
            font-size: 1rem;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Gracias por tu compra, <?= htmlspecialchars($nombre) ?>!</h2>
    <p>Esta es la factura simulada de tu compra en <strong>SoccerFlow</strong>.</p>

    <div class="invoice-meta">
        <div><strong>Factura:</strong> <?= htmlspecialchars($invoiceId) ?></div>
        <div><strong>Fecha:</strong> <?= htmlspecialchars($invoiceDate) ?></div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Talla</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <?php
                $itemName = htmlspecialchars($item['name'] ?? 'Producto');
                $itemSize = htmlspecialchars($item['size'] ?? '-');
                $qty = (int)($item['quantity'] ?? 0);
                $price = number_format((float)($item['unit_price'] ?? 0), 2);
                $subtotal = number_format($qty * (float)($item['unit_price'] ?? 0), 2);
            ?>
            <tr>
                <td><?= $itemName ?></td>
                <td><?= $itemSize ?></td>
                <td><?= $qty ?></td>
                <td>$<?= $price ?></td>
                <td>$<?= $subtotal ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">Total: $<?= number_format($total, 2) ?></div>

    <div class="footer">
        © <?= date('Y') ?> SoccerFlow — Tu plataforma de fútbol
    </div>
</div>

</body>
</html>
