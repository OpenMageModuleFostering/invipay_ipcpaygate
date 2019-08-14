<?php

/**
*   Copyright (C) 2016 inviPay.com
*   
*   http://www.invipay.com
*
*   @author Kuba Pilecki (kpilecki@invipay.com)
*   @version 1.0.4
*
*   Redistribution and use in source and binary forms, with or
*   without modification, are permitted provided that the following
*   conditions are met: Redistributions of source code must retain the
*   above copyright notice, this list of conditions and the following
*   disclaimer. Redistributions in binary form must reproduce the above
*   copyright notice, this list of conditions and the following disclaimer
*   in the documentation and/or other materials provided with the
*   distribution.
*   
*   THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED
*   WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
*   MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN
*   NO EVENT SHALL CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
*   INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
*   BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
*   OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
*   ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
*   TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
*   USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
*   DAMAGE.
*/

require_once(dirname(__FILE__) ."/PaymentRequestStatus.enum.php");
require_once(dirname(__FILE__) ."/../Contractor.class.php");
require_once(dirname(__FILE__) ."/../BaseApiData.class.php");

class PaymentData extends BaseApiData
{

    protected $paymentId;
    protected $transactionId;
    protected $buyer;
    protected $timeoutDate;
    protected $status;
    protected $note;

    public function getPaymentId(){ return $this->paymentId; }
    public function setPaymentId($paymentId){ $this->paymentId = $paymentId; }

    public function getTransactionId(){ return $this->transactionId; }
    public function setTransactionId($transactionId){ $this->transactionId = $transactionId; }

    public function getBuyer(){ return $this->buyer; }
    public function setBuyer(Contractor $buyer){ $this->buyer = $buyer; }

    public function getTimeoutDate(){ return $this->timeoutDate; }
    public function setTimeoutDate($timeoutDate){ $this->timeoutDate = $timeoutDate; }

    public function getStatus(){ return $this->status; }
    public function setStatus($status){ $this->status = $status; }

    public function getNote(){ return $this->note; }
    public function setNote($note){ $this->note = $note; }
}

?>