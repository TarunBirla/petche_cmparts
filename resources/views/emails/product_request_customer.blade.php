<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote Request Received</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 650px; background: #ffffff; border-radius: 12px; overflow: hidden; padding: 25px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: #0A4744; color: #ffffff; padding: 25px; text-align: center; border-radius: 8px; }
        .header h2 { margin: 0; font-size: 22px; }
        .header p { margin: 5px 0 0 0; color: #F2A541; font-weight: bold; }
        .section { margin-top: 20px; }
        .section-title { font-size: 15px; font-weight: bold; color: #0F6B66; border-bottom: 2px solid #E7F4F3; padding-bottom: 5px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px 12px; border: 1px solid #e5e7eb; text-align: left; font-size: 13px; }
        th { background-color: #f8fafc; color: #475569; }
        .total-row { font-weight: bold; background-color: #f0f9ff; }
        .footer { text-align: center; font-size: 12px; color: #64748b; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Petchemparts</h2>
            <p>Quote Request Confirmation: #{{ $productRequest->request_number }}</p>
        </div>

        <div class="section">
            <p>Dear <strong>{{ $productRequest->customer_name }}</strong>,</p>
            <p>Thank you for submitting your quote request to Petchemparts! We have received your inquiry and our technical sales team is reviewing your requested items. You will receive a direct quotation shorty.</p>
        </div>

        <div class="section">
            <div class="section-title">Summary of Requested Parts</div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Part Number</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($productRequest->items as $index => $item)
                        @php 
                            $subtotal = $item->price * $item->quantity; 
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $item->product_name }}</strong></td>
                            <td>{{ $item->part_number ?? 'N/A' }}</td>
                            <td>£{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>£{{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="5" style="text-align: right;">Total Estimated Value:</td>
                        <td>£{{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($productRequest->notes)
            <div class="section">
                <div class="section-title">Your Requirements / Notes</div>
                <p style="background: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0;">{{ $productRequest->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>If you have urgent inquiries, please contact sales at <strong>sales@petchemparts.com</strong>.</p>
            <p>&copy; {{ date('Y') }} Petchemparts UK. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
