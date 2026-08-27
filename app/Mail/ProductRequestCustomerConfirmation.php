<?php

namespace App\Mail;

use App\Models\ProductRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductRequestCustomerConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public ProductRequest $productRequest;

    public function __construct(ProductRequest $productRequest)
    {
        $this->productRequest = $productRequest->load('items');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quote Request Received: #' . $this->productRequest->request_number . ' - Petchemparts',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.product_request_customer',
        );
    }
}
