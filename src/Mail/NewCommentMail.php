<?php

namespace InetStudio\Comments\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\Comments\Contracts\Models\CommentModelContract;
use InetStudio\Comments\Contracts\Mail\NewCommentMailContract;

/**
 * Class NewCommentMail.
 */
class NewCommentMail extends Mailable implements NewCommentMailContract
{
    use SerializesModels;

    /**
     * @var CommentModelContract
     */
    protected $comment;

    /**
     * NewCommentMail constructor.
     *
     * @param CommentModelContract $comment
     */
    public function __construct(CommentModelContract $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $subject = config('app.name').' | '.((config('comments.mails_admins.subject')) ? config('comments.mails_admins.subject') : 'Новый комментарий');
        $headers = (config('comments.mails_admins.headers')) ? config('comments.mails_admins.headers') : [];

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
            ->view('admin.module.comments::mails.comment_admins', ['comment' => $this->comment]);
    }
}
