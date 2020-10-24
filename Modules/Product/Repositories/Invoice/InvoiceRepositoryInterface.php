<?php


namespace Modules\Product\Repositories\Invoice;


 interface  InvoiceRepositoryInterface
{
     /**
      * function get detail invoice by invoice_no
      * @param int $invoice_no
      * @return mixed
      */
     public function getDetail($invoice_no);
     /**
      * function get detail invoice by invoice_no
      * @param int $invoice_no
      * @return mixed
      */
     public function updateInvoice(array $data, $invoice_id);

     public function getByInvoice($invoice_id);
     public function insertInvoiceExtend($invoice_no, $price, $content);
     public function editInvoiceExtend($invoice_extends_code, $price, $content);
     public function deleteInvoiceExtends($invoice_extends_code, $invoice_no);
     public function getInfoInvoiceExtends($invoice_extends_code);

}
