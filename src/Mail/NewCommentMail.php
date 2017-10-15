<?php

namespace InetStudio\Comments\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\Comments\Models\CommentModel;

class NewCommentMail extends Mailable
{
    use SerializesModels;

    protected $comment;

    /**
     * NewCommentMail constructor.
     *
     * @param CommentModel $comment
     */
    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = config('app.name').' | '.((config('comments.mails.subject')) ? config('comments.mails.subject') : 'Новый комментарий');

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to(config('comments.mails.to'), '')
            ->subject($subject)
            ->view('admin.module.comments::mails.comment', ['comments' => $this->comment]);
    }
}
