<?php

namespace App\Mail;

use App\Models\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PurchaseOrder $purchaseOrder,
        public string $status
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Purchase Order ' . $this->purchaseOrder->po_number
                . ' - ' . ucfirst($this->status)
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase-orders.status'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
