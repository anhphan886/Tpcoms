<?php

namespace Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Repositories\AttributeGroup\AttributeGroupRepository;
use Modules\Product\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;
use Modules\Product\Repositories\Customer\CustomerRepository;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepository;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;
use Modules\Product\Repositories\Attribute\AttributeRepository;
use Modules\Product\Repositories\Attribute\AttributeRepositoryInterface;
use Modules\Product\Repositories\Contract\ContractRepository;
use Modules\Product\Repositories\Contract\ContractRepositoryInterface;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;
use Modules\Product\Repositories\Invoice\InvoiceRepository;
use Modules\Product\Repositories\Invoice\InvoiceRepositoryInterface;
use Modules\Product\Repositories\Order\OrderRepository;
use Modules\Product\Repositories\Order\OrderRepositoryInterface;
use Modules\Product\Repositories\Product\ProductRepository;
use Modules\Product\Repositories\Product\ProductRepositoryInterface;
use Modules\Product\Repositories\ProductTemplate\ProductTemplateRepository;
use Modules\Product\Repositories\ProductTemplate\ProductTemplateRepositoryInterface;
use Modules\Product\Repositories\ProductCategory\ProductCategoryRepository;
use Modules\Product\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use Modules\Product\Repositories\Receipt\ReceiptRepository;
use Modules\Product\Repositories\Receipt\ReceiptRepositoryInterface;
use Modules\Product\Repositories\Segment\SegmentRepository;
use Modules\Product\Repositories\Segment\SegmentRepositoryInterface;
use Modules\Product\Repositories\Vouchers\VouchersRepository;
use Modules\Product\Repositories\Vouchers\VouchersRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AttributeRepositoryInterface::class, AttributeRepository::class);
        $this->app->singleton(CodeGeneratorRepositoryInterface::class, CodeGeneratorRepository::class);
        $this->app->singleton(AttributeGroupRepositoryInterface::class, AttributeGroupRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(ProductTemplateRepositoryInterface::class, ProductTemplateRepository::class);
        $this->app->singleton(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->singleton(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->singleton(ReceiptRepositoryInterface::class, ReceiptRepository::class);
        $this->app->singleton(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->singleton(VouchersRepositoryInterface::class, VouchersRepository::class);
        $this->app->singleton(SegmentRepositoryInterface::class, SegmentRepository::class);
    }
}
