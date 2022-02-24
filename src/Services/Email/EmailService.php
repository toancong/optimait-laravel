<?php
/**
 * Created by PhpStorm.
 * User: themightysapien
 * Date: 11/23/14
 * Time: 11:48 AM
 */

namespace Optimait\Laravel\Services\Email;


use Closure;
use Mail;
use Optimait\Laravel\Exceptions\ApplicationException;

class EmailService
{
    private $attachments = array();
    private $to;
    private $from = null;
    private $cc;
    private $bcc;
    private $subject;
    private $sendAs;
    private $fromAs;

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param mixed $attachments
     */
    public function setAttachments($attachments)
    {
        /*format [name => '', file => '', mime => '']*/
        $attachments = $attachments && is_array($attachments) ? $attachments : [$attachments];
        $this->attachments[] = array_merge($this->attachments, $attachments);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param mixed $bcc
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
        return $this;
    }

    public function sendAs($name)
    {
        $this->sendAs = $name;
        return $this;
    }

    public function fromAs($name)
    {
        $this->fromAs = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCc()
    {
        return $this->cc;

    }

    /**
     * @param mixed $cc
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function sendEmail($view, $data, Closure $closure = null)
    {
        if (!is_null($closure) && is_callable($closure)) {
            $closure($this);
        }
        $emailService = $this;
        Mail::send($view, $data, function ($message) use ($emailService) {
            if (!is_null($emailService->getFrom())) {
                if (!is_null($this->fromAs)) {
                    $message->from($emailService->getFrom(), $this->fromAs);
                } else {
                    $message->from($emailService->getFrom());
                }
            }

            if (!is_null($this->sendAs)) {
                $message->to($emailService->getTo(), $this->sendAs);
            } else {
                $message->to($emailService->getTo());
            }

            $message->subject($emailService->getSubject());

            $bcc = $emailService->getBcc();
            if (!empty($bcc)) {
                foreach ($bcc as $b) {
                    $message->bcc($b);
                }
            }
            $cc = $emailService->getCc();
            if (!empty($cc)) {
                foreach ($cc as $b) {
                    $message->cc($b);
                }
            }
            $attachments = $emailService->getAttachments();
            if (!empty($attachments)) {
                //dd($attachments);
                foreach ($attachments as $file) {
                    if (is_array($file)) {
                        if (!isset($file['file']) || !isset($file['name']) || !isset($file['mime'])) {
                            throw new ApplicationException("Your attachment parameter is missing either of file, name or mime.");
                        }

                        $message->attach($file['file'], [
                            'as' => @$file['name'],
                            'mime' => @$file['mime']
                        ]);
                    } else {
                        $message->attach($file);
                    }

                }
            }
        });
    }
}
