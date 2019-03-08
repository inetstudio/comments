<?php

namespace InetStudio\Comments\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\Comments\Contracts\Mail\AnswerMailContract;
use InetStudio\Comments\Contracts\Models\CommentModelContract;

/**
 * Class AnswerMail.
 */
class AnswerMail extends Mailable implements AnswerMailContract
{
    use SerializesModels;

    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * AnswerMail constructor.
     *
     * @param CommentModelContract $item
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
        $subject = config('app.name').' | '.((config('comments.mails_users.subject')) ? config('comments.mails_users.subject') : 'Ответ на комментарий');
        $headers = (config('comments.mails_users.headers')) ? config('comments.mails_users.headers') : [];

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($this->item->email, $this->item->name)
            ->subject($subject)
            ->withSwiftMessage(function ($message) use ($headers) {
                $messageHeaders = $message->getHeaders();

                foreach ($headers as $header => $value) {
                    $messageHeaders->addTextHeader($header, $value);
                }
            })
            ->view('admin.module.comments::mails.comment_user', ['item' => $this->item]);
    }
}
