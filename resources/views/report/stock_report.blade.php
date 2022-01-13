@extends('layouts.app')
@section('title', __('report.stock_report'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ __('report.stock_report')}}</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
              {!! Form::open(['url' => action('ReportController@getStockReport'), 'method' => 'get', 'id' => 'stock_report_filter_form' ]) !!}
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('location_id',  __('purchase.business_location') . ':') !!}
                        {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('category_id', __('category.category') . ':') !!}
                        {!! Form::select('category', $categories, null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'category_id']); !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sub_category_id', __('product.sub_category') . ':') !!}
                        {!! Form::select('sub_category', array(), null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'sub_category_id']); !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('brand', __('product.brand') . ':') !!}
                        {!! Form::select('brand', $brands, null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('unit',__('product.unit') . ':') !!}
                        {!! Form::select('unit', $units, null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
                    </div>
                </div>
                @if($show_manufacturing_data)
                    <div class="col-md-3">
                        <div class="form-group">
                            <br>
                            <div class="checkbox">
                                <label>
                                  {!! Form::checkbox('only_mfg', 1, false, 
                                  [ 'class' => 'input-icheck', 'id' => 'only_mfg_products']); !!} {{ __('manufacturing::lang.only_mfg_products') }}
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
                {!! Form::close() !!}
            @endcomponent
        </div>
    </div>
    @can('view_product_stock_value')
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-solid'])
            <table class="table no-border">
                <tr>
                    <td>@lang('report.closing_stock') (@lang('lang_v1.by_purchase_price'))</td>
                    <td>@lang('report.closing_stock') (@lang('lang_v1.by_sale_price'))</td>
                    <td>@lang('lang_v1.potential_profit')</td>
                    <td>@lang('lang_v1.profit_margin')</td>
                </tr>
                <tr>
                    <td><h3 id="closing_stock_by_pp" class="mb-0 mt-0"></h3></td>
                    <td><h3 id="closing_stock_by_sp" class="mb-0 mt-0"></h3></td>
                    <td><h3 id="potential_profit" class="mb-0 mt-0"></h3></td>
                    <td><h3 id="profit_margin" class="mb-0 mt-0"></h3></td>
                </tr>
            </table>
            @endcomponent
        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-solid'])
                @include('report.partials.stock_report_table')
            @endcomponent
        </div>
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            //Stock report table
                    var stock_report_cols = [{
                            data: 'sku',
                            name: 'variations.sub_sku'
                        },
                        {
                            data: 'product',
                            name: 'p.name'
                        },
                        {
                            data: 'location_name',
                            name: 'l.name'
                        },
                        {
                            data: 'unit_price',
                            name: 'variations.sell_price_inc_tax'
                        },
                        {
                            data: 'total_stock',
                            name: 'total_stock',
                            searchable: false
                        },
                        {
                            data: 'stock',
                            name: 'stock',
                            searchable: false
                        },
                    ];
                    if ($('th.stock_price').length) {
                        stock_report_cols.push({
                            data: 'total_stock_price',
                            name: 'total_stock_price',
                            searchable: false
                        });

                        stock_report_cols.push({
                            data: 'current_stock_price',
                            name: 'current_stock_price',
                            searchable: false
                        });

                        stock_report_cols.push({
                            data: 'total_stock_value_by_sale_price',
                            name: 'total_stock_value_by_sale_price',
                            searchable: false,
                            orderable: false
                        });

                        stock_report_cols.push({
                            data: 'stock_value_by_sale_price',
                            name: 'stock_value_by_sale_price',
                            searchable: false,
                            orderable: false
                        });

                        stock_report_cols.push({
                            data: 'potential_profit_total_stock',
                            name: 'potential_profit_total_stock',
                            searchable: false,
                            orderable: false
                        });

                        stock_report_cols.push({
                            data: 'potential_profit_current_stock',
                            name: 'potential_profit_current_stock',
                            searchable: false,
                            orderable: false
                        });
                    }

                    stock_report_cols.push({
                        data: 'total_sold',
                        name: 'total_sold',
                        searchable: false
                    });
                    stock_report_cols.push({
                        data: 'total_sold_profit',
                        name: 'total_sold_profit',
                        searchable: false
                    });

                    stock_report_cols.push({
                        data: 'total_transfered',
                        name: 'total_transfered',
                        searchable: false
                    });
                    stock_report_cols.push({
                        data: 'total_adjusted',
                        name: 'total_adjusted',
                        searchable: false
                    });

                    // if ($('th.current_stock_mfg').length) {
                    //     stock_report_cols.push({ data: 'total_mfg_stock', name: 'total_mfg_stock', searchable: false });
                    // }
                    stock_report_table = $('#stock_report_tables').DataTable({
        processing: true,
        serverSide: true,
        scrollY: '75vh',
        scrollX: true,
        scrollCollapse: true,
        ajax: {
            url: '/reports/stock-report',
            data: function (d) {
                d.location_id = $('#location_id').val();
                d.category_id = $('#category_id').val();
                d.sub_category_id = $('#sub_category_id').val();
                d.brand_id = $('#brand').val();
                d.unit_id = $('#unit').val();

                d.only_mfg_products =
                    $('#only_mfg_products').length && $('#only_mfg_products').is(':checked')
                        ? 1
                        : 0;
            },
        },
        columns: stock_report_cols,
        fnDrawCallback: function (oSettings) {
            __currency_convert_recursively($('#stock_report_table'));
        },
        footerCallback: function (row, data, start, end, display) {
            var footer_total_stock = 0;
            var footer_current_stock = 0;
            var footer_total_sold = 0;
            var footer_total_sold_profit = 0;
            var footer_total_transfered = 0;
            var total_adjusted = 0;
            var total_stock_price = 0;
            var current_stock_price = 0;
            var footer_total_stock_value_by_sale_price = 0;
            var footer_stock_value_by_sale_price = 0;
            var total_stock_total_potential_profit = 0;
            var current_stock_total_potential_profit = 0;
            var footer_total_mfg_stock = 0;

            for (var r in data) {
                footer_total_stock += $(data[r].total_stock).data('orig-value')
                    ? parseFloat($(data[r].total_stock).data('orig-value'))
                    : 0;

                footer_current_stock += $(data[r].stock).data('orig-value')
                    ? parseFloat($(data[r].stock).data('orig-value'))
                    : 0;

                footer_total_sold += $(data[r].total_sold).data('orig-value')
                    ? parseFloat($(data[r].total_sold).data('orig-value'))
                    : 0;

                footer_total_sold_profit += $(data[r].total_sold_profit).data('orig-value')
                    ? parseFloat($(data[r].total_sold_profit).data('orig-value'))
                    : 0;

                footer_total_transfered += $(data[r].total_transfered).data('orig-value')
                    ? parseFloat($(data[r].total_transfered).data('orig-value'))
                    : 0;

                total_adjusted += $(data[r].total_adjusted).data('orig-value')
                    ? parseFloat($(data[r].total_adjusted).data('orig-value'))
                    : 0;

                total_stock_price += $(data[r].total_stock_price).data('orig-value')
                    ? parseFloat($(data[r].total_stock_price).data('orig-value'))
                    : 0;

                current_stock_price += $(data[r].current_stock_price).data('orig-value')
                    ? parseFloat($(data[r].current_stock_price).data('orig-value'))
                    : 0;

                footer_total_stock_value_by_sale_price += $(
                    data[r].total_stock_value_by_sale_price
                ).data('orig-value')
                    ? parseFloat($(data[r].total_stock_value_by_sale_price).data('orig-value'))
                    : 0;

                footer_stock_value_by_sale_price += $(data[r].stock_value_by_sale_price).data(
                    'orig-value'
                )
                    ? parseFloat($(data[r].stock_value_by_sale_price).data('orig-value'))
                    : 0;

                total_stock_total_potential_profit += $(data[r].potential_profit_total_stock).data(
                    'orig-value'
                )
                    ? parseFloat($(data[r].potential_profit_total_stock).data('orig-value'))
                    : 0;

                current_stock_total_potential_profit += $(
                    data[r].potential_profit_current_stock
                ).data('orig-value')
                    ? parseFloat($(data[r].potential_profit_current_stock).data('orig-value'))
                    : 0;

                footer_total_mfg_stock += $(data[r].total_mfg_stock).data('orig-value')
                    ? parseFloat($(data[r].total_mfg_stock).data('orig-value'))
                    : 0;
            }

            $('.footer_total_stock').html(footer_total_stock, false);
            $('.footer_current_stock').html(footer_current_stock, false);

            $('.footer_total_stock_price').html(total_stock_price);
            $('.footer_current_stock_price').html(current_stock_price);

            $('.footer_total_sold').html(__currency_trans_from_en(footer_total_sold, false));
            $('.footer_total_sold_profit').html(footer_total_sold_profit);

            $('.footer_total_transfered').html(
                __currency_trans_from_en(footer_total_transfered, false)
            );
            $('.footer_total_adjusted').html(__currency_trans_from_en(total_adjusted, false));

            $('.footer_total_stock_value_by_sale_price').html(
                footer_total_stock_value_by_sale_price
            );
            $('.footer_stock_value_by_sale_price').html(
                __currency_trans_from_en(footer_stock_value_by_sale_price)
            );

            $('.footer_potential_profit_total_stock').html(total_stock_total_potential_profit);
            $('.footer_potential_profit_current_stock').html(current_stock_total_potential_profit);

            // if ($('th.current_stock_mfg').length) {
            //     $('.footer_total_mfg_stock').html(__currency_trans_from_en(footer_total_mfg_stock, false));
            // }
        },
    });
        });
    </script>
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
@endsection