@extends('layouts.app')
@section('title', __('product.variations'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 style="display: inline-block">@lang('product.variations')
        <small>@lang('lang_v1.manage_product_variations')</small>
    </h1>
    @include('action_btn')
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.all_variations')])
        @slot('tool')
            <div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                data-href="{{action('VariationTemplateController@create')}}" 
                data-container=".variation_modal">
                <i class="fa fa-plus"></i> @lang('messages.add')</button>
            </div>
        @endslot
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="variation_table">
                <thead>
                    <tr>
                        <th>@lang('product.variations')</th>
                        <th>@lang('lang_v1.values')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent

    <div class="modal fade variation_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
