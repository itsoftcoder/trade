<table class="table table-bordered table-striped" id="stock_report_tables">
    <thead>
        <tr>
            <th>SKU</th>
            <th>@lang('business.product')</th>
            <th>@lang('sale.location')</th>
            <th>@lang('sale.unit_price')</th>
            <th>Total Stock</th>
            <th>@lang('report.current_stock')</th>
            @can('view_product_stock_value')
                <th>Total Stock Value( <small>by purcharse price</small>)</th>
                <th class="stock_price">@lang('lang_v1.total_stock_price')
                    <br><small>(@lang('lang_v1.by_purchase_price'))</small></th>
                <th>Total Stock Value ( <small>by sale price </small>)</th>
                <th>@lang('lang_v1.total_stock_price') <br><small>(@lang('lang_v1.by_sale_price'))</small></th>
                <th>Potentital Profit / <small>Total Stock</small></th>
                <th>@lang('lang_v1.potential_profit') / <small>Current Stock</small> </th>
            @endcan
            <th>@lang('report.total_unit_sold')</th>
            <th>Total unit sold profit</th>
            <th>@lang('lang_v1.total_unit_transfered')</th>
            <th>@lang('lang_v1.total_unit_adjusted')</th>
            {{-- @if ($show_manufacturing_data)
                <th class="current_stock_mfg">@lang('manufacturing::lang.current_stock_mfg')
                    @show_tooltip(__('manufacturing::lang.mfg_stock_tooltip'))</th>
            @endif --}}
        </tr>
    </thead>
    <tfoot>
        <tr class="bg-gray font-17 text-center footer-total">
            <td colspan="4"><strong>@lang('sale.total'):</strong></td>
            <td class="footer_total_stock"></td>
            <td class="footer_current_stock"></td>
            @can('view_product_stock_value')
                <td class="footer_total_stock_price"></td>
                <td class="footer_current_stock_price"></td>
                <td class="footer_total_stock_value_by_sale_price"></td>
                <td class="footer_stock_value_by_sale_price"></td>
                <td class="footer_potential_profit_total_stock"></td>
                <td class="footer_potential_profit_current_stock"></td>
            @endcan
            <td class="footer_total_sold"></td>
            <td class="footer_total_sold_profit"></td>
            <td class="footer_total_transfered"></td>
            <td class="footer_total_adjusted"></td>
            {{-- @if ($show_manufacturing_data)
                <td class="footer_total_mfg_stock"></td>
            @endif --}}
        </tr>
    </tfoot>
</table>
