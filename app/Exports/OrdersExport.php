<?php
/**
 * Created by PhpStorm.
 * User: Motiur
 * Date: 5/20/2020
 * Time: 6:34 PM
 */

namespace App\Exports;
use App\OrderData;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromArray
{

    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }
}