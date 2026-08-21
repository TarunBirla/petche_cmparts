<?php

namespace App\Mail;

use App\Models\ProductRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductRequestSubmitted extends Mailable
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
            subject: 'New Product Request Received: #' . $this->productRequest->request_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.product_request',
        );
    }
}
