<?php

namespace InetStudio\CommentsPackage\Comments\Mail\Front;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Mail\Front\NewItemMailContract;

/**
 * Class NewItemMail.
 */
class NewItemMail extends Mailable implements NewItemMailContract
{
    use SerializesModels;

    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * NewItemMail constructor.
     *
     * @param  CommentModelContract  $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $subject = config('app.name').' | '.config('comments.mails_admins.subject', 'Новый комментарий');
        $headers = config('comments.mails_admins.headers', []);

        $to = config('comments.mails_admins.to');

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($to, '')
            ->subject($subject)
            ->withSwiftMessage(function ($message) use ($headers) {
                $messageHeaders = $message->getHeaders();

                foreach ($headers as $header => $value) {
                    $messageHeaders->addTextHeader($header, $value);
                }
            })
            ->view('admin.module.comments::mails.comment_admins', ['item' => $this->item]);
    }
}
