<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderClosed extends Mailable
{
    use Queueable, SerializesModels;

    private $order;
    /**
     * Create a new message instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        switch ($this->order->status) {
            case 'closed':
                $msg = 'Order Closed';
                break;

            case 'canceled':
                $msg = 'Order Canceled';
                break;
        }

        return new Envelope(
            subject: $msg,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        switch ($this->order->status) {
            case 'closed':
                $msg = 'Your request has been approved. Thank you for your preference, your order will be shipped soon.';
                $msg2 = array('Stay tuned in our ','shop!',route('shop'));
                break;

            case 'canceled':
                $msg = 'Your request has been canceled.';
                $msg2 = array("Maybe you could still find something else that you like.",'Keep looking.',route('shop'));
                break;
        }
        $url = route('download.pdf',['order'=>$this->order]);
        return new Content(
            view: 'mail.order_closed',
            with: ['name'=>$this->order->customerRef->userRef->name,'url'=>$url,'info'=>$msg, 'info2'=>$msg2]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
