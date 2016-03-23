<?php

namespace Textmaster\Api;

/**
 * Billing.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Billing extends AbstractApi
{
    /**
     * List all transactions.
     *
     * @link https://fr.textmaster.com/documentation#transactions-get-all-transactions
     *
     * @return array
     */
    public function transactions()
    {
        return $this->get('clients/transactions');
    }

    /**
     * List all invoices.
     *
     * @link https://fr.textmaster.com/documentation#transactions-get-all-invoices
     *
     * @return array
     */
    public function invoices()
    {
        return $this->get('clients/invoices');
    }

    /**
     * List all receipts.
     *
     * @link https://fr.textmaster.com/documentation#transactions-get-all-receipts
     *
     * @return array
     */
    public function receipts()
    {
        return $this->get('clients/receipts');
    }

    /**
     * List all negotiated contracts.
     *
     * @link https://fr.textmaster.com/documentation#negotiated-contracts-get-my-negotiated-contract
     *
     * @return array
     */
    public function contracts()
    {
        return $this->get('clients/negotiated_contracts');
    }
}
