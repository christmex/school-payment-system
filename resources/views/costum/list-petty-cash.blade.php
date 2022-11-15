@extends(backpack_view('blank'))
@once
  @push('befor_styles')
  <livewire:styles/>
  @endpush
@endonce

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h2>
  </div>
@endsection

@section('content')
    <div class="row mb-3">
      <div class="col-sm-6">
        
        @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
          <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

            @include('crud::inc.button_stack', ['stack' => 'top'])

          </div>
        @endif
      </div>
    </div>
    <livewire:petty-cash.index :crud="$crud"/> 
@endsection
@once
  @push('after_scripts')
    <livewire:scripts/>
  @endpush
@endonce