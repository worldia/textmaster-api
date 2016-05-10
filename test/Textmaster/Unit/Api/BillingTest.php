<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api;

class BillingTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllTransactions()
    {
        $expectedArray = array('transactions' => array());

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/transactions')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->transactions());
    }

    /**
     * @test
     */
    public function shouldShowAllInvoices()
    {
        $expectedArray = array(
            'invoices' => array(
                array(
                    'invoice_num' => '20141218-85E2-FM9',
                    'money_amount' => 48,
                    'type' => 'Transaction::CreditPurchase::BuyingACreditBundle',
                    'url' => '/clients/transactions/5492bca20ed4c0c25c000e69.pdf',
                    'issued_at' => array(
                        'day' => 18,
                        'month' => 12,
                        'year' => 2014,
                        'full' => '2014-12-18 14:38:10 +0300',
                    ),
                ),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/invoices')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->invoices());
    }

    /**
     * @test
     */
    public function shouldShowAllReceipts()
    {
        $expectedArray = array(
            'receipts' => array(
                array(
                    'invoice_num' => '20141218-85E3-FM8',
                    'money_amount' => -1.95918367,
                    'type' => 'Transaction::ProjectSpending::LaunchingAProject',
                    'issued_at' => array(
                        'day' => 18,
                        'month' => 12,
                        'year' => 2014,
                        'full' => '2014-12-18 14:38:11 +0300',
                    ),
                ),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/receipts')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->receipts());
    }

    /**
     * @test
     */
    public function shouldShowAllContracts()
    {
        $expectedArray = array(
            'negotiated_contracts' => array(
                array(
                    'id' => '561d19360ed4c037ac000543',
                    'name' => 'Special eCommerce 1',
                    'client_pricing' => -5,
                    'client_pricing_in_locale' => -0.0070000000000000001,
                ),
            ),
            'total_pages' => 0,
            'count' => 1,
            'page' => 1,
            'per_page' => 20,
            'previous_page' => null,
            'next_page' => null,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/negotiated_contracts')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->contracts());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Billing';
    }
}
