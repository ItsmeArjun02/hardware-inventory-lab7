
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Purchase Order Notification</title>
</head>
<body style="font-family:Arial,sans-serif; color:#334155; line-height:1.6;">

    <div style="max-width:600px; margin:20px auto; padding:25px; border:1px solid #e2e8f0; border-radius:10px;">

        <h2 style="color:#1e293b;">
            Hardware Inventory
        </h2>

        <h3>Purchase Order Status Notification</h3>

        <p>
            Dear {{ $purchaseOrder->supplier->contact_person }},
        </p>

        <p>
            This is to inform you that the status of your Purchase Order
            has been updated.
        </p>

        <div style="background:#f8fafc; padding:15px; border-radius:8px;">

            <p>
                <strong>Purchase Order Number:</strong>
                {{ $purchaseOrder->po_number }}
            </p>

            <p>
                <strong>Supplier:</strong>
                {{ $purchaseOrder->supplier->company_name }}
            </p>

            <p>
                <strong>Status:</strong>
                <span style="font-weight:bold;">
                    {{ ucfirst($status) }}
                </span>
            </p>

            <p>
                <strong>Order Date:</strong>
                {{ $purchaseOrder->order_date->format('F d, Y') }}
            </p>

            <p>
                <strong>Expected Delivery:</strong>
                {{ $purchaseOrder->expected_delivery_date
                    ? $purchaseOrder->expected_delivery_date->format('F d, Y')
                    : 'Not specified' }}
            </p>

            <p>
                <strong>Total Amount:</strong>
                ₱{{ number_format((float) $purchaseOrder->total_amount, 2) }}
            </p>

        </div>

        <p>
            Thank you for your business.
        </p>

        <p>
            Regards,<br>
            <strong>Hardware Inventory Management System</strong>
        </p>

    </div>

</body>
</html>
