@extends('layouts.app')

@section('content')

@php
  $route = route('create_site');
@endphp

<main class="main" id="app">

  <section class="slice slice-md border-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <h2>Welcome back, {{ $user->first_name }}.</h2>
        </div>
      </div>
    </div>
  </section>

  <section class="container position-relative">
    <button type="button" class="addButton btn btn-primary position-absolute right-0" data-toggle="modal" data-target="#new_site_modal">
      <span class="btn-inner--icon">
        <i class="fas fa-plus mr-1"></i> New Site
      </span>
    </button>
  </section>

  <section class="slice slice-lg">
    <div class="container">

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h3 class="heading h5 mb-4">Sites</h3>

          <site-search :sites="{{ $sites }}"></site-search>

        </div>
      </div>

    </div>
  </section>

  <!-- MODAL -->
  <div class="modal modal-fluid fade" id="new_site_modal" tabindex="-1" role="dialog" aria-labelledby="new_site_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row justify-content-center">
            <div class="col-lg-8 text-center pt-4 pb-0">
              <h4 class="heading h3">Track a new site</h4>
              <p class="lead text-muted">
                Enter the information of the site you wish to monitor below:
              </p>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-lg-8 pt-4 pb-4">
              <div class="py-1">
                <new-site-form route={{$route}}></new-site-form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

@endsection
