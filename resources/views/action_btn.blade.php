@php
    $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];

    $common_settings = !empty(session('business.common_settings')) ? session('business.common_settings') : [];
    $pos_settings = !empty(session('business.pos_settings')) ? json_decode(session('business.pos_settings'), true) : [];

    $is_admin = auth()->user()->hasRole('Admin#' . session('business.id')) ? true : false;
@endphp

<div class="dropdown dropdown_1" style="display: inline-block;float: right">
    <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">
        More <span class="caret"></span>
    </button>

    {{--user management menu--}}
    @if (auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view'))
        @if(request()->is('users')||request()->is('roles')||request()->is('sales-commission-agents'))
            <ul class="dropdown-menu dropdown-menu_1">
                @if (auth()->user()->can('roles.view'))
                    <li>
                        <a class="{{request()->is('roles')?'dropdown_active':''}}" href="{{url(action('RoleController@index'))}}">{{__('user.roles')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('user.create'))
                    <li>
                        <a class="{{request()->is('sales-commission-agents')?'dropdown_active':''}}"
                           href="{{url(action('SalesCommissionAgentController@index'))}}">{{__('lang_v1.sales_commission_agents')}}</a>
                    </li>
                @endif
            </ul>
        @endif
    @endif


    {{--contacts menu--}}
    @if (auth()->user()->can('supplier.view') || auth()->user()->can('customer.view') || auth()->user()->can('supplier.view_own') || auth()->user()->can('customer.view_own'))
        @if (request()->input('type') == 'supplier'||request()->input('type') == 'customer'||request()->segment(1) == 'customer-group'||(request()->segment(1) == 'contacts' && request()->segment(2) == 'import'))
            <ul class="dropdown-menu dropdown-menu_1">
                @if (auth()->user()->can('customer.view') || auth()->user()->can('customer.view_own'))
                    <li>
                        <a class="{{request()->input('type') == 'customer'?'dropdown_active':''}}"
                           href="{{url(action('ContactController@index', ['type' => 'customer']))}}">{{__('report.customer')}}</a>
                    </li>

                    <li>
                        <a class="{{request()->segment(1) == 'customer-group'?'dropdown_active':''}}"
                           href="{{url(action('CustomerGroupController@index'))}}">{{__('lang_v1.customer_groups')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('supplier.create') || auth()->user()->can('customer.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'contacts' && request()->segment(2) == 'import'?'dropdown_active':''}}"
                           href="{{url(action('ContactController@getImportContacts'))}}">{{__('lang_v1.import_contacts')}}</a>
                    </li>
                @endif
            </ul>
        @endif
    @endif


    {{--prodcuts menu--}}
    @if (auth()->user()->can('product.view') || auth()->user()->can('product.create') ||
                auth()->user()->can('brand.view') || auth()->user()->can('unit.view') ||
                auth()->user()->can('category.view') || auth()->user()->can('brand.create') ||
                auth()->user()->can('unit.create') || auth()->user()->can('category.create'))

        @if (
            (request()->segment(1) == 'products' && request()->segment(2) == '')||
            (request()->segment(1) == 'products' && request()->segment(2) == 'create')||
            (request()->segment(1) == 'labels' && request()->segment(2) == 'show')||
            (request()->segment(1) == 'variation-templates')||
            (request()->segment(1) == 'import-products')||
            (request()->segment(1) == 'import-opening-stock')||
            (request()->segment(1) == 'selling-price-group')||
            (request()->segment(1) == 'units')||
            (request()->segment(1) == 'taxonomies' && request()->get('type') == 'product')||
            (request()->segment(1) == 'brands')||
            (request()->segment(1) == 'warranties')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                @if (auth()->user()->can('product.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'products' && request()->segment(2) == 'create'?'dropdown_active':''}}"
                           href="{{url(action('ProductController@create'))}}">{{__('product.add_product')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('product.view'))
                    <li>
                        <a class="{{request()->segment(1) == 'labels' && request()->segment(2) == 'show'?'dropdown_active':''}}"
                           href="{{url(action('LabelsController@show'))}}">{{__('barcode.print_labels')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('product.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'variation-templates'?'dropdown_active':''}}"
                           href="{{url(action('VariationTemplateController@index'))}}">{{__('product.variations')}}</a>
                    </li>

                    <li>
                        <a class="{{request()->segment(1) == 'import-products'?'dropdown_active':''}}"
                           href="{{url(action('ImportProductsController@index'))}}">{{__('product.import_products')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('product.opening_stock'))
                    <li>
                        <a class="{{request()->segment(1) == 'import-opening-stock'?'dropdown_active':''}}"
                           href="{{url(action('ImportOpeningStockController@index'))}}">{{__('lang_v1.import_opening_stock')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('product.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'selling-price-group'?'dropdown_active':''}}"
                           href="{{url(action('SellingPriceGroupController@index'))}}">{{__('lang_v1.selling_price_group')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('unit.view') || auth()->user()->can('unit.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'units'?'dropdown_active':''}}"
                           href="{{url(action('UnitController@index'))}}">{{__('unit.units')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('category.view') || auth()->user()->can('category.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'taxonomies' && request()->get('type') == 'product'?'dropdown_active':''}}"
                           href="{{url(action('TaxonomyController@index') . '?type=product')}}">{{__('category.categories')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('brand.view') || auth()->user()->can('brand.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'brands'?'dropdown_active':''}}"
                           href="{{url(action('BrandController@index'))}}">{{__('brand.brands')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('product.view'))
                    <li>
                        <a class="{{request()->segment(1) == 'warranties'?'dropdown_active':''}}"
                           href="{{url(action('WarrantyController@index'))}}">{{__('lang_v1.warranties')}}</a>
                    </li>
                @endif

            </ul>
        @endif
    @endif

    {{--purchase menu--}}
    @if (in_array('purchases', $enabled_modules) && (auth()->user()->can('purchase.view') || auth()->user()->can('purchase.create') || auth()->user()->can('purchase.update')))

        @if (
            (request()->segment(1) == 'purchase-order')||
            (request()->segment(1) == 'purchases' && request()->segment(2) == null)||
            (request()->segment(1) == 'purchases' && request()->segment(2) == 'create')||
            (request()->segment(1) == 'purchase-return')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                @if (!empty($common_settings['enable_purchase_order']) && (auth()->user()->can('purchase_order.view_all') || auth()->user()->can('purchase_order.view_own')))
                    <li>
                        <a class="{{request()->segment(1) == 'purchase-order'?'dropdown_active':''}}"
                           href="{{url(action('PurchaseOrderController@index'))}}">{{__('lang_v1.purchase_order')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('purchase.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'purchases' && request()->segment(2) == 'create'?'dropdown_active':''}}"
                           href="{{url(action('PurchaseController@create'))}}">{{__('purchase.add_purchase')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('purchase.update'))
                    <li>
                        <a class="{{request()->segment(1) == 'purchase-return'?'dropdown_active':''}}"
                           href="{{url(action('PurchaseReturnController@index'))}}">{{__('lang_v1.list_purchase_return')}}</a>
                    </li>
                @endif
            </ul>
        @endif
    @endif

    {{--sell menu--}}
    @if ($is_admin || auth()->user()->hasAnyPermission(['sell.view', 'sell.create', 'direct_sell.access', 'view_own_sell_only', 'view_commission_agent_sell', 'access_shipping', 'access_own_shipping', 'access_commission_agent_shipping', 'access_sell_return', 'direct_sell.view', 'direct_sell.update']))

        @if (
            (request()->segment(1) == 'sales-order')||
            (request()->segment(1) == 'sells' && request()->segment(2) == null)||
            (request()->segment(1) == 'sells' && request()->segment(2) == 'create' && empty(request()->get('status')))||
            (request()->segment(1) == 'pos' && request()->segment(2) == null)||
            (request()->segment(1) == 'pos' && request()->segment(2) == 'create')||
            (request()->get('status') == 'draft')||
            (request()->segment(1) == 'sells' && request()->segment(2) == 'drafts')||
            (request()->get('status') == 'quotation')||
            (request()->segment(1) == 'sells' && request()->segment(2) == 'quotations')||
            (request()->segment(1) == 'sell-return' && request()->segment(2) == null)||
            (request()->segment(1) == 'shipments')||
            (request()->segment(1) == 'discount')||
            (request()->segment(1) == 'subscriptions')||
            (request()->segment(1) == 'import-sales')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                @if (!empty($pos_settings['enable_sales_order']) && ($is_admin || auth()->user()->hasAnyPermission(['so.view_own', 'so.view_all', 'so.create'])))
                    <li>
                        <a class="{{request()->segment(1) == 'sales-order'?'dropdown_active':''}}"
                           href="{{url(action('SalesOrderController@index'))}}">{{__('lang_v1.sales_order')}}</a>
                    </li>
                @endif

                @if (in_array('add_sale', $enabled_modules) && auth()->user()->can('direct_sell.access'))
                    <li>
                        <a class="{{request()->segment(1) == 'sells' && request()->segment(2) == 'create' && empty(request()->get('status'))?'dropdown_active':''}}"
                           href="{{url(action('SellController@create'))}}">{{__('sale.add_sale')}}</a>
                    </li>
                @endif


                @if (auth()->user()->can('sell.create'))
                    @if (in_array('pos_sale', $enabled_modules))
                        @if (auth()->user()->can('sell.view'))
                            <li>
                                <a class="{{request()->segment(1) == 'pos' && request()->segment(2) == null?'dropdown_active':''}}"
                                   href="{{url(action('SellPosController@index'))}}">{{__('sale.list_pos')}}</a>
                            </li>
                        @endif

                        <li>
                            <a class="{{request()->segment(1) == 'pos' && request()->segment(2) == 'create'?'dropdown_active':''}}"
                               href="{{url(action('SellPosController@create'))}}">{{__('sale.pos_sale')}}</a>
                        </li>
                    @endif
                @endif


                @if (in_array('add_sale', $enabled_modules) && auth()->user()->can('direct_sell.access'))
                    <li>
                        <a class="{{request()->get('status') == 'draft'?'dropdown_active':''}}"
                           href="{{url(action('SellController@create', ['status' => 'draft']))}}">{{__('lang_v1.add_draft')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('list_drafts'))
                    <li>
                        <a class="{{request()->segment(1) == 'sells' && request()->segment(2) == 'drafts'?'dropdown_active':''}}"
                           href="{{url(action('SellController@getDrafts'))}}">{{__('lang_v1.list_drafts')}}</a>
                    </li>
                @endif

                @if (in_array('add_sale', $enabled_modules) && auth()->user()->can('direct_sell.access'))
                    <li>
                        <a class="{{request()->get('status') == 'quotation'?'dropdown_active':''}}"
                           href="{{url(action('SellController@create', ['status' => 'quotation']))}}">{{__('lang_v1.add_quotation')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('list_quotations'))
                    <li>
                        <a class="{{request()->segment(1) == 'sells' && request()->segment(2) == 'quotations'?'dropdown_active':''}}"
                           href="{{url(action('SellController@getQuotations'))}}">{{__('lang_v1.list_quotations')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('access_sell_return'))
                    <li>
                        <a class="{{request()->segment(1) == 'sell-return' && request()->segment(2) == null?'dropdown_active':''}}"
                           href="{{url(action('SellReturnController@index'))}}">{{__('lang_v1.list_sell_return')}}</a>
                    </li>
                @endif

                @if ($is_admin || auth()->user()->hasAnyPermission(['access_shipping', 'access_own_shipping', 'access_commission_agent_shipping']))
                    <li>
                        <a class="{{request()->segment(1) == 'shipments'?'dropdown_active':''}}"
                           href="{{url(action('SellController@shipments'))}}">{{__('lang_v1.shipments')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('discount.access'))
                    <li>
                        <a class="{{request()->segment(1) == 'discount'?'dropdown_active':''}}"
                           href="{{url(action('DiscountController@index'))}}">{{__('lang_v1.discounts')}}</a>
                    </li>
                @endif

                @if (in_array('subscription', $enabled_modules) && auth()->user()->can('direct_sell.access'))
                    <li>
                        <a class="{{request()->segment(1) == 'subscriptions'?'dropdown_active':''}}"
                           href="{{url(action('SellPosController@listSubscriptions'))}}">{{__('lang_v1.subscriptions')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('sell.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'import-sales'?'dropdown_active':''}}"
                           href="{{url(action('ImportSalesController@index'))}}">{{__('lang_v1.import_sales')}}</a>
                    </li>
                @endif
            </ul>
        @endif
    @endif


    {{--stock transfer menu--}}
    @if (in_array('stock_transfers', $enabled_modules) && (auth()->user()->can('purchase.view') || auth()->user()->can('purchase.create')))

        @if (
            (request()->segment(1) == 'stock-transfers' && request()->segment(2) == null)||
            (request()->segment(1) == 'stock-transfers' && request()->segment(2) == 'create')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                @if (auth()->user()->can('purchase.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'stock-transfers' && request()->segment(2) == 'create'?'dropdown_active':''}}"
                           href="{{url(action('StockTransferController@create'))}}">{{__('lang_v1.add_stock_transfer')}}</a>
                    </li>
                @endif

            </ul>
        @endif
    @endif

    {{--stock adjustment menu--}}
    @if (in_array('stock_adjustment', $enabled_modules) && (auth()->user()->can('purchase.view') || auth()->user()->can('purchase.create')))
        @if (
            (request()->segment(1) == 'stock-adjustments' && request()->segment(2) == null)||
            (request()->segment(1) == 'stock-adjustments' && request()->segment(2) == 'create')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                @if (auth()->user()->can('purchase.create'))
                    <li>
                        <a class="{{request()->segment(1) == 'stock-adjustments' && request()->segment(2) == 'create'?'dropdown_active':''}}"
                           href="{{url(action('StockAdjustmentController@create'))}}">{{__('stock_adjustment.add')}}</a>
                    </li>
                @endif

            </ul>
        @endif
    @endif

    {{--expense adjustment menu--}}
    @if (in_array('expenses', $enabled_modules) && (auth()->user()->can('all_expense.access') || auth()->user()->can('view_own_expense')))
        @if (
            (request()->segment(1) == 'expenses' && request()->segment(2) == null)||
            (request()->segment(1) == 'expenses' && request()->segment(2) == 'create')||
            (request()->segment(1) == 'expense-categories')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                @if (auth()->user()->can('expense.add'))
                    <li>
                        <a class="{{request()->segment(1) == 'expenses' && request()->segment(2) == 'create'?'dropdown_active':''}}"
                           href="{{url(action('ExpenseController@create'))}}">{{__('expense.add_expense')}}</a>
                    </li>
                @endif

                @if (auth()->user()->can('expense.add') || auth()->user()->can('expense.edit'))
                    <li>
                        <a class="{{request()->segment(1) == 'expense-categories'?'dropdown_active':''}}"
                           href="{{url(action('ExpenseCategoryController@index'))}}">{{__('expense.expense_categories')}}</a>
                    </li>
                @endif

            </ul>
        @endif
    @endif

    {{--Payment Accounts menu--}}
    @if (auth()->user()->can('account.access') && in_array('account', $enabled_modules))
        @if (
            (request()->segment(1) == 'account' && request()->segment(2) == 'account')||
            (request()->segment(1) == 'account' && request()->segment(2) == 'balance-sheet')||
            (request()->segment(1) == 'account' && request()->segment(2) == 'trial-balance')||
            (request()->segment(1) == 'account' && request()->segment(2) == 'cash-flow')||
            (request()->segment(1) == 'account' && request()->segment(2) == 'payment-account-report')
        )
            <ul class="dropdown-menu dropdown-menu_1">
                <li>
                    <a class="{{request()->segment(1) == 'account' && request()->segment(2) == 'balance-sheet'?'dropdown_active':''}}"
                       href="{{url(action('AccountReportsController@balanceSheet'))}}">{{__('account.balance_sheet')}}</a>
                </li>

                <li>
                    <a class="{{request()->segment(1) == 'account' && request()->segment(2) == 'trial-balance'?'dropdown_active':''}}"
                       href="{{url(action('AccountReportsController@trialBalance'))}}">{{__('account.trial_balance')}}</a>
                </li>

                <li>
                    <a class="{{request()->segment(1) == 'account' && request()->segment(2) == 'cash-flow'?'dropdown_active':''}}"
                       href="{{url(action('AccountController@cashFlow'))}}">{{__('lang_v1.cash_flow')}}</a>
                </li>

                <li>
                    <a class="{{request()->segment(1) == 'account' && request()->segment(2) == 'payment-account-report'?'dropdown_active':''}}"
                       href="{{url(action('AccountReportsController@paymentAccountReport'))}}">{{__('account.payment_account_report')}}</a>
                </li>
            </ul>
        @endif
    @endif

</div>