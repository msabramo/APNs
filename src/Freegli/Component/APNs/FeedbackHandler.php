<?php

namespace Freegli\Component\APNs;

class FeedbackHandler extends BaseHandler
{
    const PRODUCTION_HOST = 'feedback.push.apple.com';
    const SANDBOX_HOST    = 'feedback.sandbox.push.apple.com';
    const PORT            = '2196';

    /**
     * Get Feedbacks from stream.
     *
     * @return Feedback[]
     */
    public function getFeedbacks()
    {
        return $this->extract($this->fetch());
    }

    /**
     * Extract Feedbacks from a binary string.
     *
     * @param string $binaryString
     *
     * @return Feedback[]
     */
    public function extract($binaryString)
    {
        $feedbacks = array();
        foreach (str_split($binary, Feedback::LENGTH) as $binaryChunk) {
            $feedbacks[] = new Feedback($binaryChunk);
            //TODO log error
        }

        return $feedbacks;
    }

    /**
     * Get binay string from connection.
     *
     * @return string
     */
    public function fetch()
    {
        //TODO do it tuple by tuple?

        return stream_get_contents($this->getConnection());
    }
}
