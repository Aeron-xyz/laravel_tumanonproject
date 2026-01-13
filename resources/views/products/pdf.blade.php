<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Products Export</title>
    <style>
        @charset "UTF-8";
        * {
            font-family: DejaVu Sans, sans-serif;
        }
        body {
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Crochet Works Inventory</h1>
        <p>Exported on {{ now()->format('F j, Y g:i A') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Material</th>
                <th>Collection</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->material ?? 'N/A' }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>₱ {{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }} pcs</td>
                    <td>{{ $product->description ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

